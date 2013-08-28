<?php

/**
 * oficinaController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class oficinaController extends baseController {

    function index() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        //$this->llenarLinks();
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->ofi_id = '';
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_oficinag.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $this->oficina = new tab_oficina ();
        $oficina = new oficina ();
        $this->oficina->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ofi_id';
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
            if ($qtype == 'ofi_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT ofi_id,
                ofi_codigo,
                ofi_nombre,
                ofi_contador,
                ofi_estado
                FROM tab_oficina 
                WHERE ofi_estado = 1 $where $sort $limit ";
        $sql_c = "SELECT COUNT(ofi_id) FROM tab_oficina WHERE ofi_estado = 1 $where ";
        $result = $this->oficina->dbselectBySQL($sql);
        $total = $this->oficina->countBySQL($sql_c);
        /* header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
          header ( "Cache-Control: no-cache, must-revalidate" );
          header ( "Pragma: no-cache" ); */
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
            $json .= "id:'" . $un->ofi_id . "',";
            $json .= "cell:['" . $un->ofi_id . "'";
            $json .= ",'" . addslashes($un->ofi_codigo) . "'";
            $json .= ",'" . addslashes($un->ofi_nombre) . "'";
            $json .= ",'" . addslashes($un->ofi_contador) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        header("Location: " . PATH_DOMAIN . "/oficina/view/" . $_REQUEST["ofi_id"] . "/");
    }

    function view() {
        //if(! VAR3){ die("Error del sistema 404"); }
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->oficina = new tab_oficina ();
        $row = array();
        if (!is_null(VAR3))
            $row = $this->oficina->dbselectByField("ofi_id", VAR3);
        if (!isset($row[0])) {
            header("Location: " . PATH_DOMAIN . "/oficina/");
        }
        $row = $row [0];
        $oficina = new oficina ();
        $this->registry->template->titulo = "Editar Ofiel " . $row->getOfi_id();
        $this->registry->template->ofi_id = $row->getOfi_id();
        $this->registry->template->readonly = ''; 
        $this->registry->template->ofi_codigo = $row->getOfi_codigo();
        $this->registry->template->ofi_nombre = $row->getOfi_nombre();
        $this->registry->template->ofi_contador = $row->getOfi_contador();
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_oficina.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $oficina = new oficina ();
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->titulo = "NUEVO NIVEL ";
        $this->registry->template->ofi_id = "";
        $this->registry->template->ofi_codigo = '';
        $this->registry->template->ofi_nombre = '';
        $this->registry->template->ofi_contador = "0";
        $this->registry->template->readonly = '';        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_oficina.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $oficina = new tab_oficina ();
        $oficina->setRequest2Object($_REQUEST);
        $oficina->setOfi_id($_REQUEST['ofi_id']);
        $oficina->setOfi_codigo($_REQUEST['ofi_codigo']);
        $oficina->setOfi_nombre($_REQUEST['ofi_nombre']);
        $oficina->setOfi_contador($_REQUEST['ofi_contador']);
        $oficina->setOfi_estado(1);
        $oficina->insert();
        Header("Location: " . PATH_DOMAIN . "/oficina/");
    }

    function update() {
        $oficina = new tab_oficina ();
        $oficina->setRequest2Object($_REQUEST);
        $oficina->setOfi_id($_REQUEST['ofi_id']);        
        $oficina->setOfi_codigo($_REQUEST['ofi_codigo']);
        $oficina->setOfi_nombre($_REQUEST['ofi_nombre']);
        $oficina->setOfi_contador($_REQUEST['ofi_contador']);
        $oficina->setOfi_usu_mod($_SESSION['USU_ID']);
        $oficina->setOfi_fecha_mod(date("Y-m-d"));
        $oficina->setOfi_estado(1);

        $oficina->update();
        Header("Location: " . PATH_DOMAIN . "/oficina/");
    }

    function delete() {
        $toficina = new tab_oficina ();
        $toficina->setRequest2Object($_REQUEST);
        $ofi_id = $_REQUEST['ofi_id'];
        $toficina->setOfi_id($ofi_id);
        $toficina->setOfi_estado(2);
        $toficina->update();
        echo 'OK';
    }


    
}

?>
