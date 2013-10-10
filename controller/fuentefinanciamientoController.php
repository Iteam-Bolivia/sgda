<?php

/**
 * archivoController
 *
 * @package
 * @author lic. castellon
 * @revised Ing. Arsenio Castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class fuentefinanciamientoController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->ff_id = "";
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
        $this->registry->template->show('tab_fuentefinanciamientog.tpl');
        $this->registry->template->show('footer');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/fuentefinanciamiento/view/" . $_REQUEST["ff_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->fuentefinanciamiento = new tab_fuentefinanciamiento();
        $this->fuentefinanciamiento->setRequest2Object($_REQUEST);
        $row = $this->fuentefinanciamiento->dbselectByField("ff_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar Fuente de Financiamiento";
        $this->registry->template->ff_id = $row->ff_id;
        $this->registry->template->ff_codigo = $row->ff_codigo;
        $this->registry->template->ff_descripcion = $row->ff_descripcion;

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
        $this->registry->template->show('tab_fuentefinanciamiento.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $fuentefinanciamiento = new fuentefinanciamiento();
        $unidad = new unidad();
        $this->fuentefinanciamiento = new tab_fuentefinanciamiento();
        $this->fuentefinanciamiento->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ff_id';
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
				FROM tab_fuentefinanciamiento AS f
                 WHERE f.ff_estado =  1 $where $sort $limit";

        $result = $this->fuentefinanciamiento->dbselectBySQL($sql);
        $total = $fuentefinanciamiento->count($where);
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
            $json .= "id:'" . $un->ff_id . "',";
            $json .= "cell:['" . $un->ff_id . "'";
            $json .= ",'" . addslashes($un->ff_codigo) . "'";
            $json .= ",'" . addslashes($un->ff_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->titulo = "Nueva Fuente de Financiamiento";
        $this->registry->template->ff_id = "";
        $this->registry->template->ff_codigo = "";
        $this->registry->template->ff_descripcion = "";

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
        $this->registry->template->show('tab_fuentefinanciamiento.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->fuentefinanciamiento = new tab_fuentefinanciamiento();
        $this->fuentefinanciamiento->setRequest2Object($_REQUEST);
        $this->fuentefinanciamiento->setFF_id($_REQUEST['ff_id']);
        $this->fuentefinanciamiento->setFF_codigo($_REQUEST['ff_codigo']);
        $this->fuentefinanciamiento->setFF_descripcion($_REQUEST['ff_descripcion']);
        $this->fuentefinanciamiento->setFF_fecha_crea(date("Y-m-d"));
        $this->fuentefinanciamiento->setFF_usuario_crea($_SESSION['USU_ID']);
        $this->fuentefinanciamiento->setFF_estado(1);
        $ff_id = $this->fuentefinanciamiento->insert();
        Header("Location: " . PATH_DOMAIN . "/fuentefinanciamiento/");
    }

    function update() {
        $this->fuentefinanciamiento = new tab_fuentefinanciamiento();
        $this->fuentefinanciamiento->setRequest2Object($_REQUEST);
        $rows = $this->fuentefinanciamiento->dbselectByField("ff_id", $_REQUEST['ff_id']);
        $this->fuentefinanciamiento = $rows[0];
        $id = $this->fuentefinanciamiento->ff_id;
        $this->fuentefinanciamiento->setFF_id($_REQUEST['ff_id']);
        $this->fuentefinanciamiento->setFF_codigo($_REQUEST['ff_codigo']);
        $this->fuentefinanciamiento->setFF_descripcion($_REQUEST['ff_descripcion']);
        $this->fuentefinanciamiento->setFF_estado(1);
        $this->fuentefinanciamiento->update();


        Header("Location: " . PATH_DOMAIN . "/fuentefinanciamiento/");
    }

    function delete() {
        $this->fuentefinanciamiento = new tab_fuentefinanciamiento();
        $this->fuentefinanciamiento->setFF_id($_REQUEST['ff_id']);
        $this->fuentefinanciamiento->setFF_estado(2);
        $this->fuentefinanciamiento->update();
    }

    function listUsuarioJson() {
        $this->usu = new fuentefinanciamiento();
        echo $this->usu->listUsuarioJson();
    }

}

?>
