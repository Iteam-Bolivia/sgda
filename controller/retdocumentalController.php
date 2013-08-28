<?php

/**
 * retdocumentalController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class retdocumentalController Extends baseController {

    function index() {

        $this->registry->template->ret_id = "";
        $this->registry->template->ret_par = "";
        $this->registry->template->ret_lugar = "";
        $this->registry->template->ret_anios = "";
        $this->registry->template->ret_usuario_crea = "";
        $this->registry->template->ret_fecha_crea = "";
        $this->registry->template->ret_fecha_mod = "";
        $this->registry->template->ret_usu_mod = "";
        $this->registry->template->ret_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('retdocumentalg.tpl');
    }

    function view() {
        $this->retdocumental = new retdocumental();
        $this->retdocumental->setRequest2Object($_REQUEST);
        $row = $this->retdocumental->dbselectByField("ret_id", $_REQUEST["ret_id"]);
        $row = $row[0];
        $this->registry->template->ret_id = $row->ret_id;
        $this->registry->template->ret_par = $row->ret_par;
        $this->registry->template->ret_lugar = $row->ret_lugar;
        $this->registry->template->ret_anios = $row->ret_anios;
        $this->registry->template->ret_usuario_crea = $row->ret_usuario_crea;
        $this->registry->template->ret_fecha_crea = $row->ret_fecha_crea;
        $this->registry->template->ret_fecha_mod = $row->ret_fecha_mod;
        $this->registry->template->ret_usu_mod = $row->ret_usu_mod;
        $this->registry->template->ret_estado = $row->ret_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('retdocumental.tpl');
    }

    function load() {


        $this->retdocumental = new retdocumental();
        $this->retdocumental->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ret_id';
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
            $sql = "SELECT * FROM retdocumental $where and ret_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * FROM retdocumental WHERE ret_estado = 1 $sort $limit ";
        }
        $result = $this->retdocumental->dbselectBySQL($sql);
        $total = $this->retdocumental->count("ret_estado", 1);
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
            $json .= "id:'" . $un->ret_id . "',";
            $json .= "cell:['" . $un->ret_id . "'";
            $json .= ",'" . addslashes($un->ret_par) . "'";
            $json .= ",'" . addslashes($un->ret_lugar) . "'";
            $json .= ",'" . addslashes($un->ret_anios) . "'";
            $json .= ",'" . addslashes($un->ret_usuario_crea) . "'";
            $json .= ",'" . addslashes($un->ret_fecha_crea) . "'";
            $json .= ",'" . addslashes($un->ret_fecha_mod) . "'";
            $json .= ",'" . addslashes($un->ret_usu_mod) . "'";
            $json .= ",'" . addslashes($un->ret_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->ret_id = "";
        $this->registry->template->ret_par = "";
        $this->registry->template->ret_lugar = "";
        $this->registry->template->ret_anios = "";
        $this->registry->template->ret_usuario_crea = "";
        $this->registry->template->ret_fecha_crea = "";
        $this->registry->template->ret_fecha_mod = "";
        $this->registry->template->ret_usu_mod = "";
        $this->registry->template->ret_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('retdocumental.tpl');
    }

    function save() {
        $this->retdocumental = new retdocumental();
        $this->retdocumental->setRequest2Object($_REQUEST);

        $this->retdocumental->setRet_id = $_REQUEST['ret_id'];
        $this->retdocumental->setRet_par = $_REQUEST['ret_par'];
        $this->retdocumental->setRet_lugar = $_REQUEST['ret_lugar'];
        $this->retdocumental->setRet_anios = $_REQUEST['ret_anios'];
        $this->retdocumental->setRet_usuario_crea = $_REQUEST['ret_usuario_crea'];
        $this->retdocumental->setRet_fecha_crea = $_REQUEST['ret_fecha_crea'];
        $this->retdocumental->setRet_fecha_mod = $_REQUEST['ret_fecha_mod'];
        $this->retdocumental->setRet_usu_mod = $_REQUEST['ret_usu_mod'];
        $this->retdocumental->setRet_estado = 1;

        $this->retdocumental->insert();
        Header("Location: " . PATH_DOMAIN . "/retdocumental/");
    }

    function update() {
        $this->retdocumental = new retdocumental();
        $this->retdocumental->setRequest2Object($_REQUEST);

        $this->retdocumental->setRet_id = $_REQUEST['ret_id'];
        $this->retdocumental->setRet_par = $_REQUEST['ret_par'];
        $this->retdocumental->setRet_lugar = $_REQUEST['ret_lugar'];
        $this->retdocumental->setRet_anios = $_REQUEST['ret_anios'];
        $this->retdocumental->setRet_usuario_crea = $_REQUEST['ret_usuario_crea'];
        $this->retdocumental->setRet_fecha_crea = $_REQUEST['ret_fecha_crea'];
        $this->retdocumental->setRet_fecha_mod = $_REQUEST['ret_fecha_mod'];
        $this->retdocumental->setRet_usu_mod = $_REQUEST['ret_usu_mod'];
        $this->retdocumental->setRet_estado = $_REQUEST['ret_estado'];

        $this->retdocumental->update();
        Header("Location: " . PATH_DOMAIN . "/retdocumental/");
    }

    function delete() {
        $this->retdocumental = new retdocumental();
        $this->retdocumental->setRequest2Object($_REQUEST);

        $this->retdocumental->setRet_id($_REQUEST['ret_id']);
        $this->retdocumental->setRet_estado(2);

        $this->retdocumental->update();
    }

    function verif() {

    }

}

?>
