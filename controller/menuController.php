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
class menuController extends baseController {

    function index() {
        $this->registry->template->men_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_menug.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $this->menu = new tab_menu ();
        $this->menu->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'men_id';
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
            if ($qtype == 'men_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT * 
                FROM tab_menu AS u
                WHERE u.men_estado = 1 
                $where $sort $limit";

        $result = $this->menu->dbselectBySQL($sql);
        $menu = new menu();
        $total = $menu->count($where);
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
            $json .= "id:'" . $un->men_id . "',";
            $json .= "cell:['" . $un->men_id . "'";
            $json .= ",'" . addslashes($un->men_titulo) . "'";
            $json .= ",'" . addslashes($un->men_enlace) . "'";
            $json .= ",'" . addslashes($un->men_posicion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }


    function add() {
        $menu = new menu();
        $this->registry->template->men_id = "";
        $this->registry->template->men_par = $menu->obtenerMenus();
        $this->registry->template->men_tit = "";
        $this->registry->template->men_enlace = "";
        $this->registry->template->men_posicion = "Izquierda";
        $this->registry->template->titulo = "NUEVO MENUS DE OPCIONES";
        
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";        
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_menu.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $menu = new tab_menu();
        $menu->setRequest2Object($_REQUEST);
        $menu->setMen_id($_REQUEST['men_id']);
        $menu->setMen_par($_REQUEST['men_par']);
        $menu->setMen_titulo($_REQUEST['men_tit']);
        $menu->setMen_enlace($_REQUEST['men_enlace']);
        $menu->setMen_posicion($_REQUEST['men_posicion']);
        $menu->setMen_estado(1);
        $menu->insert();
        Header("Location: " . PATH_DOMAIN . "/menu/");
    }
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/menu/view/" . $_REQUEST["men_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $menu = new menu();

        $this->menu = new tab_menu();
        $this->menu->setRequest2Object($_REQUEST);
        $row = $this->menu->dbselectByField("men_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->men_id = $row->men_id;
        $this->registry->template->men_par = $menu->obtenerMenus($row->men_par);
        $this->registry->template->men_tit = $row->men_titulo;
        $this->registry->template->men_enlace = $row->men_enlace;
        $this->registry->template->men_posicion = $row->men_posicion;

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;        
        $this->registry->template->titulo = "EDITAR MENU DE OPCIONES";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_menu.tpl');
        $this->registry->template->show('footer');
    }


    function update() {
        $menu = new tab_menu();
        $menu->setRequest2Object($_REQUEST);
        $menu->setMen_id($_REQUEST['men_id']);
        $menu->setMen_par($_REQUEST['men_par']);
        $menu->setMen_titulo($_REQUEST['men_tit']);
        $menu->setMen_enlace($_REQUEST['men_enlace']);
        $menu->setMen_posicion($_REQUEST['men_posicion']);
        $menu->setMen_estado(1);
        $menu->update();
        Header("Location: " . PATH_DOMAIN . "/menu/");
    }

    function delete() {
        $this->menu = new tab_menu ();
        $this->menu->setRequest2Object($_REQUEST);
        $this->menu->setMen_id($_REQUEST ['men_id']);
        $this->menu->setMen_estado(2);
        $this->menu->update();
    }

}

?>
