<?php

/**
 * usurolmenuController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class usurolmenuController Extends baseController {

    function index() {
        $this->registry->template->urm_id = "";
        $this->registry->template->usu_id = "<option value='1'>TEST</option>";
        $this->registry->template->rol_id = "<option value='1'>TEST</option>";
        $this->registry->template->men_id = "<option value='1'>TEST</option>";
        $this->registry->template->urm_privilegios = "";
        $this->registry->template->urm_fecha_reg = "";
        $this->registry->template->urm_usu_reg = "";
        $this->registry->template->urm_fecha_mod = "";
        $this->registry->template->urm_usu_mod = "";
        $this->registry->template->urm_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_usurolmenug.tpl');
    }

    function view() {
        $this->usurolmenu = new tab_usurolmenu();
        $this->usurolmenu->setRequest2Object($_REQUEST);
        $row = $this->usurolmenu->dbselectByField("urm_id", $_REQUEST["urm_id"]);
        $row = $row[0];
        $this->registry->template->urm_id = $row->urm_id;
        $this->registry->template->usu_id = "<option value='1'>TEST</option>";
        $this->registry->template->rol_id = "<option value='1'>TEST</option>";
        $this->registry->template->men_id = "<option value='1'>TEST</option>";
        $this->registry->template->urm_privilegios = $row->urm_privilegios;
        $this->registry->template->urm_fecha_reg = $row->urm_fecha_reg;
        $this->registry->template->urm_usu_reg = $row->urm_usu_reg;
        $this->registry->template->urm_fecha_mod = $row->urm_fecha_mod;
        $this->registry->template->urm_usu_mod = $row->urm_usu_mod;
        $this->registry->template->urm_estado = $row->urm_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_usurolmenu.tpl');
    }

    function load() {
        $this->usurolmenu = new tab_usurolmenu();
        $this->usurolmenu->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'urm_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        // MODIFIED: CASTELLON
        $limit = "LIMIT $rp OFFSET $start ";
        //
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        if ($query) {
            $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * FROM tab_usurolmenu $where and urm_estado = 1 $sort $limit";
        } else {
            $sql = "SELECT * FROM tab_usurolmenu WHERE urm_estado = 1 $sort $limit";
        }
        $result = $this->usurolmenu->dbselectBySQL($sql);
        $total = $this->usurolmenu->count("urm_estado", 1);
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
            $json .= "id:'" . $un->urm_id . "',";
            $json .= "cell:['" . $un->urm_id . "'";
            $json .= ",'" . addslashes($un->usu_id) . "'";
            $json .= ",'" . addslashes($un->rol_id) . "'";
            $json .= ",'" . addslashes($un->men_id) . "'";
            $json .= ",'" . addslashes($un->urm_privilegios) . "'";
            $json .= ",'" . addslashes($un->urm_fecha_reg) . "'";
            $json .= ",'" . addslashes($un->urm_usu_reg) . "'";
            $json .= ",'" . addslashes($un->urm_fecha_mod) . "'";
            $json .= ",'" . addslashes($un->urm_usu_mod) . "'";
            $json .= ",'" . addslashes($un->urm_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->urm_id = "";
        $this->registry->template->usu_id = "<option value='1'>TEST</option>";
        $this->registry->template->rol_id = "<option value='1'>TEST</option>";
        $this->registry->template->men_id = "<option value='1'>TEST</option>";
        $this->registry->template->urm_privilegios = "";
        $this->registry->template->urm_fecha_reg = "";
        $this->registry->template->urm_usu_reg = "";
        $this->registry->template->urm_fecha_mod = "";
        $this->registry->template->urm_usu_mod = "";
        $this->registry->template->urm_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_usurolmenu.tpl');
    }

    function save() {
        $this->usurolmenu = new tab_usurolmenu();
        $this->usurolmenu->setRequest2Object($_REQUEST);

        $this->usurolmenu->setUrm_id = $_REQUEST['urm_id'];
        $this->usurolmenu->setUsu_id = $_REQUEST['usu_id'];
        $this->usurolmenu->setRol_id = $_REQUEST['rol_id'];
        $this->usurolmenu->setMen_id = $_REQUEST['men_id'];
        $this->usurolmenu->setUrm_privilegios = $_REQUEST['urm_privilegios'];
        $this->usurolmenu->setUrm_fecha_reg = $_REQUEST['urm_fecha_reg'];
        $this->usurolmenu->setUrm_usu_reg = $_REQUEST['urm_usu_reg'];
        $this->usurolmenu->setUrm_fecha_mod = $_REQUEST['urm_fecha_mod'];
        $this->usurolmenu->setUrm_usu_mod = $_REQUEST['urm_usu_mod'];
        $this->usurolmenu->setUrm_estado = 1;

        $this->usurolmenu->insert();
        Header("Location: " . PATH_DOMAIN . "/usurolmenu/");
    }

    function update() {
        $this->usurolmenu = new tab_usurolmenu();
        $this->usurolmenu->setRequest2Object($_REQUEST);

        $this->usurolmenu->setUrm_id = $_REQUEST['urm_id'];
        $this->usurolmenu->setUsu_id = $_REQUEST['usu_id'];
        $this->usurolmenu->setRol_id = $_REQUEST['rol_id'];
        $this->usurolmenu->setMen_id = $_REQUEST['men_id'];
        $this->usurolmenu->setUrm_privilegios = $_REQUEST['urm_privilegios'];
        $this->usurolmenu->setUrm_fecha_reg = $_REQUEST['urm_fecha_reg'];
        $this->usurolmenu->setUrm_usu_reg = $_REQUEST['urm_usu_reg'];
        $this->usurolmenu->setUrm_fecha_mod = $_REQUEST['urm_fecha_mod'];
        $this->usurolmenu->setUrm_usu_mod = $_REQUEST['urm_usu_mod'];
        $this->usurolmenu->setUrm_estado = $_REQUEST['urm_estado'];

        $this->usurolmenu->update();
        Header("Location: " . PATH_DOMAIN . "/usurolmenu/");
    }

    function delete() {
        $this->usurolmenu = new tab_usurolmenu();
        $this->usurolmenu->setRequest2Object($_REQUEST);
        $this->usurolmenu->setUrm_id($_REQUEST['urm_id']);
        $this->usurolmenu->setUrm_estado(2);
        $this->usurolmenu->update();
    }

    function verif() {

    }

}

?>
