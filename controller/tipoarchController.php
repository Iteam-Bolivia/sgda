<?php

/**
 * tipoarchController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class tipoarchController extends baseController {

    function index() {
        $this->registry->template->tar_id = "";
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
        $this->registry->template->show('tab_tipoarchg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $tipoarch = new tipoarch();
        $this->tipoarch = new tab_tipoarch();
        $this->tipoarch->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'tar_id';
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
            if ($qtype == 'tar_id')
                $where = " and tar_id = '$query' ";
            else
                $where = " AND $qtype LIKE '$query%' ";
        }
        $sql = "SELECT *
                 FROM tab_tipoarch AS u
                 WHERE u.tar_estado =  1 $where $sort $limit";

        $result = $this->tipoarch->dbselectBySQL($sql);
        $total = $tipoarch->count($where);
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
            $json .= "id:'" . $un->tar_id . "',";
            $json .= "cell:['" . $un->tar_id . "'";
            $json .= ",'" . addslashes($un->tar_codigo) . "'";
            $json .= ",'" . addslashes($un->tar_nombre) . "'";
            $json .= ",'" . addslashes($un->tar_orden) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/tipoarch/view/" . $_REQUEST["tar_id"] . "/");
    }

    function view() {
       if(! VAR3){ die("Error del sistema 404"); }
        $this->tipoarch = new tab_tipoarch();
        $this->tipoarch->setRequest2Object($_REQUEST);
        $row = $this->tipoarch->dbselectByField("tar_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar tipoarch";
        $this->registry->template->tar_id = $row->tar_id;
        $this->registry->template->tar_codigo = $row->tar_codigo;
        $this->registry->template->tar_nombre = $row->tar_nombre;
        $this->registry->template->tar_orden = $row->tar_orden;
        $this->registry->template->tar_estado = $row->tar_estado;

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
        $this->registry->template->show('tab_tipoarch.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $this->registry->template->titulo = "Nuevo tipoarch";
        $this->registry->template->tar_id = "";
        $this->registry->template->tar_codigo = "";
        $this->registry->template->tar_nombre = "";
        $this->registry->template->tar_orden = "";

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
        $this->registry->template->show('tab_tipoarch.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->tipoarch = new tab_tipoarch();
        $this->tipoarch->setRequest2Object($_REQUEST);
        $this->tipoarch->setTar_id($_REQUEST['tar_id']);
        $this->tipoarch->setTar_codigo($_REQUEST['tar_codigo']);
        $this->tipoarch->setTar_nombre($_REQUEST['tar_nombre']);
        $this->tipoarch->setTar_estado(1);
        $tar_id = $this->tipoarch->insert();

        Header("Location: " . PATH_DOMAIN . "/tipoarch/");
    }

    function update() {
        $this->tipoarch = new tab_tipoarch();
        $this->tipoarch->setRequest2Object($_REQUEST);
        $rows = $this->tipoarch->dbselectByField("tar_id", $_REQUEST['tar_id']);
        $this->tipoarch = $rows[0];
        $id = $this->tipoarch->tar_id;
        $this->tipoarch->setTar_id($_REQUEST['tar_id']);
        $this->tipoarch->setTar_codigo($_REQUEST['tar_codigo']);
        $this->tipoarch->setTar_nombre($_REQUEST['tar_nombre']);
        $this->tipoarch->setTar_orden($_REQUEST['tar_orden']);
        $this->tipoarch->setTar_estado(1);
        $this->tipoarch->update();

        Header("Location: " . PATH_DOMAIN . "/tipoarch/");
    }

    function delete() {
        $this->tipoarch = new tab_tipoarch();
        $this->tipoarch->setTar_id($_REQUEST['tar_id']);
        $this->tipoarch->setTar_estado(2);
        $this->tipoarch->update();
    }

}

?>
