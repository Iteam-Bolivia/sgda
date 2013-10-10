<?php

/**
 * gestionController
 *
 * @package
 * @author lic. arsenio castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class gestionController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->ges_id = "";
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
        $this->registry->template->show('tab_gestiong.tpl');
        $this->registry->template->show('footer');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/gestion/view/" . $_REQUEST["ges_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->gestion = new tab_gestion();
        $this->gestion->setRequest2Object($_REQUEST);
        $row = $this->gestion->dbselectByField("ges_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar Gestiones";
        $this->registry->template->ges_id = $row->ges_id;
        $this->registry->template->ges_nombre = $row->ges_nombre;
        $this->registry->template->ges_numero = $row->ges_numero;
        //
        $gestion = new gestion();
        $this->registry->template->ges_estado = $gestion->obtenerSelect($row->ges_estado);
        //
        $this->series = new series();
        $this->registry->template->series = $this->series->getTitle($row->ser_id) . '<input name="ser_id" id="ser_id" type="hidden" value="' . $row->ser_id . '" />';

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
        $this->registry->template->show('tab_gestion.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $gestion = new gestion();
        $unidad = new unidad();
        $this->gestion = new tab_gestion();
        $this->gestion->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ges_id';
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
        $sql = "SELECT
				tab_gestion.ges_id,
				tab_gestion.ges_nombre,
				tab_gestion.ges_numero,
				tab_gestion.ges_estado,
				tab_series.ser_categoria
				FROM
				tab_series Inner Join tab_gestion ON tab_series.ser_id = tab_gestion.ser_id
                $sort $limit";




        $result = $this->gestion->dbselectBySQL($sql);
        $total = $gestion->count($where);
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
            $json .= "id:'" . $un->ges_id . "',";
            $json .= "cell:['" . $un->ges_id . "'";
            $json .= ",'" . addslashes($un->ges_nombre) . "'";
            $json .= ",'" . addslashes($un->ges_numero) . "'";
            $json .= ",'" . addslashes($un->ges_estado) . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->titulo = "Nueva Empresa";

        $this->registry->template->ges_id = "";
        $this->registry->template->ges_nombre = "";
        $this->registry->template->ges_numero = "";
        $this->registry->template->ges_estado = "<select name='ges_estado' id='ges_estado' class='required'><option value='1'>Activo</option><option value='0' selected>Inactivo</option></select>";
        $this->series = new series();
        $this->registry->template->series = "<select name='ser_id' id='ser_id' class='required'>" . $this->series->obtenerSelect("admin", $_SESSION['USU_ID']) . "</select>";

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
        $this->registry->template->show('tab_gestion.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->gestion = new tab_gestion();
        $this->gestion->setRequest2Object($_REQUEST);
        $this->gestion->setGes_id($_REQUEST['ges_id']);
        $this->gestion->setGes_nombre($_REQUEST['ges_nombre']);
        $this->gestion->setGes_numero($_REQUEST['ges_numero']);
        $this->gestion->setGes_estado($_REQUEST['ges_estado']);
        $ser_id = $_REQUEST['ser_id'];
        $this->gestion->setSer_id($_REQUEST['ser_id']);

        $ges_id = $this->gestion->insert();
        Header("Location: " . PATH_DOMAIN . "/gestion/");
    }

    function update() {
        $this->gestion = new tab_gestion();
        $this->gestion->setRequest2Object($_REQUEST);
        $rows = $this->gestion->dbselectByField("ges_id", $_REQUEST['ges_id']);
        $this->gestion = $rows[0];
        $id = $this->gestion->ges_id;
        $this->gestion->setGes_id($_REQUEST['ges_id']);
        $this->gestion->setGes_nombre($_REQUEST['ges_nombre']);
        $this->gestion->setGes_numero($_REQUEST['ges_numero']);
        $this->gestion->setGes_estado($_REQUEST['ges_estado']);
        $this->gestion->setSer_id($_REQUEST['ser_id']);


        $this->gestion->update();

        Header("Location: " . PATH_DOMAIN . "/gestion/");
    }

    function delete() {
        $this->gestion = new tab_gestion();
        $this->gestion->setGes_id($_REQUEST['ges_id']);
        $this->gestion->setGes_estado(2);
        $this->gestion->update();
    }

    function listUsuarioJson() {
        $this->usu = new gestion();
        echo $this->usu->listUsuarioJson();
    }

}

?>
