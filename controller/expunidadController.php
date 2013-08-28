<?php

/**
 * expunidadController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expunidadController Extends baseController {

    function index() {

        $this->registry->template->euv_id = "";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->uni_id = "<option value='1'>TEST</option>";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->euv_fecha_crea = "";
        $this->registry->template->euv_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_expunidadg.tpl');
    }

    function view() {
        $this->expunidad = new tab_expunidad();
        $this->expunidad->setRequest2Object($_REQUEST);
        $row = $this->expunidad->dbselectByField("euv_id", $_REQUEST["euv_id"]);
        $row = $row[0];
        $this->registry->template->euv_id = $row->euv_id;
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->uni_id = "<option value='1'>TEST</option>";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->euv_fecha_crea = $row->euv_fecha_crea;
        $this->registry->template->euv_estado = $row->euv_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_expunidad.tpl');
    }

    function load() {


        $this->expunidad = new tab_expunidad();
        $this->expunidad->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'euv_id';
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
            $sql = "SELECT * FROM tab_expunidad $where and euv_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * FROM tab_expunidad WHERE euv_estado = 1 $sort $limit ";
        }
        $result = $this->expunidad->dbselectBySQL($sql);
        $total = $this->expunidad->count("euv_estado", 1);
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
            $json .= "id:'" . $un->euv_id . "',";
            $json .= "cell:['" . $un->euv_id . "'";
            $json .= ",'" . addslashes($un->exp_id) . "'";
            $json .= ",'" . addslashes($un->uni_id) . "'";
            $json .= ",'" . addslashes($un->ver_id) . "'";
            $json .= ",'" . addslashes($un->euv_fecha_crea) . "'";
            $json .= ",'" . addslashes($un->euv_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->euv_id = "";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->uni_id = "<option value='1'>TEST</option>";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->euv_fecha_crea = "";
        $this->registry->template->euv_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_expunidad.tpl');
    }

    function save() {
        $this->expunidad = new tab_expunidad();
        $this->expunidad->setRequest2Object($_REQUEST);

        $this->expunidad->setEuv_id = $_REQUEST['euv_id'];
        $this->expunidad->setExp_id = $_REQUEST['exp_id'];
        $this->expunidad->setUni_id = $_REQUEST['uni_id'];
        $this->expunidad->setVer_id = $_REQUEST['ver_id'];
        $this->expunidad->setEuv_fecha_crea = $_REQUEST['euv_fecha_crea'];
        $this->expunidad->setEuv_estado = 1;

        $this->expunidad->insert();
        Header("Location: " . PATH_DOMAIN . "/expunidad/");
    }

    function update() {
        $this->expunidad = new tab_expunidad();
        $this->expunidad->setRequest2Object($_REQUEST);

        $this->expunidad->setEuv_id = $_REQUEST['euv_id'];
        $this->expunidad->setExp_id = $_REQUEST['exp_id'];
        $this->expunidad->setUni_id = $_REQUEST['uni_id'];
        $this->expunidad->setVer_id = $_REQUEST['ver_id'];
        $this->expunidad->setEuv_fecha_crea = $_REQUEST['euv_fecha_crea'];
        $this->expunidad->setEuv_estado = $_REQUEST['euv_estado'];

        $this->expunidad->update();
        Header("Location: " . PATH_DOMAIN . "/expunidad/");
    }

    function delete() {
        $this->expunidad = new tab_expunidad();
        $this->expunidad->setRequest2Object($_REQUEST);

        $this->expunidad->setEuv_id($_REQUEST['euv_id']);
        $this->expunidad->setEuv_estado(2);

        $this->expunidad->update();
    }

    function verif() {

    }

}

?>
