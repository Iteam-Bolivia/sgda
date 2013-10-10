<?php

/**
 * archivoController
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tipodocController Extends baseController {

    function index() {
        //verifica si es superadministrador para mostrar add y delete
        $admin = new usuario();
        $esAdmin = $admin->esAdm();
        $this->registry->template->esAdmin = $esAdmin;
        //////
        $this->registry->template->tdo_id = "";
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
        $this->registry->template->show('tab_tipodocg.tpl');
        $this->registry->template->show('footer');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/tipodoc/view/" . $_REQUEST["tdo_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->tipodoc = new tab_tipodoc();
        $this->tipodoc->setRequest2Object($_REQUEST);
        $row = $this->tipodoc->dbselectByField("tdo_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "Editar Tipo Documento";
        $this->registry->template->tdo_id = $row->tdo_id;
        $this->registry->template->tdo_nombre = $row->tdo_nombre;
        $this->registry->template->tdo_codigo = $row->tdo_codigo;

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
        $this->registry->template->show('tab_tipodoc.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $tipodoc = new tipodoc();
        $this->tipodoc = new tab_tipodoc();
        $this->tipodoc->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'tdo_id';
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
            if ($qtype == 'tdo_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT tdo_id, tdo_nombre, tdo_codigo
                 FROM tab_tipodoc
                 WHERE tdo_estado =  1 $where $sort $limit";

        $result = $this->tipodoc->dbselectBySQL($sql);
        $total = $tipodoc->count($where);
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
            $json .= "id:'" . $un->tdo_id . "',";
            $json .= "cell:['" . $un->tdo_id . "'";
            $json .= ",'" . addslashes($un->tdo_codigo) . "'";
            $json .= ",'" . addslashes($un->tdo_nombre) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->titulo = "Nuevo Tipo Documento";

        $this->registry->template->tdo_id = "";
        $this->registry->template->tdo_nombre = "";
        $this->registry->template->tdo_codigo = "";

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
        $this->registry->template->show('tab_tipodoc.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->tipodoc = new tab_tipodoc();
        $this->tipodoc->setRequest2Object($_REQUEST);

        $this->tipodoc->settdo_id($_REQUEST['tdo_id']);
        $this->tipodoc->settdo_codigo($_REQUEST['tdo_codigo']);
        $this->tipodoc->settdo_nombre($_REQUEST['tdo_nombre']);
        $this->tipodoc->settdo_estado(1);

        $tdo_id = $this->tipodoc->insert();

        Header("Location: " . PATH_DOMAIN . "/tipodoc/");
    }

    function update() {
        $this->tipodoc = new tab_tipodoc();
        $this->tipodoc->setRequest2Object($_REQUEST);

        $rows = $this->tipodoc->dbselectByField("tdo_id", $_REQUEST['tdo_id']);
        $this->tipodoc = $rows[0];
        $id = $this->tipodoc->tdo_id;

        $this->tipodoc->settdo_id($_REQUEST['tdo_id']);
        $this->tipodoc->settdo_codigo($_REQUEST['tdo_codigo']);
        $this->tipodoc->settdo_nombre($_REQUEST['tdo_nombre']);
        $this->tipodoc->settdo_estado(1);

        $this->tipodoc->update();

        Header("Location: " . PATH_DOMAIN . "/tipodoc/");
    }

    function validaDepen() {

        $tipodoc = new tipodoc();

        //$this->tipodoc->settdo_id($_REQUEST['tdo_id']);

        $swDepen = $tipodoc->validaDependencia($_REQUEST['tdo_id']);
        if ($swDepen != 0) {
            echo 'No se puede borrar el tipodoc tiene estaciones .';
        }
        echo '';
        // $this->tipodoc->settdo_estado(0);
        //$this->tipodoc->update();
    }

    function delete() {

        $this->tipodoc = new tab_tipodoc();

        $this->tipodoc->settdo_id($_REQUEST['tdo_id']);
        $this->tipodoc->settdo_estado(0);
        $this->tipodoc->update();
    }

}

?>
