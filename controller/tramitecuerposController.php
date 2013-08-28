<?php

/**
 * tramitecuerposController.php Controller
 *
 * @package
 * @author lic. castellon
 * @revised Ing. Arsenio Castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tramitecuerposController Extends baseController {

    function index() {

        $this->registry->template->trc_id = "";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->tra_id = "<option value='1'>TEST</option>";
        $this->registry->template->cue_id = "<option value='1'>TEST</option>";
        $this->registry->template->trc_usuario_crea = "";
        $this->registry->template->trc_fecha_crea = "";
        $this->registry->template->trc_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_tramitecuerposg.tpl');
    }

    function view() {
        $this->tramitecuerpos = new tab_tramitecuerpos();
        $this->tramitecuerpos->setRequest2Object($_REQUEST);
        $row = $this->tramitecuerpos->dbselectByField("trc_id", $_REQUEST["trc_id"]);
        $row = $row[0];
        $this->registry->template->trc_id = $row->trc_id;
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->tra_id = "<option value='1'>TEST</option>";
        $this->registry->template->cue_id = "<option value='1'>TEST</option>";
        $this->registry->template->trc_usuario_crea = $row->trc_usuario_crea;
        $this->registry->template->trc_fecha_crea = $row->trc_fecha_crea;
        $this->registry->template->trc_estado = $row->trc_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_tramitecuerpos.tpl');
    }

    function load() {
        $this->tramitecuerpos = new tab_tramitecuerpos();
        $this->tramitecuerpos->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'trc_id';
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
            $sql = "SELECT * FROM tab_tramitecuerpos $where and trc_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * FROM tab_tramitecuerpos WHERE trc_estado = 1 $sort $limit ";
        }
        $result = $this->tramitecuerpos->dbselectBySQL($sql);
        $total = $this->tramitecuerpos->count("trc_estado", 1);
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
            $json .= "id:'" . $un->trc_id . "',";
            $json .= "cell:['" . $un->trc_id . "'";
            $json .= ",'" . addslashes($un->ver_id) . "'";
            $json .= ",'" . addslashes($un->tra_id) . "'";
            $json .= ",'" . addslashes($un->cue_id) . "'";
            $json .= ",'" . addslashes($un->trc_usuario_crea) . "'";
            $json .= ",'" . addslashes($un->trc_fecha_crea) . "'";
            $json .= ",'" . addslashes($un->trc_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->trc_id = "";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->tra_id = "<option value='1'>TEST</option>";
        $this->registry->template->cue_id = "<option value='1'>TEST</option>";
        $this->registry->template->trc_usuario_crea = "";
        $this->registry->template->trc_fecha_crea = "";
        $this->registry->template->trc_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_tramitecuerpos.tpl');
    }

    function save() {
        $this->tramitecuerpos = new tab_tramitecuerpos();
        $this->tramitecuerpos->setRequest2Object($_REQUEST);

        $this->tramitecuerpos->setTrc_id = $_REQUEST['trc_id'];
        $this->tramitecuerpos->setVer_id = $_REQUEST['ver_id'];
        $this->tramitecuerpos->setTra_id = $_REQUEST['tra_id'];
        $this->tramitecuerpos->setCue_id = $_REQUEST['cue_id'];
        $this->tramitecuerpos->setTrc_usuario_crea = $_REQUEST['trc_usuario_crea'];
        $this->tramitecuerpos->setTrc_fecha_crea = $_REQUEST['trc_fecha_crea'];
        $this->tramitecuerpos->setTrc_estado = 1;

        $this->tramitecuerpos->insert();
        Header("Location: " . PATH_DOMAIN . "/tramitecuerpos/");
    }

    function update() {
        $this->tramitecuerpos = new tab_tramitecuerpos();
        $this->tramitecuerpos->setRequest2Object($_REQUEST);

        $this->tramitecuerpos->setTrc_id = $_REQUEST['trc_id'];
        $this->tramitecuerpos->setVer_id = $_REQUEST['ver_id'];
        $this->tramitecuerpos->setTra_id = $_REQUEST['tra_id'];
        $this->tramitecuerpos->setCue_id = $_REQUEST['cue_id'];
        $this->tramitecuerpos->setTrc_usuario_crea = $_REQUEST['trc_usuario_crea'];
        $this->tramitecuerpos->setTrc_fecha_crea = $_REQUEST['trc_fecha_crea'];
        $this->tramitecuerpos->setTrc_estado = $_REQUEST['trc_estado'];

        $this->tramitecuerpos->update();
        Header("Location: " . PATH_DOMAIN . "/tramitecuerpos/");
    }

    function delete() {
        $this->tramitecuerpos = new tab_tramitecuerpos();
        $this->tramitecuerpos->setRequest2Object($_REQUEST);

        $this->tramitecuerpos->setTrc_id($_REQUEST['trc_id']);
        $this->tramitecuerpos->setTrc_estado(2);

        $this->tramitecuerpos->update();
    }

    function verif() {

    }

}

?>
