<?php

/**
 * serietramiteController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class serietramiteController Extends baseController {

    function index() {

        $this->registry->template->sts_id = "";
        $this->registry->template->ser_id = "<option value='1'>TEST</option>";
        $this->registry->template->tra_id = "<option value='1'>TEST</option>";
        $this->registry->template->sts_fecha_crea = "";
        $this->registry->template->sts_usuario_crea = "";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->sts_fecha_reg = "";
        $this->registry->template->sts_usu_reg = "";
        $this->registry->template->sts_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_serietramiteg.tpl');
    }

    function view() {
        $this->serietramite = new tab_serietramite();
        $this->serietramite->setRequest2Object($_REQUEST);
        $row = $this->serietramite->dbselectByField("sts_id", $_REQUEST["sts_id"]);
        $row = $row[0];
        $this->registry->template->sts_id = $row->sts_id;
        $this->registry->template->ser_id = "<option value='1'>TEST</option>";
        $this->registry->template->tra_id = "<option value='1'>TEST</option>";
        $this->registry->template->sts_fecha_crea = $row->sts_fecha_crea;
        $this->registry->template->sts_usuario_crea = $row->sts_usuario_crea;
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->sts_fecha_reg = $row->sts_fecha_reg;
        $this->registry->template->sts_usu_reg = $row->sts_usu_reg;
        $this->registry->template->sts_estado = $row->sts_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_serietramite.tpl');
    }

    function load() {


        $this->serietramite = new tab_serietramite();
        $this->serietramite->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'sts_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        if ($query) {
            $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * FROM tab_serietramite $where and sts_estado = 1 $sort $limit";
        } else {
            $sql = "SELECT * FROM tab_serietramite WHERE sts_estado = 1 $sort $limit";
        }
        $result = $this->serietramite->dbselectBySQL($sql);
        $total = $this->serietramite->count("sts_estado", 1);
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
            $json .= "id:'" . $un->sts_id . "',";
            $json .= "cell:['" . $un->sts_id . "'";
            $json .= ",'" . addslashes($un->ser_id) . "'";
            $json .= ",'" . addslashes($un->tra_id) . "'";
            $json .= ",'" . addslashes($un->sts_fecha_crea) . "'";
            $json .= ",'" . addslashes($un->sts_usuario_crea) . "'";
            $json .= ",'" . addslashes($un->ver_id) . "'";
            $json .= ",'" . addslashes($un->sts_fecha_reg) . "'";
            $json .= ",'" . addslashes($un->sts_usu_reg) . "'";
            $json .= ",'" . addslashes($un->sts_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->sts_id = "";
        $this->registry->template->ser_id = "<option value='1'>TEST</option>";
        $this->registry->template->tra_id = "<option value='1'>TEST</option>";
        $this->registry->template->sts_fecha_crea = "";
        $this->registry->template->sts_usuario_crea = "";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->sts_fecha_reg = "";
        $this->registry->template->sts_usu_reg = "";
        $this->registry->template->sts_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_serietramite.tpl');
    }

    function save() {
        $this->serietramite = new tab_serietramite();
        $this->serietramite->setRequest2Object($_REQUEST);

        $this->serietramite->setSts_id = $_REQUEST['sts_id'];
        $this->serietramite->setSer_id = $_REQUEST['ser_id'];
        $this->serietramite->setTra_id = $_REQUEST['tra_id'];
        $this->serietramite->setSts_fecha_crea = $_REQUEST['sts_fecha_crea'];
        $this->serietramite->setSts_usuario_crea = $_REQUEST['sts_usuario_crea'];
        $this->serietramite->setVer_id = $_REQUEST['ver_id'];
        $this->serietramite->setSts_fecha_reg = $_REQUEST['sts_fecha_reg'];
        $this->serietramite->setSts_usu_reg = $_REQUEST['sts_usu_reg'];
        $this->serietramite->setSts_estado = 1;

        $this->serietramite->insert();
        Header("Location: " . PATH_DOMAIN . "/serietramite/");
    }

    function update() {
        $this->serietramite = new tab_serietramite();
        $this->serietramite->setRequest2Object($_REQUEST);

        $this->serietramite->setSts_id = $_REQUEST['sts_id'];
        $this->serietramite->setSer_id = $_REQUEST['ser_id'];
        $this->serietramite->setTra_id = $_REQUEST['tra_id'];
        $this->serietramite->setSts_fecha_crea = $_REQUEST['sts_fecha_crea'];
        $this->serietramite->setSts_usuario_crea = $_REQUEST['sts_usuario_crea'];
        $this->serietramite->setVer_id = $_REQUEST['ver_id'];
        $this->serietramite->setSts_fecha_reg = $_REQUEST['sts_fecha_reg'];
        $this->serietramite->setSts_usu_reg = $_REQUEST['sts_usu_reg'];
        $this->serietramite->setSts_estado = $_REQUEST['sts_estado'];

        $this->serietramite->update();
        Header("Location: " . PATH_DOMAIN . "/serietramite/");
    }

    function delete() {
        $this->serietramite = new tab_serietramite();
        $this->serietramite->setRequest2Object($_REQUEST);

        $this->serietramite->setSts_id($_REQUEST['sts_id']);
        $this->serietramite->setSts_estado(2);

        $this->serietramite->update();
    }

    function verif() {

    }

}

?>
