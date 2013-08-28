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
class retensiondocController Extends baseController {

    function index() {
        $this->registry->template->red_id = "";
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
        $this->registry->template->show('tab_retensiondocg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $retensiondoc = new retensiondoc();
        $this->retensiondoc = new tab_retensiondoc();
        $this->retensiondoc->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'red_id';
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
            if ($qtype == 'red_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT 
                 red_id, 
                 red_codigo,
                 red_series,
                 red_tipodoc,
                 red_valdoc,
                 red_prearc,
                 red_estado
                 FROM tab_retensiondoc
                 WHERE red_estado = 1 $where $sort $limit";

        $result = $this->retensiondoc->dbselectBySQL($sql);
        $total = $retensiondoc->count($where);
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
            $json .= "id:'" . $un->red_id . "',";
            $json .= "cell:['" . $un->red_id . "'";
            $json .= ",'" . addslashes($un->red_codigo) . "'";
            $json .= ",'" . addslashes($un->red_series) . "'";
            $json .= ",'" . addslashes($un->red_tipodoc) . "'";
            $json .= ",'" . addslashes($un->red_valdoc) . "'";
            $json .= ",'" . addslashes($un->red_prearc) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->red_id = "";
        $this->registry->template->red_codigo = "";
        $this->registry->template->red_series = "";
        $this->registry->template->red_tipodoc = "";
        $this->registry->template->red_valdoc = "";
        $this->registry->template->red_prearc = "";        

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->titulo = "NUEVA CLASE DE SERIE";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_retensiondoc.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->retensiondoc = new tab_retensiondoc();
        $this->retensiondoc->setRequest2Object($_REQUEST);
        $this->retensiondoc->setRed_id($_REQUEST['red_id']);
        $this->retensiondoc->setRed_codigo($_REQUEST['red_codigo']);
        $this->retensiondoc->setRed_series($_REQUEST['red_series']);
        $this->retensiondoc->setRed_tipodoc($_REQUEST['red_tipodoc']);
        $this->retensiondoc->setRed_valdoc($_REQUEST['red_valdoc']);
        $this->retensiondoc->setRed_prearc($_REQUEST['red_prearc']);        
        $this->retensiondoc->setRed_estado(1);
        $red_id = $this->retensiondoc->insert();

        Header("Location: " . PATH_DOMAIN . "/retensiondoc/");
    }
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/retensiondoc/view/" . $_REQUEST["red_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->retensiondoc = new tab_retensiondoc();
        $this->retensiondoc->setRequest2Object($_REQUEST);
        $row = $this->retensiondoc->dbselectByField("red_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "EDITAR CLASE DE SERIE";
        $this->registry->template->red_id = $row->red_id;
        $this->registry->template->red_codigo = $row->red_codigo;
        $this->registry->template->red_series = $row->red_series;
        $this->registry->template->red_tipodoc = $row->red_tipodoc;
        $this->registry->template->red_valdoc = $row->red_valdoc;
        $this->registry->template->red_prearc = $row->red_prearc;        

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
        $this->registry->template->show('tab_retensiondoc.tpl');
        $this->registry->template->show('footer');
    }



    function update() {
        $this->retensiondoc = new tab_retensiondoc();
        $this->retensiondoc->setRequest2Object($_REQUEST);
        $rows = $this->retensiondoc->dbselectByField("red_id", $_REQUEST['red_id']);
        $this->retensiondoc = $rows[0];
        $id = $this->retensiondoc->red_id;
        $this->retensiondoc->setRed_id($_REQUEST['red_id']);
        $this->retensiondoc->setRed_codigo($_REQUEST['red_codigo']);
        $this->retensiondoc->setRed_series($_REQUEST['red_series']);
        $this->retensiondoc->setRed_valdoc($_REQUEST['red_valdoc']);
        $this->retensiondoc->setRed_prearc($_REQUEST['red_prearc']);
        $this->retensiondoc->setRed_estado(1);
        $this->retensiondoc->update();

        Header("Location: " . PATH_DOMAIN . "/retensiondoc/");
    }

    function delete() {
        $this->retensiondoc = new tab_retensiondoc();
        $this->retensiondoc->setRed_id($_REQUEST['red_id']);
        $this->retensiondoc->setRed_estado(2);
        $this->retensiondoc->update();
    }  
    
    function listRetensiondocJson() {
        $this->red = new retensiondoc();
        echo $this->red->listRetensiondocJson();
    }

   
}

?>
