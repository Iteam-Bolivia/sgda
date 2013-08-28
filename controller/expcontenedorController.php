<?php

/**
 * expcontenedorController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expcontenedorController Extends baseController {

    function index() {

        $this->registry->template->exc_id = "";
        $this->registry->template->euv_id = "<option value='1'>TEST</option>";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->con_id = "<option value='1'>TEST</option>";
        $this->registry->template->exc_fecha_reg = "";
        $this->registry->template->exc_usu_reg = "";
        $this->registry->template->exc_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_expcontenedorg.tpl');
    }

    function view() {
        $this->expcontenedor = new tab_expcontenedor();
        $this->expcontenedor->setRequest2Object($_REQUEST);
        $row = $this->expcontenedor->dbselectByField("exc_id", $_REQUEST["exc_id"]);
        $row = $row[0];
        $this->registry->template->exc_id = $row->exc_id;
        $this->registry->template->euv_id = "<option value='1'>TEST</option>";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->con_id = "<option value='1'>TEST</option>";
        $this->registry->template->exc_fecha_reg = $row->exc_fecha_reg;
        $this->registry->template->exc_usu_reg = $row->exc_usu_reg;
        $this->registry->template->exc_estado = $row->exc_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_expcontenedor.tpl');
    }

    function load() {


        $this->expcontenedor = new tab_expcontenedor();
        $this->expcontenedor->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'exc_id';
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
            $sql = "SELECT * FROM tab_expcontenedor $where and exc_estado = 1 $sort $limit";
        } else {
            $sql = "SELECT * FROM tab_expcontenedor WHERE exc_estado = 1 $sort $limit";
        }
        $result = $this->expcontenedor->dbselectBySQL($sql);
        $total = $this->expcontenedor->count("exc_estado", 1);
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
            $json .= "id:'" . $un->exc_id . "',";
            $json .= "cell:['" . $un->exc_id . "'";
            $json .= ",'" . addslashes($un->euv_id) . "'";
            $json .= ",'" . addslashes($un->exp_id) . "'";
            $json .= ",'" . addslashes($un->con_id) . "'";
            $json .= ",'" . addslashes($un->exc_fecha_reg) . "'";
            $json .= ",'" . addslashes($un->exc_usu_reg) . "'";
            $json .= ",'" . addslashes($un->exc_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->exc_id = "";
        $this->registry->template->euv_id = "<option value='1'>TEST</option>";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->con_id = "<option value='1'>TEST</option>";
        $this->registry->template->exc_fecha_reg = "";
        $this->registry->template->exc_usu_reg = "";
        $this->registry->template->exc_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_expcontenedor.tpl');
    }

    function save() {
        $this->expcontenedor = new tab_expcontenedor();
        $this->expcontenedor->setRequest2Object($_REQUEST);

        $this->expcontenedor->setExc_id = $_REQUEST['exc_id'];
        $this->expcontenedor->setEuv_id = $_REQUEST['euv_id'];
        $this->expcontenedor->setExp_id = $_REQUEST['exp_id'];
        $this->expcontenedor->setCon_id = $_REQUEST['con_id'];
        $this->expcontenedor->setExc_fecha_reg = $_REQUEST['exc_fecha_reg'];
        $this->expcontenedor->setExc_usu_reg = $_REQUEST['exc_usu_reg'];
        $this->expcontenedor->setExc_estado = 1;

        $this->expcontenedor->insert();
        Header("Location: " . PATH_DOMAIN . "/expcontenedor/");
    }

    function update() {
        $this->expcontenedor = new tab_expcontenedor();
        $this->expcontenedor->setRequest2Object($_REQUEST);

        $this->expcontenedor->setExc_id = $_REQUEST['exc_id'];
        $this->expcontenedor->setEuv_id = $_REQUEST['euv_id'];
        $this->expcontenedor->setExp_id = $_REQUEST['exp_id'];
        $this->expcontenedor->setCon_id = $_REQUEST['con_id'];
        $this->expcontenedor->setExc_fecha_reg = $_REQUEST['exc_fecha_reg'];
        $this->expcontenedor->setExc_usu_reg = $_REQUEST['exc_usu_reg'];
        $this->expcontenedor->setExc_estado = $_REQUEST['exc_estado'];

        $this->expcontenedor->update();
        Header("Location: " . PATH_DOMAIN . "/expcontenedor/");
    }

    function delete() {
        $this->expcontenedor = new tab_expcontenedor();
        $this->expcontenedor->setRequest2Object($_REQUEST);

        $this->expcontenedor->setExc_id($_REQUEST['exc_id']);
        $this->expcontenedor->setExc_estado(2);

        $this->expcontenedor->update();
    }

    function verif() {

    }

}

?>
