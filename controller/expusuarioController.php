<?php

/**
 * expusuarioController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expusuarioController Extends baseController {

    function index() {

        $this->registry->template->eus_id = "";
        $this->registry->template->usu_id = "<option value='1'>TEST</option>";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->eus_fecha_crea = "";
        $this->registry->template->eus_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_expusuariog.tpl');
    }

    function view() {
        $this->expusuario = new tab_expusuario();
        $this->expusuario->setRequest2Object($_REQUEST);
        $row = $this->expusuario->dbselectByField("eus_id", $_REQUEST["eus_id"]);
        $row = $row[0];
        $this->registry->template->eus_id = $row->eus_id;
        $this->registry->template->usu_id = "<option value='1'>TEST</option>";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->eus_fecha_crea = $row->eus_fecha_crea;
        $this->registry->template->eus_estado = $row->eus_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_expusuario.tpl');
    }

    function load() {


        $this->expusuario = new tab_expusuario();
        $this->expusuario->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'eus_id';
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
            $sql = "SELECT * FROM tab_expusuario $where and eus_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * FROM tab_expusuario WHERE eus_estado = 1 $sort $limit ";
        }
        $result = $this->expusuario->dbselectBySQL($sql);
        $total = $this->expusuario->count("eus_estado", 1);
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
            $json .= "id:'" . $un->eus_id . "',";
            $json .= "cell:['" . $un->eus_id . "'";
            $json .= ",'" . addslashes($un->usu_id) . "'";
            $json .= ",'" . addslashes($un->exp_id) . "'";
            $json .= ",'" . addslashes($un->eus_fecha_crea) . "'";
            $json .= ",'" . addslashes($un->eus_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->eus_id = "";
        $this->registry->template->usu_id = "<option value='1'>TEST</option>";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->eus_fecha_crea = "";
        $this->registry->template->eus_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_expusuario.tpl');
    }

    function save() {
        $this->expusuario = new tab_expusuario();
        $this->expusuario->setRequest2Object($_REQUEST);

        $this->expusuario->setEus_id = $_REQUEST['eus_id'];
        $this->expusuario->setUsu_id = $_REQUEST['usu_id'];
        $this->expusuario->setExp_id = $_REQUEST['exp_id'];
        $this->expusuario->setEus_fecha_crea = $_REQUEST['eus_fecha_crea'];
        $this->expusuario->setEus_estado = 1;

        $this->expusuario->insert();
        Header("Location: " . PATH_DOMAIN . "/expusuario/");
    }

    function update() {
        $this->expusuario = new tab_expusuario();
        $this->expusuario->setRequest2Object($_REQUEST);

        $this->expusuario->setEus_id = $_REQUEST['eus_id'];
        $this->expusuario->setUsu_id = $_REQUEST['usu_id'];
        $this->expusuario->setExp_id = $_REQUEST['exp_id'];
        $this->expusuario->setEus_fecha_crea = $_REQUEST['eus_fecha_crea'];
        $this->expusuario->setEus_estado = $_REQUEST['eus_estado'];

        $this->expusuario->update();
        Header("Location: " . PATH_DOMAIN . "/expusuario/");
    }

    function delete() {
        $this->expusuario = new tab_expusuario();
        $this->expusuario->setRequest2Object($_REQUEST);

        $this->expusuario->setEus_id($_REQUEST['eus_id']);
        $this->expusuario->setEus_estado(2);

        $this->expusuario->update();
    }

    function verif() {

    }

}

?>
