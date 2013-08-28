<?php

/**
 * evalriesgosController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class evalriesgosController Extends baseController {

    function index() {
        $inl_id = '0'; //OFICINA o nivel 0 en el que se transfiere a otro custodio.
        $this->registry->template->titulo = "Documento de Evaluaci&oacute;n de Riesgos";
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->uni = new unidad ();
        $this->usu = new usuario ();
        $inst = new institucion();

        /* if($_SESSION["ROL_COD"]=="ADM") {
          $ins_id = 0;
          }else {
          $ins_id = $inst->obtenerIns_id($_SESSION['USU_ID']);
          }
          //Lista las unidades de la institucion $ins_id
          $this->registry->template->uni_id = $this->uni->listUnidad ($ins_id); */
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT1 = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('evalriesgosg.tpl');
        $this->registry->template->show('footer');
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
        $this->registry->template->show('tab_docEvalRiesgos.tpl');
    }

    function editDoc() {
        Header("Location: " . PATH_DOMAIN . "/evalriesgos/viewDoc/" . $_REQUEST["dpr_id"] . "/");
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
        $this->registry->template->show('tab_docEvalRiesgos.tpl');
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
                        WHERE dpr_estado = 1 $where $sort $limit "; //
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
        Header("Location: " . PATH_DOMAIN . "/evalriesgos/");
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
        $this->registry->template->eva_id = "";
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $this->registry->template->rie_id = "<option value='1'>TEST</option>";
        $this->registry->template->eva_frecuencia = "";
        $this->registry->template->eva_intensidad = "";
        $this->registry->template->eva_oficina = "";
        $this->registry->template->eva_usu_reg = "";
        $this->registry->template->eva_fecha_reg = "";
        $this->registry->template->eva_usu_mod = "";
        $this->registry->template->eva_fecha_mod = "";
        $this->registry->template->eva_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_evalriesgosg.tpl');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/evalriesgos/view/" . $_REQUEST["eva_id"] . "/");
    }

    function view() {
        $this->evalriesgos = new tab_evalriesgos();
        $this->evalriesgos->setRequest2Object($_REQUEST);
        $row = $this->evalriesgos->dbselectByField("eva_id", VAR3);
        $row = $row[0];
        $this->registry->template->eva_id = $row->eva_id;
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";

        $rie = new riesgos();
        $optionRiesgos = $rie->obtenerSelectRiesgos($row->rie_id);

        $this->registry->template->rie_id = $optionRiesgos;
        $this->registry->template->eva_frecuencia = $row->eva_frecuencia;
        $this->registry->template->eva_intensidad = $row->eva_intensidad;
        $this->registry->template->eva_oficina = $row->eva_oficina;
        $this->registry->template->eva_usu_reg = $row->eva_usu_reg;
        $this->registry->template->eva_fecha_reg = $row->eva_fecha_reg;
        $this->registry->template->eva_usu_mod = $row->eva_usu_mod;
        $this->registry->template->eva_fecha_mod = $row->eva_fecha_mod;
        $this->registry->template->eva_estado = $row->eva_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_evalriesgos.tpl');
    }

    function load() {

        $this->evalriesgos = new tab_evalriesgos();
        $this->evalriesgos->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'eva_id';
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
            if ($qtype == 'eva_id')
                $where = " AND $qtype = '$query' ";
            elseif ($qtype == 'riesgo')
                $where = " AND rie_id IN (SELECT rie_id from tab_riesgos WHERE rie_descripcion LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT
	tab_evalriesgos.eva_id,
	tab_evalriesgos.dpr_id,
	tab_evalriesgos.rie_id,
	tab_evalriesgos.eva_frecuencia,
	tab_evalriesgos.eva_intensidad,
	tab_evalriesgos.eva_oficina
	FROM
	tab_docprevencion
	Inner Join tab_evalriesgos ON tab_evalriesgos.dpr_id = tab_docprevencion.dpr_id
        WHERE
	tab_evalriesgos.eva_estado =  '1'
	AND
	tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "'
	AND
	tab_docprevencion.dpr_tipo =  'evalriesgos' $where $sort "; //$limit
        $result = $this->evalriesgos->dbselectBySQL($sql);
        $eval = new evalriesgos();
        $total = $eval->count2($query, $qtype);
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
        $rie = new tab_riesgos();
        foreach ($result as $un) {
            $riesgos = $rie->dbSelectBySQL("SELECT rie_descripcion FROM tab_riesgos WHERE
									rie_id='" . $un->rie_id . "' AND rie_estado='1' ");
            if (count($riesgos))
                $descripcion = $riesgos[0]->rie_descripcion;
            else
                $descripcion = "";
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->eva_id . "',";
            $json .= "cell:['" . $un->eva_id . "'";
            $json .= ",'" . addslashes($descripcion) . "'";
            $json .= ",'" . addslashes($un->eva_oficina) . "'";
            $json .= ",'" . addslashes($un->eva_frecuencia) . "'";
            $json .= ",'" . addslashes($un->eva_intensidad) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $rie = new riesgos();
        $optionRiesgos = $rie->obtenerSelectRiesgos();

        $this->registry->template->eva_id = "";
        $this->registry->template->dpr_id = "";
        $this->registry->template->rie_id = $optionRiesgos;
        $this->registry->template->eva_frecuencia = "";
        $this->registry->template->eva_intensidad = "";
        $this->registry->template->eva_oficina = "";
        $this->registry->template->eva_usu_reg = "";
        $this->registry->template->eva_fecha_reg = "";
        $this->registry->template->eva_usu_mod = "";
        $this->registry->template->eva_fecha_mod = "";
        $this->registry->template->eva_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_evalriesgos.tpl');
    }

    function save() {
        $this->evalriesgos = new tab_evalriesgos();
        $this->evalriesgos->setRequest2Object($_REQUEST);
        $docpr = new Tab_docprevencion();
        $row = $docpr->dbSelectBySQL("Select dpr_id From tab_docprevencion WHERE dpr_tipo='evalriesgos' AND uni_id='" . $_SESSION['UNI_ID'] . "' ");

        $this->evalriesgos->setEva_id($_REQUEST['eva_id']);
        $this->evalriesgos->setDpr_id($row[0]->dpr_id);
        $this->evalriesgos->setRie_id($_REQUEST['rie_id']);
        $this->evalriesgos->setEva_frecuencia($_REQUEST['eva_frecuencia']);
        $this->evalriesgos->setEva_intensidad($_REQUEST['eva_intensidad']);
        $this->evalriesgos->setEva_oficina($_REQUEST['eva_oficina']);
        $this->evalriesgos->setEva_usu_reg($_SESSION['USU_ID']);
        $this->evalriesgos->setEva_fecha_reg(date("Y-m-d"));
        $this->evalriesgos->setEva_estado(1);

        $this->evalriesgos->insert();
        Header("Location: " . PATH_DOMAIN . "/evalriesgos/");
    }

    function update() {
        $this->evalriesgos = new tab_evalriesgos();
        $this->evalriesgos->setRequest2Object($_REQUEST);

        $this->evalriesgos->setEva_id($_REQUEST['eva_id']);
        $this->evalriesgos->setRie_id($_REQUEST['rie_id']);
        $this->evalriesgos->setEva_frecuencia($_REQUEST['eva_frecuencia']);
        $this->evalriesgos->setEva_intensidad($_REQUEST['eva_intensidad']);
        $this->evalriesgos->setEva_oficina($_REQUEST['eva_oficina']);
        $this->evalriesgos->setEva_usu_mod($_SESSION['USU_ID']);
        $this->evalriesgos->setEva_fecha_mod(date("Y-m-d"));
        $this->evalriesgos->update();
        Header("Location: " . PATH_DOMAIN . "/evalriesgos/");
    }

    function delete() {
        $this->evalriesgos = new tab_evalriesgos();
        $this->evalriesgos->setRequest2Object($_REQUEST);

        $this->evalriesgos->setEva_id($_REQUEST['eva_id']);
        $this->evalriesgos->setEva_estado(2);

        $this->evalriesgos->update();
    }

    function verif() {

    }

}

?>
