<?php

/**
 * archivoController
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class seccionController Extends baseController {

    function index() {
        $this->registry->template->sec_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_secciong.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $seccion = new seccion();
        $this->seccion = new tab_seccion();
        $this->seccion->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'sec_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15; //10
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";

        if ($query) {
            if ($qtype == 'sec_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT 
                sec.sec_codigo,
                sec.sec_nombre,
                sec.sec_id,
                uni.uni_codigo,
                uni.uni_descripcion
                FROM tab_seccion AS sec
                INNER JOIN tab_unidad AS uni ON sec.uni_id = uni.uni_id
                WHERE sec.sec_estado = 1 AND uni.uni_estado = 1 $where $sort $limit";

        $result = $this->seccion->dbselectBySQL($sql);
        $total = $seccion->count($where);

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
            $json .= "id:'" . $un->sec_id . "',";
            $json .= "cell:['" . $un->sec_id . "'";
            $json .= ",'" . addslashes($un->uni_descripcion) . "'";
            $json .= ",'" . addslashes($un->sec_codigo) . "'";
            $json .= ",'" . addslashes($un->sec_nombre) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/seccion/view/" . $_REQUEST["sec_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->seccion = new tab_seccion();
        $this->seccion->setRequest2Object($_REQUEST);
        $row = $this->seccion->dbselectByField("sec_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $unidad = new unidad();
        $this->registry->template->titulo = "EDITAR SECCIÓN";
        $this->registry->template->sec_id = $row->sec_id;
        $this->registry->template->uni_id = $unidad->listUnidad($row->uni_id);
        $this->registry->template->sec_nombre = $row->sec_nombre;
        $this->registry->template->sec_codigo = $row->sec_codigo;

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_seccion.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $unidad = new unidad();
        $this->registry->template->sec_id = "";
        $this->registry->template->uni_id = $unidad->listUnidad();
        $this->registry->template->sec_nombre = "";
        $this->registry->template->sec_codigo = "";

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->titulo = "NUEVA SECCIÓN";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_seccion.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->seccion = new tab_seccion();
        $this->seccion->setRequest2Object($_REQUEST);

        $this->seccion->setSec_id($_REQUEST['sec_id']);
        $this->seccion->setUni_id($_REQUEST['uni_id']);
        $this->seccion->setSec_codigo($_REQUEST['sec_codigo']);
        $this->seccion->setSec_nombre($_REQUEST['sec_nombre']);
        $this->seccion->setSec_estado(1);
        $sec_id = $this->seccion->insert();

        Header("Location: " . PATH_DOMAIN . "/seccion/");
    }

    function update() {
        $this->seccion = new tab_seccion();
        $this->seccion->setRequest2Object($_REQUEST);

        $rows = $this->seccion->dbselectByField("sec_id", $_REQUEST['sec_id']);
        $this->seccion = $rows[0];
        $id = $this->seccion->sec_id;

        $this->seccion->setsec_id($_REQUEST['sec_id']);
        $this->seccion->setUni_id($_REQUEST['uni_id']);
        $this->seccion->setsec_codigo($_REQUEST['sec_codigo']);
        $this->seccion->setsec_nombre($_REQUEST['sec_nombre']);
        $this->seccion->setsec_estado(1);

        $this->seccion->update();

        Header("Location: " . PATH_DOMAIN . "/seccion/");
    }

    function delete() {

        $this->seccion = new tab_seccion();

        $this->seccion->setsec_id($_REQUEST['sec_id']);
        $this->seccion->setsec_estado(0);
        $this->seccion->update();
    }

    function listDepartamentoJson() {
        $this->sec = new seccion();
        echo $this->sec->listDepartamentoJson();
    }

    function obtenerPro() {
        $provincia = new provincia();
        $res = $provincia->selectPro(0, $_REQUEST['Dep_id']);
        echo $res;
    }

}

?>
