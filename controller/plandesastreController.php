<?php

/**
 * plandesastreController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class plandesastreController Extends baseController {

    var $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

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
        $this->registry->template->show('tab_docPlanDesastres.tpl');
    }

    function editDoc() {
        Header("Location: " . PATH_DOMAIN . "/plandesastre/viewDoc/" . $_REQUEST["dpr_id"] . "/");
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
        $this->registry->template->show('tab_docPlanDesastres.tpl');
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
        Header("Location: " . PATH_DOMAIN . "/plandesastre/");
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
        $this->registry->template->pla_id = "";
        $this->registry->template->dpr_id = "";
        $this->registry->template->pla_titulo = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_plandesastreg.tpl');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/plandesastre/view/" . $_REQUEST["pla_id"] . "/");
    }

    function view() {
        $this->plandesastre = new tab_plandesastre();
        $this->plandesastre->setRequest2Object($_REQUEST);
        $row = $this->plandesastre->dbselectByField("pla_id", VAR3);
        $row = $row[0];

        $plandesastre = new plandesastre();
        $mes = $plandesastre->obtenerSelectMes($row->pla_mes_inicial);
        $gestion = $plandesastre->obtenerSelectGestion($row->pla_gestion);

        $this->registry->template->pla_id = $row->pla_id;
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $this->registry->template->pla_titulo = $row->pla_titulo;
        $this->registry->template->pla_gestion = $gestion;
        $this->registry->template->pla_mes_inicial = $mes;
        $this->registry->template->pla_usu_reg = $row->pla_usu_reg;
        $this->registry->template->pla_usu_mod = $row->pla_usu_mod;
        $this->registry->template->pla_fecha_reg = $row->pla_fecha_reg;
        $this->registry->template->pla_fecha_mod = $row->pla_fecha_mod;
        $this->registry->template->pla_estado = $row->pla_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_plandesastre.tpl');
    }

    function load() {

        $this->plandesastre = new tab_plandesastre();
        $this->plandesastre->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'pla_id';
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
            if ($qtype == 'pla_id')
                $where = " AND $qtype LIKE '%$query%' ";
            elseif ($qtype == 'dpr_id')
                $where = " AND $qtype IN (SELECT dpr_id FROM tab_docprevencion WHERE dpr_tipo LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT
		tab_plandesastre.pla_id,
		tab_plandesastre.dpr_id,
		tab_plandesastre.pla_titulo,
		tab_plandesastre.pla_gestion,
		tab_plandesastre.pla_mes_inicial
		FROM
		tab_docprevencion
		Inner Join tab_plandesastre ON tab_plandesastre.dpr_id = tab_docprevencion.dpr_id
		$where AND
		tab_plandesastre.pla_estado =  '1'
		AND
		tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "'
		AND
		tab_docprevencion.dpr_tipo =  'plandesastre' $sort"; // $limit
        $result = $this->plandesastre->dbselectBySQL($sql);
        $plan = new plandesastre();
        $total = $plan->count2($query, $qtype); //$this->plandesastre->count("pla_estado",1);
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
            $json .= "id:'" . $un->pla_id . "',";
            $json .= "cell:['" . $un->pla_id . "'";
            $json .= ",'" . addslashes($un->pla_titulo) . "'";
            $json .= ",'" . addslashes($un->pla_gestion) . "'";
            $json .= ",'" . addslashes($un->pla_mes_inicial) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $mes = "";
        foreach ($this->meses as $m) {
            $mes .="<option value='$m'>$m</option>";
        }
        $plandesastre = new plandesastre();
        $mes = $plandesastre->obtenerSelectMes();
        $gestion = $plandesastre->obtenerSelectGestion();
        $this->registry->template->pla_id = "";
        $this->registry->template->dpr_id = "";
        $this->registry->template->pla_titulo = "";
        $this->registry->template->pla_gestion = $gestion;
        $this->registry->template->pla_mes_inicial = $mes;
        $this->registry->template->pla_usu_reg = "";
        $this->registry->template->pla_usu_mod = "";
        $this->registry->template->pla_fecha_reg = "";
        $this->registry->template->pla_fecha_mod = "";
        $this->registry->template->pla_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_plandesastre.tpl');
    }

    function save() {
        $this->plandesastre = new tab_plandesastre();
        $this->plandesastre->setRequest2Object($_REQUEST);
        $pland = new plandesastre();
        $row = $this->plandesastre->dbSelectBySQL("Select dpr_id From tab_docprevencion WHERE dpr_tipo='plandesastre' AND uni_id='" . $_SESSION['UNI_ID'] . "' ");

        $this->plandesastre->setPla_id($_REQUEST['pla_id']);
        $this->plandesastre->setDpr_id($row[0]->dpr_id);
        $this->plandesastre->setPla_titulo($_REQUEST['pla_titulo']);
        $this->plandesastre->setPla_gestion($_REQUEST['pla_gestion']);
        $this->plandesastre->setPla_mes_inicial($_REQUEST['pla_mes_inicial']);
        $this->plandesastre->setPla_usu_reg($_SESSION['USU_ID']);
        $this->plandesastre->setPla_fecha_reg(date("Y-m-d"));
        $this->plandesastre->setPla_estado(1);

        $this->plandesastre->insert();
        Header("Location: " . PATH_DOMAIN . "/plandesastre/");
    }

    function update() {
        $this->plandesastre = new tab_plandesastre();
        $this->plandesastre->setRequest2Object($_REQUEST);

        $this->plandesastre->setPla_id($_REQUEST['pla_id']);

        $this->plandesastre->setPla_titulo($_REQUEST['pla_titulo']);
        $this->plandesastre->setPla_gestion($_REQUEST['pla_gestion']);
        $this->plandesastre->setPla_mes_inicial($_REQUEST['pla_mes_inicial']);
        $this->plandesastre->setPla_usu_mod($_SESSION['USU_ID']);
        $this->plandesastre->setPla_fecha_mod(date("Y-m-d"));
        $this->plandesastre->update();
        Header("Location: " . PATH_DOMAIN . "/plandesastre/");
    }

    function delete() {
        $this->plandesastre = new tab_plandesastre();
        $this->plandesastre->setRequest2Object($_REQUEST);

        $this->plandesastre->setPla_id($_REQUEST['pla_id']);
        $this->plandesastre->setPla_estado(2);
        $this->plandesastre->update();
    }

    function verif() {

    }

}

?>
