<?php

/**
 * progdesastresController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */

class nuevaestructuraController Extends baseController {

    function index() {

        $this->registry->template->des_id = "";
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $this->registry->template->des_resumen = "";
        $this->registry->template->des_indicador = "";
        $this->registry->template->des_fuentes = "";
        $this->registry->template->des_riesgo = "";
        $this->registry->template->des_usu_reg = "";
        $this->registry->template->des_fecha_reg = "";
        $this->registry->template->des_usu_mod = "";
        $this->registry->template->des_fecha_mod = "";
        $this->registry->template->des_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_progdesastresg.tpl');
    }

    function view() {
        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);
        $row = $this->progdesastres->dbselectByField("des_id", $_REQUEST["des_id"]);
        $row = $row[0];
        $this->registry->template->des_id = $row->des_id;
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $this->registry->template->des_resumen = $row->des_resumen;
        $this->registry->template->des_indicador = $row->des_indicador;
        $this->registry->template->des_fuentes = $row->des_fuentes;
        $this->registry->template->des_riesgo = $row->des_riesgo;
        $this->registry->template->des_usu_reg = $row->des_usu_reg;
        $this->registry->template->des_fecha_reg = $row->des_fecha_reg;
        $this->registry->template->des_usu_mod = $row->des_usu_mod;
        $this->registry->template->des_fecha_mod = $row->des_fecha_mod;
        $this->registry->template->des_estado = $row->des_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_progdesastres.tpl');
    }

    function load() {


        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'des_id';
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
            $sql = "SELECT * FROM tab_progdesastres $where and des_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * FROM tab_progdesastres WHERE des_estado = 1 $sort $limit ";
        }
        $result = $this->progdesastres->dbselectBySQL($sql);
        $total = $this->progdesastres->count("des_estado", 1);
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
            $json .= "id:'" . $un->des_id . "',";
            $json .= "cell:['" . $un->des_id . "'";
            $json .= ",'" . addslashes($un->dpr_id) . "'";
            $json .= ",'" . addslashes($un->des_resumen) . "'";
            $json .= ",'" . addslashes($un->des_indicador) . "'";
            $json .= ",'" . addslashes($un->des_fuentes) . "'";
            $json .= ",'" . addslashes($un->des_riesgo) . "'";
            $json .= ",'" . addslashes($un->des_usu_reg) . "'";
            $json .= ",'" . addslashes($un->des_fecha_reg) . "'";
            $json .= ",'" . addslashes($un->des_usu_mod) . "'";
            $json .= ",'" . addslashes($un->des_fecha_mod) . "'";
            $json .= ",'" . addslashes($un->des_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->des_id = "";
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $this->registry->template->des_resumen = "";
        $this->registry->template->des_indicador = "";
        $this->registry->template->des_fuentes = "";
        $this->registry->template->des_riesgo = "";
        $this->registry->template->des_usu_reg = "";
        $this->registry->template->des_fecha_reg = "";
        $this->registry->template->des_usu_mod = "";
        $this->registry->template->des_fecha_mod = "";
        $this->registry->template->des_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_progdesastres.tpl');
    }

    function save() {
        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);

        $this->progdesastres->setDes_id = $_REQUEST['des_id'];
        $this->progdesastres->setDpr_id = $_REQUEST['dpr_id'];
        $this->progdesastres->setDes_resumen = $_REQUEST['des_resumen'];
        $this->progdesastres->setDes_indicador = $_REQUEST['des_indicador'];
        $this->progdesastres->setDes_fuentes = $_REQUEST['des_fuentes'];
        $this->progdesastres->setDes_riesgo = $_REQUEST['des_riesgo'];
        $this->progdesastres->setDes_usu_reg = $_REQUEST['des_usu_reg'];
        $this->progdesastres->setDes_fecha_reg = $_REQUEST['des_fecha_reg'];
        $this->progdesastres->setDes_usu_mod = $_REQUEST['des_usu_mod'];
        $this->progdesastres->setDes_fecha_mod = $_REQUEST['des_fecha_mod'];
        $this->progdesastres->setDes_estado = 1;

        $this->progdesastres->insert();
        Header("Location: " . PATH_DOMAIN . "/progdesastres/");
    }

    function update() {
        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);

        $this->progdesastres->setDes_id = $_REQUEST['des_id'];
        $this->progdesastres->setDpr_id = $_REQUEST['dpr_id'];
        $this->progdesastres->setDes_resumen = $_REQUEST['des_resumen'];
        $this->progdesastres->setDes_indicador = $_REQUEST['des_indicador'];
        $this->progdesastres->setDes_fuentes = $_REQUEST['des_fuentes'];
        $this->progdesastres->setDes_riesgo = $_REQUEST['des_riesgo'];
        $this->progdesastres->setDes_usu_reg = $_REQUEST['des_usu_reg'];
        $this->progdesastres->setDes_fecha_reg = $_REQUEST['des_fecha_reg'];
        $this->progdesastres->setDes_usu_mod = $_REQUEST['des_usu_mod'];
        $this->progdesastres->setDes_fecha_mod = $_REQUEST['des_fecha_mod'];
        $this->progdesastres->setDes_estado = $_REQUEST['des_estado'];

        $this->progdesastres->update();
        Header("Location: " . PATH_DOMAIN . "/progdesastres/");
    }

    function delete() {
        $this->progdesastres = new tab_progdesastres();
        $this->progdesastres->setRequest2Object($_REQUEST);

        $this->progdesastres->setDes_id($_REQUEST['des_id']);
        $this->progdesastres->setDes_estado(2);

        $this->progdesastres->update();
    }

    function verif() {

    }

}

?>
