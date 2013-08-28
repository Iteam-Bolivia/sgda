<?php

/**
 * localesController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class localesController Extends baseController {

    function index() {

        $this->registry->template->loc_id = "";
        $this->registry->template->loc_descripcion = "";
        $this->registry->template->loc_usu_reg = "";
        $this->registry->template->loc_usu_mod = "";
        $this->registry->template->loc_fecha_reg = "";
        $this->registry->template->loc_fecha_mod = "";
        $this->registry->template->loc_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_localesg.tpl');
    }

    function view() {
        $this->locales = new tab_locales();
        $this->locales->setRequest2Object($_REQUEST);
        $row = $this->locales->dbselectByField("loc_id", $_REQUEST["loc_id"]);
        $row = $row[0];
        $this->registry->template->loc_id = $row->loc_id;
        $this->registry->template->loc_descripcion = $row->loc_descripcion;
        $this->registry->template->loc_usu_reg = $row->loc_usu_reg;
        $this->registry->template->loc_usu_mod = $row->loc_usu_mod;
        $this->registry->template->loc_fecha_reg = $row->loc_fecha_reg;
        $this->registry->template->loc_fecha_mod = $row->loc_fecha_mod;
        $this->registry->template->loc_estado = $row->loc_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_locales.tpl');
    }

    function load() {


        $this->locales = new tab_locales();
        $this->locales->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'loc_id';
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
            $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * FROM tab_locales $where and loc_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * FROM tab_locales WHERE loc_estado = 1 $sort $limit ";
        }
        $result = $this->locales->dbselectBySQL($sql);
        $total = $this->locales->count("loc_estado", 1);
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
            $json .= "id:'" . $un->loc_id . "',";
            $json .= "cell:['" . $un->loc_id . "'";
            $json .= ",'" . addslashes($un->loc_descripcion) . "'";
            $json .= ",'" . addslashes($un->loc_usu_reg) . "'";
            $json .= ",'" . addslashes($un->loc_usu_mod) . "'";
            $json .= ",'" . addslashes($un->loc_fecha_reg) . "'";
            $json .= ",'" . addslashes($un->loc_fecha_mod) . "'";
            $json .= ",'" . addslashes($un->loc_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->loc_id = "";
        $this->registry->template->loc_descripcion = "";
        $this->registry->template->loc_usu_reg = "";
        $this->registry->template->loc_usu_mod = "";
        $this->registry->template->loc_fecha_reg = "";
        $this->registry->template->loc_fecha_mod = "";
        $this->registry->template->loc_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_locales.tpl');
    }

    function save() {
        $this->locales = new tab_locales();
        $this->locales->setRequest2Object($_REQUEST);

        $this->locales->setLoc_id = $_REQUEST['loc_id'];
        $this->locales->setLoc_descripcion = $_REQUEST['loc_descripcion'];
        $this->locales->setLoc_usu_reg = $_REQUEST['loc_usu_reg'];
        $this->locales->setLoc_usu_mod = $_REQUEST['loc_usu_mod'];
        $this->locales->setLoc_fecha_reg = $_REQUEST['loc_fecha_reg'];
        $this->locales->setLoc_fecha_mod = $_REQUEST['loc_fecha_mod'];
        $this->locales->setLoc_estado = 1;

        $this->locales->insert();
        Header("Location: " . PATH_DOMAIN . "/locales/");
    }

    function update() {
        $this->locales = new tab_locales();
        $this->locales->setRequest2Object($_REQUEST);

        $this->locales->setLoc_id = $_REQUEST['loc_id'];
        $this->locales->setLoc_descripcion = $_REQUEST['loc_descripcion'];
        $this->locales->setLoc_usu_reg = $_REQUEST['loc_usu_reg'];
        $this->locales->setLoc_usu_mod = $_REQUEST['loc_usu_mod'];
        $this->locales->setLoc_fecha_reg = $_REQUEST['loc_fecha_reg'];
        $this->locales->setLoc_fecha_mod = $_REQUEST['loc_fecha_mod'];
        $this->locales->setLoc_estado = $_REQUEST['loc_estado'];

        $this->locales->update();
        Header("Location: " . PATH_DOMAIN . "/locales/");
    }

    function delete() {
        $this->locales = new tab_locales();
        $this->locales->setRequest2Object($_REQUEST);

        $this->locales->setLoc_id($_REQUEST['loc_id']);
        $this->locales->setLoc_estado(2);

        $this->locales->update();
    }

    function verif() {

    }

}

?>
