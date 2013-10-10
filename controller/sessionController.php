<?php

/**
 * archivoController
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class sessionController extends baseController {

    function logout() {
        //$this->invdoc->setRequest2Object($_REQUEST);
        $this->usuario = new usuario ();
        $this->usuario->$this->registry->template->user = $_REQUEST ['user'];
        $this->registry->template->pass = $_REQUEST ['pass'];
        if (!$_REQUEST ['user'])
            $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_series.tpl');
    }

    function unlogout() {

        $this->series = new tab_series ();
        $this->series->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'ser_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        //$limit = "LIMIT $start, $rp";
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query) {
            $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * FROM tab_series $where and ser_estado = 1 $sort"; // $limit
        } else {
            $sql = "SELECT * FROM tab_series WHERE ser_estado = 1 $sort"; // $limit
        }
        $result = $this->series->dbselectBySQL($sql);
        $total = $this->series->count("ser_estado", 1);
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
            $json .= "id:'" . $un->ser_id . "',";
            $json .= "cell:['" . $un->ser_id . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= ",'" . addslashes($un->ser_tipo) . "'";
            $json .= ",'" . addslashes($un->ser_fecha_crea) . "'";
            $json .= ",'" . addslashes($un->ser_usuario_crea) . "'";
            $json .= ",'" . addslashes($un->ser_fecha_mod) . "'";
            $json .= ",'" . addslashes($un->ser_usuario_mod) . "'";
            $json .= ",'" . addslashes($un->ser_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->series = new tab_series ();
        $this->series->setRequest2Object($_REQUEST);

        $this->series->setSer_id = $_REQUEST ['ser_id'];
        $this->series->setSer_categoria = $_REQUEST ['ser_categoria'];
        $this->series->setSer_tipo = $_REQUEST ['ser_tipo'];
        $this->series->setSer_fecha_crea = $_REQUEST ['ser_fecha_crea'];
        $this->series->setSer_usuario_crea = $_REQUEST ['ser_usuario_crea'];
        $this->series->setSer_fecha_mod = $_REQUEST ['ser_fecha_mod'];
        $this->series->setSer_usuario_mod = $_REQUEST ['ser_usuario_mod'];
        $this->series->setSer_estado = 1;

        $this->series->insert();
        Header("Location: " . PATH_DOMAIN . "/series/");
    }

    function update() {
        $this->series = new tab_series ();
        $this->series->setRequest2Object($_REQUEST);

        $this->series->setSer_id = $_REQUEST ['ser_id'];
        $this->series->setSer_categoria = $_REQUEST ['ser_categoria'];
        $this->series->setSer_tipo = $_REQUEST ['ser_tipo'];
        $this->series->setSer_fecha_crea = $_REQUEST ['ser_fecha_crea'];
        $this->series->setSer_usuario_crea = $_REQUEST ['ser_usuario_crea'];
        $this->series->setSer_fecha_mod = $_REQUEST ['ser_fecha_mod'];
        $this->series->setSer_usuario_mod = $_REQUEST ['ser_usuario_mod'];
        $this->series->setSer_estado = $_REQUEST ['ser_estado'];

        $this->series->update();
        Header("Location: " . PATH_DOMAIN . "/series/");
    }

    function delete() {
        $this->series = new tab_series ();
        $this->series->setRequest2Object($_REQUEST);

        $this->series->setSer_id($_REQUEST ['ser_id']);
        $this->series->setSer_estado(2);

        $this->series->update();
    }

    function verif() {

    }

}

?>
