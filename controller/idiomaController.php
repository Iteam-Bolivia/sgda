<?php

/**
 * archivoController
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class idiomaController Extends baseController {

    function index() {
        $admin = new usuario();
        $esAdmin = $admin->esAdm();
        $this->registry->template->esAdmin = $esAdmin;
        $this->registry->template->idi_id = "";
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
        $this->registry->template->show('tab_idiomag.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $idioma = new idioma();
        $this->idioma = new tab_idioma();
        $this->idioma->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'idi_id';
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
            if ($qtype == 'idi_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT 
                 idi_id, 
                 idi_nombre, 
                 idi_codigo
                 FROM tab_idioma
                 WHERE idi_estado = 1 $where $sort $limit";

        $result = $this->idioma->dbselectBySQL($sql);       
        $total = $idioma->count($where);
        //print_r($result);echo("<br/>".$total);die;
        /* header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
          header("Cache-Control: no-cache, must-revalidate" );
          header("Pragma: no-cache" ); */
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
            $json .= "id:'" . $un->idi_id . "',";
            $json .= "cell:['" . $un->idi_id . "'";
            $json .= ",'" . addslashes($un->idi_codigo) . "'";
            $json .= ",'" . addslashes($un->idi_nombre) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->idi_id = "";
        $this->registry->template->idi_nombre = "";
        $this->registry->template->idi_codigo = "";
        
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->titulo = "NUEVO idioma";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_idioma.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->idioma = new tab_idioma();
        $this->idioma->setRequest2Object($_REQUEST);
        $this->idioma->setIdi_id($_REQUEST['idi_id']);
        $this->idioma->setIdi_codigo($_REQUEST['idi_codigo']);
        $this->idioma->setIdi_nombre($_REQUEST['idi_nombre']);
        $this->idioma->setIdi_estado(1);
        $idi_id = $this->idioma->insert();

        Header("Location: " . PATH_DOMAIN . "/idioma/");
    }
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/idioma/view/" . $_REQUEST["idi_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->idioma = new tab_idioma();
        $this->idioma->setRequest2Object($_REQUEST);
        $row = $this->idioma->dbselectByField("idi_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "EDITAR idioma";
        $this->registry->template->idi_id = $row->idi_id;
        $this->registry->template->idi_nombre = $row->idi_nombre;
        $this->registry->template->idi_codigo = $row->idi_codigo;

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
        $this->registry->template->show('tab_idioma.tpl');
        $this->registry->template->show('footer');
    }



    function update() {
        $this->idioma = new tab_idioma();
        $this->idioma->setRequest2Object($_REQUEST);
        $rows = $this->idioma->dbselectByField("idi_id", $_REQUEST['idi_id']);
        $this->idioma = $rows[0];
        $id = $this->idioma->idi_id;
        $this->idioma->setIdi_id($_REQUEST['idi_id']);
        $this->idioma->setIdi_codigo($_REQUEST['idi_codigo']);
        $this->idioma->setIdi_nombre($_REQUEST['idi_nombre']);
        $this->idioma->setIdi_estado(1);
        $this->idioma->update();

        Header("Location: " . PATH_DOMAIN . "/idioma/");
    }

    function delete() {
        $this->idioma = new tab_idioma();
        $this->idioma->setIdi_id($_REQUEST['idi_id']);
        $this->idioma->setIdi_estado(2);
        $this->idioma->update();
    }

    function listIdiomaJson() {
        $this->idi = new idioma();
        echo $this->idi->listIdiomaJson();
    }

    
}

?>
