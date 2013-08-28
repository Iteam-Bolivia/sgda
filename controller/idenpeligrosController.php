<?php

/**
 * idenpeligrosController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class idenpeligrosController Extends baseController {

    function index() {
        $adm = new usuario();
        $admin = $adm->esAdm();

        $docpr = new Tab_docprevencion();
        //if(VAR1 !=null){
        $row = $docpr->dbSelectBySQL("SELECT * FROM tab_docprevencion WHERE dpr_tipo='" . VAR1 . "' AND dpr_estado='1'");

        if (count($row) == 0)
            $this->addDoc(); //Header("Location: ".PATH_DOMAIN."/docprevencion/add/".VAR1."/");
        else
            $this->ver();
        //}
        //else 	Header("Location: ".PATH_DOMAIN."/login/show/");
    }

    function addDoc() {

        $tmenu = new tab_menu();
        $tipo = $tmenu->dbSelectBySQL("SELECT men_titulo FROM tab_menu WHERE men_enlace='" . VAR1 . "' ");

        $this->registry->template->dpr_id = "";
        $this->registry->template->tipo = $tipo[0]->men_titulo;
        $this->registry->template->dpr_tipo = VAR1;
        $this->registry->template->dpr_fecha_revision = "";
        $this->registry->template->dpr_productor = "";
        $this->registry->template->dpr_cargo_productor = "";

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "saveDoc";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('header');
        $this->registry->template->show('tab_docIdenPeligros.tpl');
    }

    function editDoc() {
        Header("Location: " . PATH_DOMAIN . "/idenpeligros/viewDoc/" . $_REQUEST["dpr_id"] . "/");
    }

    function viewDoc() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->docprevencion = new tab_docprevencion();
        $this->docprevencion->setRequest2Object($_REQUEST);

        $dpr = $this->docprevencion->dbSelectBySQL("SELECT * FROM tab_docprevencion WHERE dpr_id='" . VAR3 . "' ");
        if(! $dpr){ die("Error del sistema 404"); }
        $tmenu = new tab_menu();
        $tipo = $tmenu->dbSelectBySQL("SELECT men_titulo FROM tab_menu WHERE men_enlace='" . $dpr[0]->dpr_tipo . "' ");

        $row = $this->docprevencion->dbselectByField("dpr_id", VAR3);
        $row = $row[0];
        $this->registry->template->dpr_id = $row->dpr_id;
        $this->registry->template->dpr_tipo = $row->dpr_tipo;
        $this->registry->template->tipo = $tipo[0]->men_titulo;
        $this->registry->template->uni_id = "<option value='1'>TEST</option>";
        $this->registry->template->dpr_fecha_revision = $row->dpr_fecha_revision;
        $this->registry->template->dpr_productor = $row->dpr_productor;
        $this->registry->template->dpr_cargo_productor = $row->dpr_cargo_productor;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "updateIndex";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_docIdenPeligros.tpl');
    }

    function loadDoc() {

        $user = new usuario();
        $admin = $user->esAdm();
        $objUnidad = new unidad();
        $this->docprevencion = new tab_docprevencion();
        $this->docprevencion->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'dpr_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        if ($query) {
            if ($qtype == 'dpr_id')
                $where = " AND $qtype = '$query' ";
            elseif ($qtype == 'unidad')
                $where = " AND uni_id IN (SELECT uni_id FROM tab_unidad WHERE uni_codigo LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        if ($admin) {
            $sql = "SELECT * FROM tab_docprevencion
                        WHERE dpr_estado = 1 $where $sort $limit ";
        } else {
            $sql = "SELECT
                        tab_docprevencion.dpr_id,
                        tab_docprevencion.dpr_tipo,
                        tab_docprevencion.uni_id,
                        tab_docprevencion.dpr_fecha_revision,
                        tab_docprevencion.dpr_productor,
                        tab_docprevencion.dpr_usu_mod,
                        tab_docprevencion.dpr_estado
                        FROM
                        tab_docprevencion
                        WHERE
                        tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "' AND
                        tab_docprevencion.dpr_estado =  '1' $where $sort $limit ";
        }
        $result = $this->docprevencion->dbselectBySQL($sql);

        $doc = new docprevencion();
        $total = $doc->count2($query, $qtype, $admin); //$this->docprevencion->count("dpr_estado",1);
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: $total,\n";
        $json .= "rows: [";
        $rc = false;
        $i = 0;
        foreach ($result as $un) {
            $unidad = $objUnidad->dameDatosUnidad($un->uni_id);
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->dpr_id . "',";
            $json .= "cell:['" . $un->dpr_id . "'";
            $json .= ",'" . addslashes($un->dpr_tipo) . "'";
            $json .= ",'" . addslashes($unidad->uni_codigo) . "'";
            $json .= ",'" . addslashes($un->dpr_fecha_revision) . "'";
            $json .= ",'" . addslashes($un->dpr_productor) . "'";
            $json .= ",'" . addslashes($un->dpr_cargo_productor) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function saveDoc() {
        $this->docprevencion = new tab_docprevencion();
        $this->docprevencion->setRequest2Object($_REQUEST);

        $fecha = explode("/", $_REQUEST['dpr_fecha_revision']);
        $newFecha = $fecha[2] . "-" . $fecha[0] . "-" . $fecha[1];
        $this->docprevencion->setDpr_id($_REQUEST['dpr_id']);
        $this->docprevencion->setDpr_tipo($_REQUEST['dpr_tipo']);
        $this->docprevencion->setUni_id($_SESSION['UNI_ID']);
        $this->docprevencion->setDpr_fecha_revision($newFecha);
        $this->docprevencion->setDpr_productor($_REQUEST['dpr_productor']);
        $this->docprevencion->setDpr_cargo_productor($_REQUEST['dpr_cargo_productor']);
        $this->docprevencion->setDpr_fecha_crea(date("Y-m-d"));
        $this->docprevencion->setDpr_usu_crea($_SESSION['USU_ID']);
        $this->docprevencion->setDpr_estado(1);

        $id_dpr = $this->docprevencion->insert();

        //Header("Location: ".PATH_DOMAIN."/docprevencion/");
        //Header("Location: ".PATH_DOMAIN."/".$_REQUEST['dpr_tipo']."/index/".$id_dpr."/");


        Header("Location: " . PATH_DOMAIN . "/" . $_REQUEST['dpr_tipo'] . "/");
        return;
    }

    function updateDoc() {
        $this->docprevencion = new tab_docprevencion();
        $this->docprevencion->setRequest2Object($_REQUEST);

        $fecha = explode("/", $_REQUEST['dpr_fecha_revision']);
        $newFecha = $fecha[2] . "-" . $fecha[0] . "-" . $fecha[1];
        //$this->docprevencion->setDpr_id($_REQUEST['dpr_id']);
        $this->docprevencion->setDpr_tipo($_REQUEST['dpr_tipo']);
        $this->docprevencion->setUni_id($_SESSION['UNI_ID']);
        $this->docprevencion->setDpr_fecha_revision($_REQUEST['dpr_fecha_revision']); //($newFecha);
        $this->docprevencion->setDpr_productor($_REQUEST['dpr_productor']);
        $this->docprevencion->setDpr_cargo_productor($_REQUEST['dpr_cargo_productor']);
        $this->docprevencion->setDpr_fecha_mod(date("Y-m-d"));
        $this->docprevencion->setDpr_usu_mod($_SESSION['USU_ID']);
        $this->docprevencion->update();
        Header("Location: " . PATH_DOMAIN . "/idenpeligros/");
    }

    function addDocPrevencion() {

        $tmenu = new tab_menu();
        $tipo = $tmenu->dbSelectBySQL("SELECT men_titulo FROM tab_menu WHERE men_enlace='" . VAR1 . "' ");

        $this->registry->template->dpr_id = "";
        $this->registry->template->tipo = $tipo[0]->men_titulo;
        $this->registry->template->dpr_tipo = VAR1;
        $this->registry->template->dpr_fecha_revision = "";
        $this->registry->template->dpr_productor = "";
        $this->registry->template->dpr_cargo_productor = "";

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('header');
        $this->registry->template->show('tab_docprevencion.tpl');
    }

    function ver() {
        $this->registry->template->ide_id = "";
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $this->registry->template->loc_id = "<option value='1'>TEST</option>";
        $this->registry->template->ide_ele_ex = "";
        $this->registry->template->ide_peligros = "";
        $this->registry->template->ide_oficina = "";
        $this->registry->template->ide_observaciones = "";
        $this->registry->template->ide_usu_reg = "";
        $this->registry->template->ide_fecha_reg = "";
        $this->registry->template->ide_usu_mod = "";
        $this->registry->template->ide_fecha_mod = "";
        $this->registry->template->ide_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_idenpeligrosg.tpl');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/idenpeligros/view/" . $_REQUEST["ide_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->idenpeligros = new tab_idenpeligros();
        $this->idenpeligros->setRequest2Object($_REQUEST);
        $row = $this->idenpeligros->dbselectByField("ide_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->ide_id = $row->ide_id;
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $local = new locales();
        $locales = $local->obtenerSelectLocal($row->loc_id);

        $this->registry->template->loc_id = $locales;
        $elementos = explode("|", $row->ide_ele_ex);
        $peligros = explode("|", $row->ide_peligros);
        $chekP = "";
        $chekD = "";
        $chekE = "";
        $chekA = "";
        $chekM = "";
        $chekH = "";
        $chekI = "";
        $chekO = "";
        if (array_search("P", $elementos))
            $chekP = "checked";
        if (array_search("D", $elementos))
            $chekD = "checked";
        if (array_search("E", $elementos))
            $chekE = "checked";
        if (array_search("A", $elementos))
            $chekA = "checked";
        if (array_search("M", $elementos))
            $chekM = "checked";
        if (array_search("H", $elementos))
            $chekH = "checked";
        if (array_search("I", $elementos))
            $chekI = "checked";
        if (array_search("O", $elementos))
            $chekO = "checked";
        $this->registry->template->chekP = $chekP;
        $this->registry->template->chekD = $chekD;
        $this->registry->template->chekE = $chekE;
        $this->registry->template->chekA = $chekA;
        $this->registry->template->chekM = $chekM;
        $this->registry->template->chekH = $chekH;
        $this->registry->template->chekI = $chekI;
        $this->registry->template->chekO = $chekO;
        $chekp = "";
        $chekr = "";
        $cheki = "";
        $cheke = "";
        $cheka = "";
        $chekt = "";
        $chekh = "";
        $chekq = "";
        if (array_search("p", $peligros))
            $chekp = "checked";
        if (array_search("r", $peligros))
            $chekr = "checked";
        if (array_search("i", $peligros))
            $cheki = "checked";
        if (array_search("e", $peligros))
            $cheke = "checked";
        if (array_search("a", $peligros))
            $cheka = "checked";
        if (array_search("t", $peligros))
            $chekt = "checked";
        if (array_search("h", $peligros))
            $chekh = "checked";
        if (array_search("q", $peligros))
            $chekq = "checked";
        $this->registry->template->chekp = $chekp;
        $this->registry->template->chekr = $chekr;
        $this->registry->template->cheki = $cheki;
        $this->registry->template->cheke = $cheke;
        $this->registry->template->cheka = $cheka;
        $this->registry->template->chekt = $chekt;
        $this->registry->template->chekh = $chekh;
        $this->registry->template->chekq = $chekq;
        //echo "<br>$chekP,	$chekD,$chekE,$chekA, $chekM, $chekH,	$chekI,	$chekO ";
        //foreach($elementos as $elemento)	{
        //	if($elemento=="P") $chekP="checked";	}
//	$this->registry->template->ide_ele_ex = $row->ide_ele_ex;
//	$this->registry->template->ide_peligros = $row->ide_peligros;
        $this->registry->template->ide_oficina = $row->ide_oficina;
        $this->registry->template->ide_observaciones = $row->ide_observaciones;
        $this->registry->template->ide_usu_reg = $row->ide_usu_reg;
        $this->registry->template->ide_fecha_reg = $row->ide_fecha_reg;
        $this->registry->template->ide_usu_mod = $row->ide_usu_mod;
        $this->registry->template->ide_fecha_mod = $row->ide_fecha_mod;
        $this->registry->template->ide_estado = $row->ide_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_idenpeligros.tpl');
    }

    function load() {


        $this->idenpeligros = new tab_idenpeligros();
        $this->idenpeligros->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ide_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        if ($query) {
            if ($qtype == 'ide_id')
                $where = " AND $qtype = '$query' ";
            elseif ($qtype == 'loc_id')
                $where = " AND loc_id IN (SELECT loc_id FROM tab_locales WHERE loc_descripcion LIKE '%$query%') ";
            elseif ($qtype == 'dpr_id')
                $where = " AND $qtype IN (SELECT dpr_id FROM tab_docprevencion WHERE dpr_tipo LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT
		tab_idenpeligros.ide_id,
		tab_idenpeligros.dpr_id,
		tab_idenpeligros.loc_id,
		tab_idenpeligros.ide_ele_ex,
		tab_idenpeligros.ide_peligros,
		tab_idenpeligros.ide_oficina,
		tab_idenpeligros.ide_observaciones
		FROM
		tab_docprevencion
		Inner Join tab_idenpeligros ON tab_idenpeligros.dpr_id = tab_docprevencion.dpr_id
		WHERE
		tab_idenpeligros.ide_estado =  '1'
		AND
		tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "'
		AND
		tab_docprevencion.dpr_tipo =  'idenpeligros' $sort $where $limit ";
        $locales = new Tab_locales();

        $result = $this->idenpeligros->dbselectBySQL($sql);
        $iden = new idenpeligros();
        $total = $iden->count2($query, $qtype); //$this->idenpeligros->count("ide_estado",1);
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: $total,\n";
        $json .= "rows: [";
        $rc = false;
        $i = 0;
        foreach ($result as $un) {
            $descLocal = $locales->dbSelectBySQL("SELECT loc_descripcion FROM tab_locales WHERE
											loc_id ='" . $un->loc_id . "' AND loc_estado='1' ");
            if (count($descLocal))
                $descripcion = $descLocal[0]->loc_descripcion;
            else
                $descripcion = "";

            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->ide_id . "',";
            $json .= "cell:['" . $un->ide_id . "'";
            $json .= ",'" . addslashes($descripcion) . "'";
            $json .= ",'" . addslashes(substr($un->ide_ele_ex, 1, strlen($un->ide_ele_ex))) . "'";
            $json .= ",'" . addslashes(substr($un->ide_peligros, 1, strlen($un->ide_peligros))) . "'";
            $json .= ",'" . addslashes($un->ide_oficina) . "'";
            $json .= ",'" . addslashes($un->ide_observaciones) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->ide_id = "";
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $local = new locales();
        $locales = $local->obtenerSelectLocal();

        $this->registry->template->chekP = "";
        $this->registry->template->chekD = "";
        $this->registry->template->chekE = "";
        $this->registry->template->chekA = "";
        $this->registry->template->chekM = "";
        $this->registry->template->chekH = "";
        $this->registry->template->chekI = "";
        $this->registry->template->chekO = "";

        $this->registry->template->chekp = "";
        $this->registry->template->chekr = "";
        $this->registry->template->cheki = "";
        $this->registry->template->cheke = "";
        $this->registry->template->cheka = "";
        $this->registry->template->chekt = "";
        $this->registry->template->chekh = "";
        $this->registry->template->chekq = "";
        $this->registry->template->loc_id = $locales;
        $this->registry->template->ide_ele_ex = "";
        $this->registry->template->ide_peligros = "";
        $this->registry->template->ide_oficina = "";
        $this->registry->template->ide_observaciones = "";
        $this->registry->template->ide_usu_reg = "";
        $this->registry->template->ide_fecha_reg = "";
        $this->registry->template->ide_usu_mod = "";
        $this->registry->template->ide_fecha_mod = "";
        $this->registry->template->ide_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_idenpeligros.tpl');
    }

    function save() {

        $this->idenpeligros = new tab_idenpeligros();
        //$this->idenpeligros->setRequest2Object($_REQUEST);

        $docpr = new Tab_docprevencion();
        $row = $docpr->dbSelectBySQL("Select dpr_id From tab_docprevencion WHERE dpr_tipo='idenpeligros' AND uni_id='" . $_SESSION['UNI_ID'] . "' ");

        $this->idenpeligros->setIde_id($_REQUEST['ide_id']);
        $this->idenpeligros->setDpr_id($row[0]->dpr_id);
        $this->idenpeligros->setLoc_id($_REQUEST['loc_id']);
        $this->idenpeligros->setIde_oficina($_REQUEST['ide_oficina']);
        $this->idenpeligros->setIde_observaciones($_REQUEST['ide_observaciones']);
        $this->idenpeligros->setIde_usu_reg($_SESSION['USU_ID']);
        $this->idenpeligros->setIde_fecha_reg(date("Y-m-d"));
        $this->idenpeligros->setIde_estado(1);
        $cadPeligros = "";
        $cadElementos = "";
        if (isset($_REQUEST['ide_ele_ex']))
            $cadElementos = "|" . implode("|", $_REQUEST['ide_ele_ex']);
        if (isset($_REQUEST['ide_peligros']))
            $cadPeligros = "|" . implode("|", $_REQUEST['ide_peligros']);
        $this->idenpeligros->setIde_ele_ex($cadElementos);
        $this->idenpeligros->setIde_peligros($cadPeligros);
        $this->idenpeligros->insert();
        Header("Location: " . PATH_DOMAIN . "/idenpeligros/");
    }

    function update() {
        $this->idenpeligros = new tab_idenpeligros();
        //$this->idenpeligros->setRequest2Object($_REQUEST);

        $this->idenpeligros->setIde_id($_REQUEST['ide_id']);
        $this->idenpeligros->setLoc_id($_REQUEST['loc_id']);
        $this->idenpeligros->setIde_oficina($_REQUEST['ide_oficina']);
        $this->idenpeligros->setIde_observaciones($_REQUEST['ide_observaciones']);
        $this->idenpeligros->setIde_usu_mod($_SESSION['USU_ID']);
        $this->idenpeligros->setIde_fecha_mod(date("Y-m-d"));
        $cadPeligros = "";
        $cadElementos = "";
        if (isset($_REQUEST['ide_ele_ex']))
            $cadElementos = "|" . implode("|", $_REQUEST['ide_ele_ex']);
        if (isset($_REQUEST['ide_peligros']))
            $cadPeligros = "|" . implode("|", $_REQUEST['ide_peligros']);
        $this->idenpeligros->setIde_ele_ex($cadElementos);
        $this->idenpeligros->setIde_peligros($cadPeligros);
        $this->idenpeligros->update();
        Header("Location: " . PATH_DOMAIN . "/idenpeligros/");
    }

    function delete() {
        $this->idenpeligros = new tab_idenpeligros();
        $this->idenpeligros->setRequest2Object($_REQUEST);

        $this->idenpeligros->setIde_id($_REQUEST['ide_id']);
        $this->idenpeligros->setIde_estado(2);

        $this->idenpeligros->update();
    }

    function verif() {

    }

}

?>
