<?php

/**
 * archivoController
 *
 * @package
 * @author lic. arsenio castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tiposolicitudController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->sol_id = "";
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
        $this->registry->template->show('tab_tiposolicitudg.tpl');
        $this->registry->template->show('footer');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/tiposolicitud/view/" . $_REQUEST["sol_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->tiposolicitud = new tab_tiposolicitud();
        $this->tiposolicitud->setRequest2Object($_REQUEST);
        $row = $this->tiposolicitud->dbselectByField("sol_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar Tipo de Solicitud";
        $this->registry->template->sol_id = $row->sol_id;
        $this->registry->template->sol_codigo = $row->sol_codigo;
        $this->registry->template->sol_descripcion = $row->sol_descripcion;

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
        $this->registry->template->show('tab_tiposolicitud.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $tiposolicitud = new tiposolicitud();
        $unidad = new unidad();
        $this->tiposolicitud = new tab_tiposolicitud();
        $this->tiposolicitud->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'sol_id';
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
        $sql = "SELECT *
				FROM tab_tiposolicitud AS t
                 WHERE t.sol_estado =  1 $where $sort $limit";

        $result = $this->tiposolicitud->dbselectBySQL($sql);
        $total = $tiposolicitud->count($where);
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
            $json .= "id:'" . $un->sol_id . "',";
            $json .= "cell:['" . $un->sol_id . "'";
            $json .= ",'" . addslashes($un->sol_codigo) . "'";
            $json .= ",'" . addslashes($un->sol_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->titulo = "Nuevo Tipo de Solicitud";
        $this->registry->template->sol_id = "";
        $this->registry->template->sol_codigo = "";
        $this->registry->template->sol_descripcion = "";

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
        $this->registry->template->show('tab_tiposolicitud.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->tiposolicitud = new tab_tiposolicitud();
        $this->tiposolicitud->setRequest2Object($_REQUEST);
        $this->tiposolicitud->setSol_id($_REQUEST['sol_id']);
        $this->tiposolicitud->setSol_codigo($_REQUEST['sol_codigo']);
        $this->tiposolicitud->setSol_descripcion($_REQUEST['sol_descripcion']);
        $this->tiposolicitud->setSol_fecha_crea(date("Y-m-d"));
        $this->tiposolicitud->setSol_usuario_crea($_SESSION['USU_ID']);
        $this->tiposolicitud->setSol_estado(1);
        $sol_id = $this->tiposolicitud->insert();
        Header("Location: " . PATH_DOMAIN . "/tiposolicitud/");
    }

    function update() {
        $this->tiposolicitud = new tab_tiposolicitud();
        $this->tiposolicitud->setRequest2Object($_REQUEST);
        $rows = $this->tiposolicitud->dbselectByField("sol_id", $_REQUEST['sol_id']);
        $this->tiposolicitud = $rows[0];
        $id = $this->tiposolicitud->sol_id;
        $this->tiposolicitud->setSol_id($_REQUEST['sol_id']);
        $this->tiposolicitud->setSol_codigo($_REQUEST['sol_codigo']);
        $this->tiposolicitud->setSol_descripcion($_REQUEST['sol_descripcion']);
        $this->tiposolicitud->setSol_estado(1);
        $this->tiposolicitud->update();

        Header("Location: " . PATH_DOMAIN . "/tiposolicitud/");
    }

    function delete() {
        $this->tiposolicitud = new tab_tiposolicitud();
        $this->tiposolicitud->setSol_id($_REQUEST['sol_id']);
        $this->tiposolicitud->setSol_estado(2);
        $this->tiposolicitud->update();
    }

    function listUsuarioJson() {
        $this->usu = new tiposolicitud();
        echo $this->usu->listUsuarioJson();
    }

}

?>
