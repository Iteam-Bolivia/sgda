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
class modalidadController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->mod_id = "";
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
        $this->registry->template->show('tab_modalidadg.tpl');
        $this->registry->template->show('footer');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/modalidad/view/" . $_REQUEST["mod_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->modalidad = new tab_modalidad();
        $this->modalidad->setRequest2Object($_REQUEST);
        $row = $this->modalidad->dbselectByField("mod_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar Modalidad";
        $this->registry->template->mod_id = $row->mod_id;
        $this->registry->template->mod_codigo = $row->mod_codigo;
        $this->registry->template->mod_descripcion = $row->mod_descripcion;

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
        $this->registry->template->show('tab_modalidad.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $modalidad = new modalidad();
        $unidad = new unidad();
        $this->modalidad = new tab_modalidad();
        $this->modalidad->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'mod_id';
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
				FROM tab_modalidad AS m
                 WHERE m.mod_estado =  1 $where $sort $limit";

        $result = $this->modalidad->dbselectBySQL($sql);
        $total = $modalidad->count($where);
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
            $json .= "id:'" . $un->mod_id . "',";
            $json .= "cell:['" . $un->mod_id . "'";
            $json .= ",'" . addslashes($un->mod_codigo) . "'";
            $json .= ",'" . addslashes($un->mod_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->titulo = "Nueva Modalidad";
        $this->registry->template->mod_id = "";
        $this->registry->template->mod_codigo = "";
        $this->registry->template->mod_descripcion = "";

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
        $this->registry->template->show('tab_modalidad.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->modalidad = new tab_modalidad();
        $this->modalidad->setRequest2Object($_REQUEST);
        $this->modalidad->setMod_id($_REQUEST['mod_id']);
        $this->modalidad->setMOd_codigo($_REQUEST['mod_codigo']);
        $this->modalidad->setMod_descripcion($_REQUEST['mod_descripcion']);
        $this->modalidad->setMod_fecha_crea(date("Y-m-d"));
        $this->modalidad->setMod_usuario_crea($_SESSION['USU_ID']);
        $this->modalidad->setMod_estado(1);
        $mod_id = $this->modalidad->insert();
        Header("Location: " . PATH_DOMAIN . "/modalidad/");
    }

    function update() {
        $this->modalidad = new tab_modalidad();
        $this->modalidad->setRequest2Object($_REQUEST);
        $rows = $this->modalidad->dbselectByField("mod_id", $_REQUEST['mod_id']);
        $this->modalidad = $rows[0];
        $id = $this->modalidad->mod_id;
        $this->modalidad->setMod_id($_REQUEST['mod_id']);
        $this->modalidad->setMod_codigo($_REQUEST['mod_codigo']);
        $this->modalidad->setMod_descripcion($_REQUEST['mod_descripcion']);
        $this->modalidad->setMod_estado(1);
        $this->modalidad->update();

        Header("Location: " . PATH_DOMAIN . "/modalidad/");
    }

    function delete() {
        $this->modalidad = new tab_modalidad();
        $this->modalidad->setMod_id($_REQUEST['mod_id']);
        $this->modalidad->setMod_estado(2);
        $this->modalidad->update();
    }

    function listUsuarioJson() {
        $this->usu = new modalidad();
        echo $this->usu->listUsuarioJson();
    }

}

?>
