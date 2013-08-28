<?php

/**
 * riesgosController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class riesgosController Extends baseController {

    function index() {

        $this->registry->template->rie_id = "";
        $this->registry->template->rie_descripcion = "";
        $this->registry->template->rie_tipo = "";
        $this->registry->template->rie_usu_reg = "";
        $this->registry->template->rie_usu_mod = "";
        $this->registry->template->rie_fecha_reg = "";
        $this->registry->template->rie_fecha_mod = "";
        $this->registry->template->rie_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_riesgosg.tpl');
    }

    function view() {
        $this->riesgos = new tab_riesgos();
        $this->riesgos->setRequest2Object($_REQUEST);
        $row = $this->riesgos->dbselectByField("rie_id", $_REQUEST["rie_id"]);
        $row = $row[0];
        $this->registry->template->rie_id = $row->rie_id;
        $this->registry->template->rie_descripcion = $row->rie_descripcion;
        $this->registry->template->rie_tipo = $row->rie_tipo;
        $this->registry->template->rie_usu_reg = $row->rie_usu_reg;
        $this->registry->template->rie_usu_mod = $row->rie_usu_mod;
        $this->registry->template->rie_fecha_reg = $row->rie_fecha_reg;
        $this->registry->template->rie_fecha_mod = $row->rie_fecha_mod;
        $this->registry->template->rie_estado = $row->rie_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_riesgos.tpl');
    }

    function load() {


        $this->riesgos = new tab_riesgos();
        $this->riesgos->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'rie_id';
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
            $sql = "SELECT * FROM tab_riesgos $where and rie_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * FROM tab_riesgos WHERE rie_estado = 1 $sort $limit ";
        }
        $result = $this->riesgos->dbselectBySQL($sql);
        $total = $this->riesgos->count("rie_estado", 1);
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
            $json .= "id:'" . $un->rie_id . "',";
            $json .= "cell:['" . $un->rie_id . "'";
            $json .= ",'" . addslashes($un->rie_descripcion) . "'";
            $json .= ",'" . addslashes($un->rie_tipo) . "'";
            $json .= ",'" . addslashes($un->rie_usu_reg) . "'";
            $json .= ",'" . addslashes($un->rie_usu_mod) . "'";
            $json .= ",'" . addslashes($un->rie_fecha_reg) . "'";
            $json .= ",'" . addslashes($un->rie_fecha_mod) . "'";
            $json .= ",'" . addslashes($un->rie_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->rie_id = "";
        $this->registry->template->rie_descripcion = "";
        $this->registry->template->rie_tipo = "";
        $this->registry->template->rie_usu_reg = "";
        $this->registry->template->rie_usu_mod = "";
        $this->registry->template->rie_fecha_reg = "";
        $this->registry->template->rie_fecha_mod = "";
        $this->registry->template->rie_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_riesgos.tpl');
    }

    function save() {
        $this->riesgos = new tab_riesgos();
        $this->riesgos->setRequest2Object($_REQUEST);

        $this->riesgos->setRie_id = $_REQUEST['rie_id'];
        $this->riesgos->setRie_descripcion = $_REQUEST['rie_descripcion'];
        $this->riesgos->setRie_tipo = $_REQUEST['rie_tipo'];
        $this->riesgos->setRie_usu_reg = $_REQUEST['rie_usu_reg'];
        $this->riesgos->setRie_usu_mod = $_REQUEST['rie_usu_mod'];
        $this->riesgos->setRie_fecha_reg = $_REQUEST['rie_fecha_reg'];
        $this->riesgos->setRie_fecha_mod = $_REQUEST['rie_fecha_mod'];
        $this->riesgos->setRie_estado = 1;

        $this->riesgos->insert();
        Header("Location: " . PATH_DOMAIN . "/riesgos/");
    }

    function update() {
        $this->riesgos = new tab_riesgos();
        $this->riesgos->setRequest2Object($_REQUEST);

        $this->riesgos->setRie_id = $_REQUEST['rie_id'];
        $this->riesgos->setRie_descripcion = $_REQUEST['rie_descripcion'];
        $this->riesgos->setRie_tipo = $_REQUEST['rie_tipo'];
        $this->riesgos->setRie_usu_reg = $_REQUEST['rie_usu_reg'];
        $this->riesgos->setRie_usu_mod = $_REQUEST['rie_usu_mod'];
        $this->riesgos->setRie_fecha_reg = $_REQUEST['rie_fecha_reg'];
        $this->riesgos->setRie_fecha_mod = $_REQUEST['rie_fecha_mod'];
        $this->riesgos->setRie_estado = $_REQUEST['rie_estado'];

        $this->riesgos->update();
        Header("Location: " . PATH_DOMAIN . "/riesgos/");
    }

    function delete() {
        $this->riesgos = new tab_riesgos();
        $this->riesgos->setRequest2Object($_REQUEST);

        $this->riesgos->setRie_id($_REQUEST['rie_id']);
        $this->riesgos->setRie_estado(2);

        $this->riesgos->update();
    }

    function verif() {

    }

}

?>
