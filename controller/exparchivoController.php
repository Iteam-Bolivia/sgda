<?php

/**
 * exparchivoController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class exparchivoController Extends baseController {

    function index() {

        $this->registry->template->exa_id = "";
        $this->registry->template->fil_id = "<option value='1'>TEST</option>";
        $this->registry->template->euv_id = "<option value='1'>TEST</option>";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->ser_id = "<option value='1'>TEST</option>";
        $this->registry->template->tra_id = "<option value='1'>TEST</option>";
        $this->registry->template->cue_id = "<option value='1'>TEST</option>";
        $this->registry->template->trc_id = "<option value='1'>TEST</option>";
        $this->registry->template->uni_id = "<option value='1'>TEST</option>";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->exc_id = "<option value='1'>TEST</option>";
        $this->registry->template->con_id = "<option value='1'>TEST</option>";
        $this->registry->template->suc_id = "<option value='1'>TEST</option>";
        $this->registry->template->usu_id = "<option value='1'>TEST</option>";
        $this->registry->template->exa_condicion = "";
        $this->registry->template->exa_fecha_crea = "";
        $this->registry->template->exa_usuario_crea = "";
        $this->registry->template->exa_fecha_mod = "";
        $this->registry->template->exa_usuario_mod = "";
        $this->registry->template->exa_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_exparchivog.tpl');
    }

    function view() {
        $this->exparchivo = new tab_exparchivo();
        $this->exparchivo->setRequest2Object($_REQUEST);
        $row = $this->exparchivo->dbselectByField("exa_id", $_REQUEST["exa_id"]);
        $row = $row[0];
        $this->registry->template->exa_id = $row->exa_id;
        $this->registry->template->fil_id = "<option value='1'>TEST</option>";
        $this->registry->template->euv_id = "<option value='1'>TEST</option>";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->ser_id = "<option value='1'>TEST</option>";
        $this->registry->template->tra_id = "<option value='1'>TEST</option>";
        $this->registry->template->cue_id = "<option value='1'>TEST</option>";
        $this->registry->template->trc_id = "<option value='1'>TEST</option>";
        $this->registry->template->uni_id = "<option value='1'>TEST</option>";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->exc_id = "<option value='1'>TEST</option>";
        $this->registry->template->con_id = "<option value='1'>TEST</option>";
        $this->registry->template->suc_id = "<option value='1'>TEST</option>";
        $this->registry->template->usu_id = "<option value='1'>TEST</option>";
        $this->registry->template->exa_condicion = $row->exa_condicion;
        $this->registry->template->exa_fecha_crea = $row->exa_fecha_crea;
        $this->registry->template->exa_usuario_crea = $row->exa_usuario_crea;
        $this->registry->template->exa_fecha_mod = $row->exa_fecha_mod;
        $this->registry->template->exa_usuario_mod = $row->exa_usuario_mod;
        $this->registry->template->exa_estado = $row->exa_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_exparchivo.tpl');
    }

    function load() {


        $this->exparchivo = new tab_exparchivo();
        $this->exparchivo->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'exa_id';
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
            $sql = "SELECT * FROM tab_exparchivo $where and exa_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * FROM tab_exparchivo WHERE exa_estado = 1 $sort $limit ";
        }
        $result = $this->exparchivo->dbselectBySQL($sql);
        $total = $this->exparchivo->count("exa_estado", 1);
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
            $json .= "id:'" . $un->exa_id . "',";
            $json .= "cell:['" . $un->exa_id . "'";
            $json .= ",'" . addslashes($un->fil_id) . "'";
            $json .= ",'" . addslashes($un->euv_id) . "'";
            $json .= ",'" . addslashes($un->exp_id) . "'";
            $json .= ",'" . addslashes($un->ser_id) . "'";
            $json .= ",'" . addslashes($un->tra_id) . "'";
            $json .= ",'" . addslashes($un->cue_id) . "'";
            $json .= ",'" . addslashes($un->trc_id) . "'";
            $json .= ",'" . addslashes($un->uni_id) . "'";
            $json .= ",'" . addslashes($un->ver_id) . "'";
            $json .= ",'" . addslashes($un->exc_id) . "'";
            $json .= ",'" . addslashes($un->con_id) . "'";
            $json .= ",'" . addslashes($un->suc_id) . "'";
            $json .= ",'" . addslashes($un->usu_id) . "'";
            $json .= ",'" . addslashes($un->exa_condicion) . "'";
            $json .= ",'" . addslashes($un->exa_fecha_crea) . "'";
            $json .= ",'" . addslashes($un->exa_usuario_crea) . "'";
            $json .= ",'" . addslashes($un->exa_fecha_mod) . "'";
            $json .= ",'" . addslashes($un->exa_usuario_mod) . "'";
            $json .= ",'" . addslashes($un->exa_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->exa_id = "";
        $this->registry->template->fil_id = "<option value='1'>TEST</option>";
        $this->registry->template->euv_id = "<option value='1'>TEST</option>";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->ser_id = "<option value='1'>TEST</option>";
        $this->registry->template->tra_id = "<option value='1'>TEST</option>";
        $this->registry->template->cue_id = "<option value='1'>TEST</option>";
        $this->registry->template->trc_id = "<option value='1'>TEST</option>";
        $this->registry->template->uni_id = "<option value='1'>TEST</option>";
        $this->registry->template->ver_id = "<option value='1'>TEST</option>";
        $this->registry->template->exc_id = "<option value='1'>TEST</option>";
        $this->registry->template->con_id = "<option value='1'>TEST</option>";
        $this->registry->template->suc_id = "<option value='1'>TEST</option>";
        $this->registry->template->usu_id = "<option value='1'>TEST</option>";
        $this->registry->template->exa_condicion = "";
        $this->registry->template->exa_fecha_crea = "";
        $this->registry->template->exa_usuario_crea = "";
        $this->registry->template->exa_fecha_mod = "";
        $this->registry->template->exa_usuario_mod = "";
        $this->registry->template->exa_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_exparchivo.tpl');
    }

    function save() {
        $this->exparchivo = new tab_exparchivo();
        $this->exparchivo->setRequest2Object($_REQUEST);

        $this->exparchivo->setExa_id = $_REQUEST['exa_id'];
        $this->exparchivo->setFil_id = $_REQUEST['fil_id'];
        $this->exparchivo->setEuv_id = $_REQUEST['euv_id'];
        $this->exparchivo->setExp_id = $_REQUEST['exp_id'];
        $this->exparchivo->setSer_id = $_REQUEST['ser_id'];
        $this->exparchivo->setTra_id = $_REQUEST['tra_id'];
        $this->exparchivo->setCue_id = $_REQUEST['cue_id'];
        $this->exparchivo->setTrc_id = $_REQUEST['trc_id'];
        $this->exparchivo->setUni_id = $_REQUEST['uni_id'];
        $this->exparchivo->setVer_id = $_REQUEST['ver_id'];
        $this->exparchivo->setExc_id = $_REQUEST['exc_id'];
        $this->exparchivo->setCon_id = $_REQUEST['con_id'];
        $this->exparchivo->setSuc_id = $_REQUEST['suc_id'];
        $this->exparchivo->setUsu_id = $_REQUEST['usu_id'];
        $this->exparchivo->setExa_condicion = $_REQUEST['exa_condicion'];
        $this->exparchivo->setExa_fecha_crea = $_REQUEST['exa_fecha_crea'];
        $this->exparchivo->setExa_usuario_crea = $_REQUEST['exa_usuario_crea'];
        $this->exparchivo->setExa_fecha_mod = $_REQUEST['exa_fecha_mod'];
        $this->exparchivo->setExa_usuario_mod = $_REQUEST['exa_usuario_mod'];
        $this->exparchivo->setExa_estado = 1;

        $this->exparchivo->insert();
        Header("Location: " . PATH_DOMAIN . "/exparchivo/");
    }

    function update() {
        $this->exparchivo = new tab_exparchivo();
        $this->exparchivo->setRequest2Object($_REQUEST);

        $this->exparchivo->setExa_id = $_REQUEST['exa_id'];
        $this->exparchivo->setFil_id = $_REQUEST['fil_id'];
        $this->exparchivo->setEuv_id = $_REQUEST['euv_id'];
        $this->exparchivo->setExp_id = $_REQUEST['exp_id'];
        $this->exparchivo->setSer_id = $_REQUEST['ser_id'];
        $this->exparchivo->setTra_id = $_REQUEST['tra_id'];
        $this->exparchivo->setCue_id = $_REQUEST['cue_id'];
        $this->exparchivo->setTrc_id = $_REQUEST['trc_id'];
        $this->exparchivo->setUni_id = $_REQUEST['uni_id'];
        $this->exparchivo->setVer_id = $_REQUEST['ver_id'];
        $this->exparchivo->setExc_id = $_REQUEST['exc_id'];
        $this->exparchivo->setCon_id = $_REQUEST['con_id'];
        $this->exparchivo->setSuc_id = $_REQUEST['suc_id'];
        $this->exparchivo->setUsu_id = $_REQUEST['usu_id'];
        $this->exparchivo->setExa_condicion = $_REQUEST['exa_condicion'];
        $this->exparchivo->setExa_fecha_crea = $_REQUEST['exa_fecha_crea'];
        $this->exparchivo->setExa_usuario_crea = $_REQUEST['exa_usuario_crea'];
        $this->exparchivo->setExa_fecha_mod = $_REQUEST['exa_fecha_mod'];
        $this->exparchivo->setExa_usuario_mod = $_REQUEST['exa_usuario_mod'];
        $this->exparchivo->setExa_estado = $_REQUEST['exa_estado'];

        $this->exparchivo->update();
        Header("Location: " . PATH_DOMAIN . "/exparchivo/");
    }

    function delete() {
        $this->exparchivo = new tab_exparchivo();
        $this->exparchivo->setRequest2Object($_REQUEST);

        $this->exparchivo->setExa_id($_REQUEST['exa_id']);
        $this->exparchivo->setExa_estado(2);

        $this->exparchivo->update();
    }

    function verif() {

    }

}

?>
