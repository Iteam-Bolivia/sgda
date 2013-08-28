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
class tipocorrController Extends baseController {

    function index() {
        $this->registry->template->tco_id = "";
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
        $this->registry->template->show('tab_tipocorrg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $tipocorr = new tipocorr();
        $this->tipocorr = new tab_tipocorr();
        $this->tipocorr->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'tco_id';
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
            if ($qtype == 'tco_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT 
                 tco_id, 
                 tco_codigo,
                 tco_nombre                  
                 FROM tab_tipocorr
                 WHERE tco_estado = 1 $where $sort $limit";

        $result = $this->tipocorr->dbselectBySQL($sql);
        $total = $tipocorr->count($where);
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
            $json .= "id:'" . $un->tco_id . "',";
            $json .= "cell:['" . $un->tco_id . "'";
            $json .= ",'" . addslashes($un->tco_codigo) . "'";
            $json .= ",'" . addslashes($un->tco_nombre) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->tco_id = "";
        $this->registry->template->tco_nombre = "";
        $this->registry->template->tco_codigo = "";

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
        $this->registry->template->show('tab_tipocorr.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->tipocorr = new tab_tipocorr();
        $this->tipocorr->setRequest2Object($_REQUEST);
        $this->tipocorr->setTco_id($_REQUEST['tco_id']);
        $this->tipocorr->setTco_codigo($_REQUEST['tco_codigo']);
        $this->tipocorr->setTco_nombre($_REQUEST['tco_nombre']);
        $this->tipocorr->setTco_estado(1);
        $tco_id = $this->tipocorr->insert();

        Header("Location: " . PATH_DOMAIN . "/tipocorr/");
    }
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/tipocorr/view/" . $_REQUEST["tco_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->tipocorr = new tab_tipocorr();
        $this->tipocorr->setRequest2Object($_REQUEST);
        $row = $this->tipocorr->dbselectByField("tco_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "EDITAR CLASE DE SERIE";
        $this->registry->template->tco_id = $row->tco_id;
        $this->registry->template->tco_nombre = $row->tco_nombre;
        $this->registry->template->tco_codigo = $row->tco_codigo;

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
        $this->registry->template->show('tab_tipocorr.tpl');
        $this->registry->template->show('footer');
    }



    function update() {
        $this->tipocorr = new tab_tipocorr();
        $this->tipocorr->setRequest2Object($_REQUEST);
        $rows = $this->tipocorr->dbselectByField("tco_id", $_REQUEST['tco_id']);
        $this->tipocorr = $rows[0];
        $id = $this->tipocorr->tco_id;
        $this->tipocorr->setTco_id($_REQUEST['tco_id']);
        $this->tipocorr->setTco_codigo($_REQUEST['tco_codigo']);
        $this->tipocorr->setTco_nombre($_REQUEST['tco_nombre']);
        $this->tipocorr->setTco_estado(1);
        $this->tipocorr->update();

        Header("Location: " . PATH_DOMAIN . "/tipocorr/");
    }

    function delete() {
        $this->tipocorr = new tab_tipocorr();
        $this->tipocorr->setTco_id($_REQUEST['tco_id']);
        $this->tipocorr->setTco_estado(0);
        $this->tipocorr->update();
    }  
    
    function listTipocorrJson() {
        $this->tco = new tipocorr();
        echo $this->tco->listTipocorrJson();
    }

   
}

?>
