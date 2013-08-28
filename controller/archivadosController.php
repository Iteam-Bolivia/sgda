<?php

/**
 * archivadosController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class archivadosController extends baseController {

    function index() {
        $this->registry->template->id_archivado = "";
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
        $this->registry->template->show('tab_archivadosg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $archivados = new archivados();
        $this->archivados = new tab_archivados();
        $this->archivados->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'id_archivado';
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
            if ($qtype == 'id_archivado')
                $where = " and id_archivado = '$query' ";
            else
                $where = " AND $qtype LIKE '$query%' ";
        }
        $sql = "SELECT *
                 FROM tab_archivados AS u
                 WHERE 1 $where $sort $limit";

        $result = $this->archivados->dbselectBySQL($sql);
        $total = $archivados->count($where);
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
            $json .= "id:'" . $un->id_archivado . "',";
            $json .= "cell:['" . $un->id_archivado . "'";
            $json .= ",'" . addslashes($un->codigo) . "'";
            $json .= ",'" . addslashes($un->fecha) . "'";
            $json .= ",'" . addslashes($un->persona) . "'";
            $json .= ",'" . addslashes($un->lugar) . "'";
            $json .= ",'" . addslashes($un->observaciones) . "'";
            $json .= ",'" . addslashes($un->copia) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }


    function save() {
        $this->archivados = new tab_archivados();
        $this->archivados->setRequest2Object($_REQUEST);
        $this->archivados->setId_archivado($_REQUEST['id_archivado']);
        $this->archivados->setCodigo($_REQUEST['fon_cod']);
        $this->archivados->setFecha($_REQUEST['fon_descripcion']);
        $this->archivados->setPersona($_REQUEST['fon_orden']);
        $this->archivados->setLugar(date("Y-m-d"));
        $this->archivados->setObservaciones($_SESSION['USU_ID']);
        $this->archivados->setCopia("SI");
        $id_archivado = $this->archivados->insert();

        Header("Location: " . PATH_DOMAIN . "/archivados/");
    }

    function delete() {
        $this->archivados = new tab_archivados();
        $this->archivados->setId_archivado($_REQUEST['id_archivado']);
        $this->archivados->setCopia("NO");
        $this->archivados->update();
    }


}

?>
