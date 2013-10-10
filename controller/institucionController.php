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
class institucionController Extends baseController {

    function index() {
        $this->registry->template->int_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_instituciong.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $institucion = new institucion();
        $this->institucion = new tab_institucion();
        $this->institucion->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'int_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15; //10
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";

        if ($query) {
            if ($qtype == 'int_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT *
                 FROM tab_institucion
                 WHERE int_estado =  1 $where $sort $limit";

        $result = $this->institucion->dbselectBySQL($sql);
        $total = $institucion->count($where);
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
            $json .= "id:'" . $un->int_id . "',";
            $json .= "cell:['" . $un->int_id . "'";
            $json .= ",'" . addslashes($un->int_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/institucion/view/" . $_REQUEST["int_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->institucion = new tab_institucion();
        $this->institucion->setRequest2Object($_REQUEST);
        $row = $this->institucion->dbselectByField("int_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "Editar Institucion";
        $this->registry->template->int_id = $row->int_id;
        $this->registry->template->int_descripcion = $row->int_descripcion;
        
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_institucion.tpl');
        $this->registry->template->show('footer');
    }



    function add() {
        $this->registry->template->titulo = "Nuevo Institucion";

        $this->registry->template->int_id = "";
        $this->registry->template->int_descripcion = "";
        
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_institucion.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->institucion = new tab_institucion();
        $this->institucion->setRequest2Object($_REQUEST);

        $this->institucion->setInt_id($_REQUEST['int_id']);
        $this->institucion->setInt_descripcion($_REQUEST['int_descripcion']);
        $this->institucion->setInt_fecha_crea(date("Y-m-d"));
        $this->institucion->setInt_usu_crea($_SESSION['USU_ID']);
        $this->institucion->setInt_estado(1);

        $int_id = $this->institucion->insert();

        Header("Location: " . PATH_DOMAIN . "/institucion/");
    }

    function update() {
        $this->institucion = new tab_institucion();
        $this->institucion->setRequest2Object($_REQUEST);

        $rows = $this->institucion->dbselectByField("int_id", $_REQUEST['int_id']);
        $this->institucion = $rows[0];
        $id = $this->institucion->int_id;

        $this->institucion->setInt_id($_REQUEST['int_id']);
        $this->institucion->setInt_descripcion($_REQUEST['int_descripcion']);
        $this->institucion->setInt_estado(1);

        $this->institucion->update();

        Header("Location: " . PATH_DOMAIN . "/institucion/");
    }

    function delete() {

        $this->institucion = new tab_institucion();

        $this->institucion->setInt_id($_REQUEST['int_id']);
        $this->institucion->setInt_estado(0);
        $this->institucion->update();
    }

    

}

?>
