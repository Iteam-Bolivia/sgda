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
class palclaveController Extends baseController {

    function index() {
        $this->registry->template->pac_id = "";
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
        $this->registry->template->show('tab_palclaveg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $palclave = new palclave();
        $this->palclave = new tab_palclave();
        $this->palclave->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'pac_id';
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
            if ($qtype == 'pac_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT 
                 pac_id, 
                 pac_nombre, 
                 pac_formulario
                 FROM tab_palclave
                 WHERE pac_estado = 1 $where $sort $limit";

        $result = $this->palclave->dbselectBySQL($sql);
        $total = $palclave->count($where);
        
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
            $json .= "id:'" . $un->pac_id . "',";
            $json .= "cell:['" . $un->pac_id . "'";
            $json .= ",'" . addslashes($un->pac_nombre) . "'";
            $json .= ",'" . addslashes($un->pac_formulario) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/palclave/view/" . $_REQUEST["pac_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->palclave = new tab_palclave();
        $this->palclave->setRequest2Object($_REQUEST);
        $row = $this->palclave->dbselectByField("pac_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "EDITAR PALABRA CLAVE";
        $this->registry->template->pac_id = $row->pac_id;
        $this->registry->template->pac_nombre = $row->pac_nombre;
        $this->registry->template->pac_formulario = $row->pac_formulario;

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
        $this->registry->template->show('tab_palclave.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $this->registry->template->pac_id = "";
        $this->registry->template->pac_nombre = "";
        $this->registry->template->pac_formulario = "";

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->titulo = "NUEVA PALABRA CLAVE";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_palclave.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->palclave = new tab_palclave();
        $this->palclave->setRequest2Object($_REQUEST);
        $this->palclave->setPac_id($_REQUEST['pac_id']);
        $this->palclave->setPac_nombre($_REQUEST['pac_nombre']);
        $this->palclave->setPac_formulario($_REQUEST['pac_formulario']);
        $this->palclave->setPac_estado(1);
        $pac_id = $this->palclave->insert();

        Header("Location: " . PATH_DOMAIN . "/palclave/");
    }

    function update() {
        $this->palclave = new tab_palclave();
        $this->palclave->setRequest2Object($_REQUEST);
        $rows = $this->palclave->dbselectByField("pac_id", $_REQUEST['pac_id']);
        $this->palclave = $rows[0];
        $id = $this->palclave->pac_id;
        $this->palclave->setPac_id($_REQUEST['pac_id']);
        $this->palclave->setPac_nombre($_REQUEST['pac_nombre']);
        $this->palclave->setPac_formulario($_REQUEST['pac_formulario']);
        $this->palclave->setPac_estado(1);
        $this->palclave->update();

        Header("Location: " . PATH_DOMAIN . "/palclave/");
    }

    function delete() {
        $this->palclave = new tab_palclave();
        $this->palclave->setPac_id($_REQUEST['pac_id']);
        $this->palclave->setPac_estado(2);
        $this->palclave->update();
    }

    
    
}

?>
