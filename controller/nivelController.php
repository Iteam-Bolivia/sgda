<?php

/**
 * nivelController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class nivelController extends baseController {

    function index() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        //$this->llenarLinks();
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->niv_id = '';
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_nivelg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $this->nivel = new tab_nivel ();
        $nivel = new nivel ();
        $this->nivel->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'niv_id';
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
            if ($qtype == 'niv_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT n.niv_id,
                (SELECT niv_descripcion from tab_nivel WHERE niv_id=n.niv_par) as niv_par,
                n.niv_descripcion,
                n.niv_abrev
                FROM tab_nivel as n
                WHERE n.niv_estado = 1 $where $sort $limit ";
        $sql_c = "SELECT COUNT(niv_id) FROM tab_nivel WHERE niv_estado = 1 $where ";
        $result = $this->nivel->dbselectBySQL($sql);
        $total = $this->nivel->countBySQL($sql_c);
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
            $json .= "id:'" . $un->niv_id . "',";
            $json .= "cell:['" . $un->niv_id . "'";
            $json .= ",'" . addslashes($un->niv_par) . "'";
            $json .= ",'" . addslashes($un->niv_abrev) . "'";
            $json .= ",'" . addslashes($un->niv_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        header("Location: " . PATH_DOMAIN . "/nivel/view/" . $_REQUEST["niv_id"] . "/");
    }

    function view() {
        //if(! VAR3){ die("Error del sistema 404"); }
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->nivel = new tab_nivel ();
        $row = array();
        if (!is_null(VAR3))
            $row = $this->nivel->dbselectByField("niv_id", VAR3);
        if (!isset($row[0])) {
            header("Location: " . PATH_DOMAIN . "/nivel/");
        }
        $row = $row [0];
        $nivel = new nivel ();
        $this->registry->template->titulo = "Editar Nivel " . $row->getNiv_id();
        $this->registry->template->niv_id = $row->getNiv_id();
        $this->registry->template->readonly = ''; 
        $this->registry->template->niv_par = $nivel->obtenerSelect($row->niv_par);
        $this->registry->template->niv_abrev = $row->getNiv_abrev();
        $this->registry->template->niv_descripcion = $row->getNiv_descripcion();
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_nivel.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $nivel = new nivel ();
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->titulo = "NUEVO NIVEL ";
        $this->registry->template->niv_id = "";
        $this->registry->template->niv_par = $nivel->obtenerSelect();
        $this->registry->template->niv_abrev = '';
        $this->registry->template->readonly = '';
        $this->registry->template->niv_descripcion = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_nivel.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $nivel = new tab_nivel ();
        $nivel->setRequest2Object($_REQUEST);
        $nivel->setNiv_id($_REQUEST['niv_id']);
        $nivel->setNiv_codigo($_REQUEST['niv_abrev']);
        $nivel->setNiv_descripcion($_REQUEST['niv_descripcion']);
        $nivel->setNiv_par($_REQUEST['niv_par']);
        $nivel->setNiv_abrev($_REQUEST['niv_abrev']);        
//        $nivel->setNiv_usu_crea($_SESSION['USU_ID']);
//        $nivel->setNiv_fecha_crea(date("Y-m-d"));
        $nivel->setNiv_estado(1);
        $nivel->insert();
        Header("Location: " . PATH_DOMAIN . "/nivel/");
    }

    function update() {
        $nivel = new tab_nivel ();
        $nivel->setRequest2Object($_REQUEST);
        $nivel->setNiv_id($_REQUEST['niv_id']);        
        $nivel->setNiv_codigo($_REQUEST['niv_abrev']);
        $nivel->setNiv_descripcion($_REQUEST['niv_descripcion']);
        $nivel->setNiv_par($_REQUEST['niv_par']);
        $nivel->setNiv_abrev($_REQUEST['niv_abrev']);        
//        $nivel->setNiv_usu_mod($_SESSION['USU_ID']);
//        $nivel->setNiv_fecha_mod(date("Y-m-d"));
        $nivel->setNiv_estado(1);

        $nivel->update();
        Header("Location: " . PATH_DOMAIN . "/nivel/");
    }

    function delete() {
        $tnivel = new tab_nivel ();
        $tnivel->setRequest2Object($_REQUEST);
        $niv_id = $_REQUEST['niv_id'];
        $sql = "SELECT COUNT(tu.uni_id) FROM tab_unidad tu INNER JOIN tab_nivel tn ON tu.niv_id=tn.niv_id WHERE tu.uni_estado = '1'
			AND tn.niv_id = '$niv_id'";
        $c_uni = $tnivel->countBySQL($sql);
        if ($c_uni == 0) {
            $tnivel->setNiv_usu_mod($_SESSION['USU_ID']);
            $tnivel->setNiv_fecha_mod(date("Y-m-d"));
            $tnivel->setNiv_estado(2);
            $tnivel->update();
            echo 'OK';
        } elseif ($c_uni == 1) {
            echo 'No se puede eliminar el registro porque tiene ' . $c_uni . ' unidad relacionada';
        } else {
            echo 'No se puede eliminar el registro porque tiene ' . $c_uni . ' unidades relacionadas';
        }
    }

    function verifCodigo() {
        $nivel = new nivel();
        $nivel->setRequest2Object($_REQUEST);
        $niv_id = $_REQUEST['niv_id'];
        $codigo = strtolower(trim($_REQUEST['codigo']));
        if ($nivel->existeCodigo($codigo, $niv_id)) {
            echo 'Codigo ya existe, escriba otro.';
        }
        echo '';
    }

    function llenarLinks() {
        $this->registry->template->msg_paso4 = "";
        $this->registry->template->url_paso4 = "#";
        $this->registry->template->url_paso3 = "#";
        if ($_SESSION['PASO'] == 3) {
            $this->registry->template->url_paso4 = PATH_DOMAIN . "/unidadTransferencia/verifTransf/";
            $this->registry->template->msg_paso4 = ' onclick="return confirm(\'Desea Finalizar el proceso?\');"';
        }
        if ($_SESSION['PASO'] == 2) {
            $this->registry->template->url_paso3 = PATH_DOMAIN . "/versionado/nextPaso/";
        } elseif ($_SESSION['PASO'] > 2) {
            $this->registry->template->url_paso3 = PATH_DOMAIN . "/unidadTransferencia/";
        }
        if ($_SESSION['PASO'] == 1) {
            $this->registry->template->url_paso2 = PATH_DOMAIN . "/versionado/nextPaso/";
        } else {
            $this->registry->template->url_paso2 = PATH_DOMAIN . "/unidad/";
        }
    }
    
    
}

?>
