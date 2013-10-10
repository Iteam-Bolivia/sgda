<?php

/**
 * tipocontenedorController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tipocontenedorController extends baseController {

    function index() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        //$this->llenarLinks();
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->ctp_id = '';
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_tipocontenedorg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $this->tipocontenedor = new tab_tipocontenedor ();
        $tipocontenedor = new tipocontenedor ();
        $this->tipocontenedor->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ctp_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        if ($query) {
            if ($qtype == 'ctp_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT
                ctp_id,
                ctp_codigo,
                ctp_descripcion,
                CASE WHEN ctp_nivel = '1' THEN 'CONTENEDOR' ELSE 'SUBCONTENEDOR' END AS ctp_nivel,
                ctp_estado
                FROM tab_tipocontenedor
                WHERE ctp_estado = 1 $where $sort $limit ";

        $sql_c = "SELECT COUNT(ctp_id) FROM tab_tipocontenedor WHERE ctp_estado = 1 $where ";
        $result = $this->tipocontenedor->dbselectBySQL($sql);
        $total = $this->tipocontenedor->countBySQL($sql_c);
        /* header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
          header ( "Cache-Control: no-cache, must-revalidate" );
          header ( "Pragma: no-cache" ); */
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
            $json .= "id:'" . $un->ctp_id . "',";
            $json .= "cell:['" . $un->ctp_id . "'";
            $json .= ",'" . addslashes($un->ctp_codigo) . "'";
            $json .= ",'" . addslashes($un->ctp_descripcion) . "'";
            $json .= ",'" . addslashes($un->ctp_nivel) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        header("Location: " . PATH_DOMAIN . "/tipocontenedor/view/" . $_REQUEST["ctp_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->tipocontenedor = new tab_tipocontenedor ();
        $row = array();
        if (!is_null(VAR3))
            $row = $this->tipocontenedor->dbselectByField("ctp_id", VAR3);
            if(! $row){ die("Error del sistema 404"); }
        if (!isset($row[0])) {
            header("Location: " . PATH_DOMAIN . "/tipocontenedor/");
        }
        $row = $row [0];       
        $this->registry->template->titulo = "EDITAR TIPO DE CONTENEDOR " . $row->ctp_id;
        $this->registry->template->ctp_id = $row->ctp_id;        
        if ($row->ctp_nivel==1){
            $this->registry->template->ctp_nivel = "<option value='1' selected>CONTENEDOR</option><option value='2'>SUBCONTENEDOR</option>";                        
        }else{
            $this->registry->template->ctp_nivel = "<option value='1'>CONTENEDOR</option><option value='2' selected>SUBCONTENEDOR</option>";                        
        }
        
        $this->registry->template->ctp_codigo = $row->ctp_codigo;
        $this->registry->template->ctp_descripcion = $row->ctp_descripcion;
        $this->registry->template->readonly = '';
        
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_tipocontenedor.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $tipocontenedor = new tipocontenedor ();
        $this->registry->template->titulo = "NUEVO TIPO DE CONTENEDOR ";
        $this->registry->template->ctp_id = "";
        $this->registry->template->ctp_codigo = "";
        $this->registry->template->ctp_nivel = "<option value='1'>CONTENEDOR</option><option value='2'>SUBCONTENEDOR</option>";
        $this->registry->template->ctp_descripcion = "";
        $this->registry->template->readonly = '';

        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_tipocontenedor.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $tipocontenedor = new tab_tipocontenedor ();
        $tipocontenedor->setRequest2Object($_REQUEST);
        $tipocontenedor->setCtp_codigo($_REQUEST['ctp_codigo']);
        $tipocontenedor->setCtp_descripcion($_REQUEST['ctp_descripcion']);
        $tipocontenedor->setCtp_nivel($_REQUEST['ctp_nivel']);
//        $tipocontenedor->setCtp_usu_crea($_SESSION['USU_ID']);
//        $tipocontenedor->setCtp_fecha_crea(date("Y-m-d"));
        $tipocontenedor->setCtp_estado(1);
        $tipocontenedor->insert();
        Header("Location: " . PATH_DOMAIN . "/tipocontenedor/");
    }

    function update() {
        $tipocontenedor = new tab_tipocontenedor ();
        $tipocontenedor->setRequest2Object($_REQUEST);
        $tipocontenedor->setCtp_id($_REQUEST['ctp_id']);
        $tipocontenedor->setCtp_codigo($_REQUEST['ctp_codigo']);
        $tipocontenedor->setCtp_descripcion($_REQUEST['ctp_descripcion']);
        $tipocontenedor->setCtp_nivel($_REQUEST['ctp_nivel']);
//        $tipocontenedor->setCtp_usu_mod($_SESSION['USU_ID']);
//        $tipocontenedor->setCtp_fecha_mod(date("Y-m-d"));
        $tipocontenedor->setCtp_estado(1);
        $tipocontenedor->update();
        
        Header("Location: " . PATH_DOMAIN . "/tipocontenedor/");
    }

    function delete() {
        $ttipocontenedor = new tab_tipocontenedor ();
        $ttipocontenedor->setRequest2Object($_REQUEST);
        $ctp_id = $_REQUEST['ctp_id'];
        $ttipocontenedor->setCtp_id($_REQUEST['ctp_id']);
//        $ttipocontenedor->setCtp_usu_mod($_SESSION['USU_ID']);
//        $ttipocontenedor->setCtp_fecha_mod(date("Y-m-d"));
        $ttipocontenedor->setCtp_estado(2);
        $ttipocontenedor->update();
        echo 'OK';
    }

    
    
    function verifCodigo() {
        $tipocontenedor = new tipocontenedor();
        $tipocontenedor->setRequest2Object($_REQUEST);
        $ctp_id = $_REQUEST['ctp_id'];
        $codigo = strtolower(trim($_REQUEST['codigo']));
        if ($tipocontenedor->existeCodigo($codigo, $ctp_id)) {
            echo 'Codigo ya existe, escriba otro.';
        }
        echo '';
    }

}

?>
