<?php

/**
 * backupController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class backupController Extends baseController {

    function index() {

        $this->registry->template->bac_id = "";
        $this->registry->template->bac_accion = "";
        $this->registry->template->bac_file = "";
        $this->registry->template->bac_size = "";
        $this->registry->template->bac_fecha_crea = "";
        $this->registry->template->bac_usuario = "";
        $this->registry->template->bac_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_backupg.tpl');
    }

    function view() {
        $this->backup = new tab_backup();
        $this->backup->setRequest2Object($_REQUEST);
        $row = $this->backup->dbselectByField("bac_id", $_REQUEST["bac_id"]);
        $row = $row[0];
        $this->registry->template->bac_id = $row->bac_id;
        $this->registry->template->bac_accion = $row->bac_accion;
        $this->registry->template->bac_file = $row->bac_file;
        $this->registry->template->bac_size = $row->bac_size;
        $this->registry->template->bac_fecha_crea = $row->bac_fecha_crea;
        $this->registry->template->bac_usuario = $row->bac_usuario;
        $this->registry->template->bac_estado = $row->bac_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_backup.tpl');
    }

    function load() {


        $this->backup = new tab_backup();
        $this->backup->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'bac_id';
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
            $sql = "SELECT * FROM tab_backup $where and bac_estado = 1 $sort $limit";
        } else {
            $sql = "SELECT * FROM tab_backup WHERE bac_estado = 1 $sort $limit";
        }
        $result = $this->backup->dbselectBySQL($sql);
        $total = $this->backup->count("bac_estado", 1);
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
            $json .= "id:'" . $un->bac_id . "',";
            $json .= "cell:['" . $un->bac_id . "'";
            $json .= ",'" . addslashes($un->bac_accion) . "'";
            $json .= ",'" . addslashes($un->bac_file) . "'";
            $json .= ",'" . addslashes($un->bac_size) . "'";
            $json .= ",'" . addslashes($un->bac_fecha_crea) . "'";
            $json .= ",'" . addslashes($un->bac_usuario) . "'";
            $json .= ",'" . addslashes($un->bac_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->bac_id = "";
        $this->registry->template->bac_accion = "";
        $this->registry->template->bac_file = "";
        $this->registry->template->bac_size = "";
        $this->registry->template->bac_fecha_crea = "";
        $this->registry->template->bac_usuario = "";
        $this->registry->template->bac_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_backup.tpl');
    }

    function save() {
        $this->backup = new tab_backup();
        $this->backup->setRequest2Object($_REQUEST);

        $this->backup->setBac_id = $_REQUEST['bac_id'];
        $this->backup->setBac_accion = $_REQUEST['bac_accion'];
        $this->backup->setBac_file = $_REQUEST['bac_file'];
        $this->backup->setBac_size = $_REQUEST['bac_size'];
        $this->backup->setBac_fecha_crea = $_REQUEST['bac_fecha_crea'];
        $this->backup->setBac_usuario = $_REQUEST['bac_usuario'];
        $this->backup->setBac_estado = 1;

        $this->backup->insert();
        Header("Location: " . PATH_DOMAIN . "/backup/");
    }

    function update() {
        $this->backup = new tab_backup();
        $this->backup->setRequest2Object($_REQUEST);

        $this->backup->setBac_id = $_REQUEST['bac_id'];
        $this->backup->setBac_accion = $_REQUEST['bac_accion'];
        $this->backup->setBac_file = $_REQUEST['bac_file'];
        $this->backup->setBac_size = $_REQUEST['bac_size'];
        $this->backup->setBac_fecha_crea = $_REQUEST['bac_fecha_crea'];
        $this->backup->setBac_usuario = $_REQUEST['bac_usuario'];
        $this->backup->setBac_estado = $_REQUEST['bac_estado'];

        $this->backup->update();
        Header("Location: " . PATH_DOMAIN . "/backup/");
    }

    function delete() {
        $this->backup = new tab_backup();
        $this->backup->setRequest2Object($_REQUEST);

        $this->backup->setBac_id($_REQUEST['bac_id']);
        $this->backup->setBac_estado(2);

        $this->backup->update();
    }

    function verif() {

    }

}

?>
