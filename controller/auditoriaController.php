<?php

/**
 * auditoriaController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class auditoriaController extends baseController {

    function index() {

        $this->registry->template->aud_id = "";
        $this->registry->template->aud_tabla = "";
        $this->registry->template->aud_usuario_mod = "";
        $this->registry->template->aud_fecha_mod = "";
        $this->registry->template->aud_hora_mod = "";
        $this->registry->template->aud_accion = "";
        $this->registry->template->aud_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('auditoriag.tpl');
    }

    function view() {
        $this->auditoria = new auditoria ();
        $this->auditoria->setRequest2Object($_REQUEST);
        $row = $this->auditoria->dbselectByField("aud_id", $_REQUEST ["aud_id"]);
        $row = $row [0];
        $this->registry->template->aud_id = $row->aud_id;
        $this->registry->template->aud_tabla = $row->aud_tabla;
        $this->registry->template->aud_usuario_mod = $row->aud_usuario_mod;
        $this->registry->template->aud_fecha_mod = $row->aud_fecha_mod;
        $this->registry->template->aud_hora_mod = $row->aud_hora_mod;
        $this->registry->template->aud_accion = $row->aud_accion;
        $this->registry->template->aud_estado = $row->aud_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->registry->template->show('header');
        $this->registry->template->show('auditoria.tpl');
    }

    function load() {

        $this->auditoria = new auditoria ();
        $this->auditoria->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'aud_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query) {
            $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * FROM auditoria $where and aud_estado = 1 $sort $limit";
        } else {
            $sql = "SELECT * FROM auditoria WHERE aud_estado = 1 $sort $limit";
        }
        $result = $this->auditoria->dbselectBySQL($sql);
        $total = $this->auditoria->count("aud_estado", 1);
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
            $json .= "id:'" . $un->aud_id . "',";
            $json .= "cell:['" . $un->aud_id . "'";
            $json .= ",'" . addslashes($un->aud_tabla) . "'";
            $json .= ",'" . addslashes($un->aud_usuario_mod) . "'";
            $json .= ",'" . addslashes($un->aud_fecha_mod) . "'";
            $json .= ",'" . addslashes($un->aud_hora_mod) . "'";
            $json .= ",'" . addslashes($un->aud_accion) . "'";
            $json .= ",'" . addslashes($un->aud_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->aud_id = "";
        $this->registry->template->aud_tabla = "";
        $this->registry->template->aud_usuario_mod = "";
        $this->registry->template->aud_fecha_mod = "";
        $this->registry->template->aud_hora_mod = "";
        $this->registry->template->aud_accion = "";
        $this->registry->template->aud_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('auditoria.tpl');
    }

    function save() {
        $this->auditoria = new auditoria ();
        $this->auditoria->setRequest2Object($_REQUEST);

        $this->auditoria->setAud_id = $_REQUEST ['aud_id'];
        $this->auditoria->setAud_tabla = $_REQUEST ['aud_tabla'];
        $this->auditoria->setAud_usuario_mod = $_REQUEST ['aud_usuario_mod'];
        $this->auditoria->setAud_fecha_mod = $_REQUEST ['aud_fecha_mod'];
        $this->auditoria->setAud_hora_mod = $_REQUEST ['aud_hora_mod'];
        $this->auditoria->setAud_accion = $_REQUEST ['aud_accion'];
        $this->auditoria->setAud_estado = 1;

        $this->auditoria->insert();
        Header("Location: " . PATH_DOMAIN . "/auditoria/");
    }

    function update() {
        $this->auditoria = new auditoria ();
        $this->auditoria->setRequest2Object($_REQUEST);

        $this->auditoria->setAud_id = $_REQUEST ['aud_id'];
        $this->auditoria->setAud_tabla = $_REQUEST ['aud_tabla'];
        $this->auditoria->setAud_usuario_mod = $_REQUEST ['aud_usuario_mod'];
        $this->auditoria->setAud_fecha_mod = $_REQUEST ['aud_fecha_mod'];
        $this->auditoria->setAud_hora_mod = $_REQUEST ['aud_hora_mod'];
        $this->auditoria->setAud_accion = $_REQUEST ['aud_accion'];
        $this->auditoria->setAud_estado = $_REQUEST ['aud_estado'];

        $this->auditoria->update();
        Header("Location: " . PATH_DOMAIN . "/auditoria/");
    }

    function delete() {
        $this->auditoria = new auditoria ();
        $this->auditoria->setRequest2Object($_REQUEST);

        $this->auditoria->setAud_id($_REQUEST ['aud_id']);
        $this->auditoria->setAud_estado(2);

        $this->auditoria->update();
    }

    function verif() {

    }

}

?>
