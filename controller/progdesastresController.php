<?php

/**
 * progdesastresController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class progdesastresController Extends baseController {

    var $unid_id;

    function index() {
        $adm = new usuario();
        $admin = $adm->esAdm();
        $docpr = new Tab_docprevencion();
        //if(VAR1 !=null){
        $row = $docpr->dbSelectBySQL("SELECT * FROM tab_docprevencion WHERE dpr_tipo='" . VAR1 . "' AND dpr_estado='1'");

        if (count($row) == 0)
            $this->addDoc(); //eader("Location: ".PATH_DOMAIN."/docprevencion/add/".VAR1."/");
        else {
            $this->ver($row[0]->getUni_id());
            //$this->unid_id = $row[0]->getUni_id();
        }
//	}
//	else 	Header("Location: ".PATH_DOMAIN."/login/show/");
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
        $this->registry->template->show('tab_docProgDesastres.tpl');
    }

    function editDoc() {
        Header("Location: " . PATH_DOMAIN . "/progdesastres/viewDoc/" . $_REQUEST["dpr_id"] . "/");
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
        $this->registry->template->show('tab_docProgDesastres.tpl');
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
        //$limit = "LIMIT $start, $rp";
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
                        WHERE dpr_estado = 1 $where $sort "; //$limit
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
                        tab_docprevencion.dpr_estado =  '1' $where $sort "; //$limit
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
        Header("Location: " . PATH_DOMAIN . "/progdesastres/");
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

    function ver($uni_id) {
        $this->registry->template->des_id = "";
        $this->registry->template->dpr_id = "";
        $this->registry->template->uni_id = $uni_id;
        $this->registry->template->des_resumen = "";
        $this->registry->template->des_indicador = "";
        $this->registry->template->des_fuentes = "";
        $this->registry->template->des_riesgo = "";
        $this->registry->template->des_usu_reg = "";
        $this->registry->template->des_fecha_reg = "";
        $this->registry->template->des_usu_mod = "";
        $this->registry->template->des_fecha_mod = "";
        $this->registry->template->des_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_progdesastresg.tpl');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/progdesastres/view/" . $_REQUEST["des_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);
        $row = $this->progdesastres->dbselectByField("des_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->des_id = $row->des_id;
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $this->registry->template->des_resumen = $row->des_resumen;
        $this->registry->template->des_indicador = $row->des_indicador;
        $this->registry->template->des_fuentes = $row->des_fuentes;
        $this->registry->template->des_riesgo = $row->des_riesgo;
        $this->registry->template->des_usu_reg = $row->des_usu_reg;
        $this->registry->template->des_fecha_reg = $row->des_fecha_reg;
        $this->registry->template->des_usu_mod = $row->des_usu_mod;
        $this->registry->template->des_fecha_mod = $row->des_fecha_mod;
        $this->registry->template->des_estado = $row->des_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_progdesastres.tpl');
    }

    function load() {


        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'des_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        //$limit = "LIMIT $start, $rp";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";

        if ($query) {
            if ($qtype == 'des_id')
                $where = " AND $qtype = '$query' ";
            elseif ($qtype == 'dpr_id')
                $where = " AND $qtype IN (SELECT dpr_id FROM tab_docprevencion WHERE dpr_tipo LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT
	tab_progdesastres.des_id,
	tab_progdesastres.dpr_id,
	tab_progdesastres.des_resumen,
	tab_progdesastres.des_indicador,
	tab_progdesastres.des_fuentes,
	tab_progdesastres.des_riesgo
	FROM
	tab_docprevencion
	Inner Join tab_progdesastres ON tab_progdesastres.dpr_id = tab_docprevencion.dpr_id
	WHERE
	tab_progdesastres.des_estado =  '1'
	AND
	tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "'
	AND
	tab_docprevencion.dpr_tipo =  'progdesastres' $where $sort "; //$limit
        $result = $this->progdesastres->dbselectBySQL($sql);
        $prog = new progdesastres();
        $total = $prog->count2($query, $qtype); //$this->progdesastres->count("des_estado",1);
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
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->des_id . "',";
            $json .= "cell:['" . $un->des_id . "'";
            $json .= ",'" . addslashes($un->des_resumen) . "'";
            $json .= ",'" . addslashes($un->des_indicador) . "'";
            $json .= ",'" . addslashes($un->des_fuentes) . "'";
            $json .= ",'" . addslashes($un->des_riesgo) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->des_id = "";
        $this->registry->template->dpr_id = "";
        $this->registry->template->des_resumen = "";
        $this->registry->template->des_indicador = "";
        $this->registry->template->des_fuentes = "";
        $this->registry->template->des_riesgo = "";
        $this->registry->template->des_usu_reg = "";
        $this->registry->template->des_fecha_reg = "";
        $this->registry->template->des_usu_mod = "";
        $this->registry->template->des_fecha_mod = "";
        $this->registry->template->des_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $docpr = new Tab_docprevencion();
        $this->registry->template->show('header');
        $this->registry->template->show('tab_progdesastres.tpl');
    }

    function save() {

        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);

        $adm = new usuario();
        $admin = $adm->esAdm();
        $docpr = new Tab_docprevencion();
        //if($admin) $row = $docpr->dbSelectBySQL("Select dpr_id From tab_docprevencion WHERE dpr_tipo='progdesastres' AND uni_id='".$_SESSION['UNI_ID']."' ");
        $row = $docpr->dbSelectBySQL("Select dpr_id From tab_docprevencion WHERE dpr_tipo='progdesastres' ");
        //echo ("Select dpr_id From tab_docprevencion WHERE dpr_tipo='progdesastres' AND uni_id='".$_SESSION['UNI_ID']."' ");
        $this->progdesastres->setDes_id($_REQUEST['des_id']);
        $this->progdesastres->setDpr_id($row[0]->dpr_id);
        //$this->progdesastres->setDpr_id($row[0]->dpr_id);
        $this->progdesastres->setDes_resumen($_REQUEST['des_resumen']);
        $this->progdesastres->setDes_indicador($_REQUEST['des_indicador']);
        $this->progdesastres->setDes_fuentes($_REQUEST['des_fuentes']);
        $this->progdesastres->setDes_riesgo($_REQUEST['des_riesgo']);
        $this->progdesastres->setDes_usu_reg($_SESSION['USU_ID']);

        $this->progdesastres->setDes_fecha_reg(date("Y-m-d"));
//$this->progdesastres->setDes_usu_mod = $_REQUEST['des_usu_mod'];
//$this->progdesastres->setDes_fecha_mod = $_REQUEST['des_fecha_mod'];
        $this->progdesastres->setDes_estado(1);
        $this->progdesastres->insert();

        Header("Location: " . PATH_DOMAIN . "/progdesastres/");
    }

    function update() {
        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);

        $this->progdesastres->setDes_id($_REQUEST['des_id']);
//$this->progdesastres->setDpr_id($_REQUEST['dpr_id']);
        $this->progdesastres->setDes_resumen($_REQUEST['des_resumen']);
        $this->progdesastres->setDes_indicador($_REQUEST['des_indicador']);
        $this->progdesastres->setDes_fuentes($_REQUEST['des_fuentes']);
        $this->progdesastres->setDes_riesgo($_REQUEST['des_riesgo']);
        $this->progdesastres->setDes_usu_mod($_SESSION['USU_ID']);
        $this->progdesastres->setDes_fecha_mod(date("Y-m-d"));
        $this->progdesastres->update();
        Header("Location: " . PATH_DOMAIN . "/progdesastres/");
    }

    function delete() {
        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);

        $this->progdesastres->setDes_id($_REQUEST['des_id']);
        $this->progdesastres->setDes_usu_mod($_SESSION['USU_ID']);
        $this->progdesastres->setDes_fecha_mod(date("Y-m-d"));
        $this->progdesastres->setDes_estado(2);

        $this->progdesastres->update();
    }

    function verif() {

    }

}

?>
