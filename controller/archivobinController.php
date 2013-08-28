<?php

/**
 * archivobinController.php Controller
 *
 * @package
 * @author Lic. Arsenio Castellón
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class archivobinController extends baseController {

    function index() {

        $this->registry->template->fil_id = "";
        $this->registry->template->fil_contenido = "";
        $this->registry->template->fil_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('header');
        $this->registry->template->show('tab_archivobing.tpl');
    }

    function view() {
        $this->archivobin = new tab_archivobin ();
        $this->archivobin->setRequest2Object($_REQUEST);
        $row = $this->archivobin->dbselectByField("fil_id", $_REQUEST ["fil_id"]);
        $row = $row [0];
        $this->registry->template->fil_id = $row->fil_id;
        $this->registry->template->fil_contenido = $row->fil_contenido;
        $this->registry->template->fil_estado = $row->fil_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_archivobin.tpl');
    }

    function load() {

        $this->archivobin = new tab_archivobin ();
        $this->archivobin->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'fil_id';
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
            $sql = "SELECT * FROM tab_archivobin $where and fil_estado = 1 $sort"; // $limit
        } else {
            $sql = "SELECT * FROM tab_archivobin WHERE fil_estado = 1 $sort"; // $limit
        }
        $result = $this->archivobin->dbselectBySQL($sql);
        $total = $this->archivobin->count("fil_estado", 1);
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
            $json .= "id:'" . $un->fil_id . "',";
            $json .= "cell:['" . $un->fil_id . "'";
            $json .= ",'" . addslashes($un->fil_contenido) . "'";
            $json .= ",'" . addslashes($un->fil_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->fil_id = "";
        $this->registry->template->fil_contenido = "";
        $this->registry->template->fil_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_archivobin.tpl');
    }

    function save() {
        $this->archivobin = new tab_archivobin ();
        $this->archivobin->setRequest2Object($_REQUEST);

        $this->archivobin->setFil_id = $_REQUEST ['fil_id'];
        $this->archivobin->setFil_contenido = $_REQUEST ['fil_contenido'];
        $this->archivobin->setFil_estado = 1;

        $this->archivobin->insert();
        Header("Location: " . PATH_DOMAIN . "/archivobin/");
    }

    function update() {
        $this->archivobin = new tab_archivobin ();
        $this->archivobin->setRequest2Object($_REQUEST);

        $this->archivobin->setFil_id = $_REQUEST ['fil_id'];
        $this->archivobin->setFil_contenido = $_REQUEST ['fil_contenido'];
        $this->archivobin->setFil_estado = $_REQUEST ['fil_estado'];

        $this->archivobin->update();
        Header("Location: " . PATH_DOMAIN . "/archivobin/");
    }

    function delete() {
        $this->archivobin = new tab_archivobin ();
        $this->archivobin->setRequest2Object($_REQUEST);

        $this->archivobin->setFil_id($_REQUEST ['fil_id']);
        $this->archivobin->setFil_estado(2);

        $this->archivobin->update();
    }

    function verif() {

    }

}

?>
