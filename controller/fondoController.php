<?php

/**
 * fondoController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class fondoController extends baseController {

    function index() {
        $this->registry->template->fon_id = "";
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
        $this->registry->template->show('tab_fondog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $fondo = new fondo();
        $this->fondo = new tab_fondo();
        $this->fondo->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'fon_id';
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
            if ($qtype == 'fon_id')
                $where = " and fon_id = '$query' ";
            else
                $where = " AND $qtype LIKE '$query%' ";
        }
        $sql = "SELECT
                 fon_id,
                 fon_par,
                 (SELECT fon_descripcion from tab_fondo WHERE fon_id=f.fon_par) as fon_par_des,                 
                 fon_codigo,
                 fon_cod,                 
                 fon_descripcion,
                 fon_contador,
                 fon_estado                
                 FROM tab_fondo AS f
                 WHERE f.fon_estado =  1 $where $sort $limit";

        $result = $this->fondo->dbselectBySQL($sql);
        $total = $fondo->count($where);
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
            $json .= "id:'" . $un->fon_id . "',";
            $json .= "cell:['" . $un->fon_id . "'";
            $json .= ",'" . addslashes($un->fon_cod) . "'"; 
            //$json .= ",'" . addslashes($un->fon_codigo) . "'";             
            if ($un->fon_par=='-1'){
                $json .= ",'" . addslashes(utf8_encode($un->fon_descripcion)) . "'";
            }else{
                $json .= ",'" . addslashes("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . utf8_encode($un->fon_descripcion)) . "'";
                //$json .= ",'" . addslashes("----- " . utf8_encode($un->fon_descripcion)) . "'";
            }
            $json .= ",'" . addslashes($un->fon_par_des) . "'";
            $json .= ",'" . addslashes($un->fon_contador) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }


    function add() {
        $fondo = new fondo ();
        $this->registry->template->titulo = "Nuevo fondo";
        $this->registry->template->fon_id = "";        
        $this->registry->template->fon_codigo = "";        
        $this->registry->template->fon_cod = "";        
        $this->registry->template->fon_descripcion = "";
        $this->registry->template->fon_contador = "0";
        $this->registry->template->fon_par = $fondo->obtenerSelectFondos();

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
        $this->registry->template->show('tab_fondo.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $fondo = new fondo();
        $this->fondo = new tab_fondo();
        $this->fondo->setRequest2Object($_REQUEST);
        $this->fondo->setFon_id($_REQUEST['fon_id']);
        $this->fondo->setFon_codigo($_REQUEST['fon_codigo']);
        $this->fondo->setFon_descripcion($_REQUEST['fon_descripcion']);
        $this->fondo->setFon_estado(1);
        if ($_REQUEST['fon_par']){
            // Search Code
            $this->fondo->setFon_par($_REQUEST['fon_par']);
            $this->fondo->setFon_cod($fondo->getCodigo($_REQUEST['fon_par']) . DELIMITER .$_REQUEST['fon_codigo']);
            //$this->fondo->setFon_cod($fondo->obtenerCodigoFondo($_REQUEST['fon_par']));            
            $this->fondo->setFon_contador($_REQUEST['fon_contador']);
            $fon_id = $this->fondo->insert2();
            
            // Update Fondo Contador
            $row2 = $this->fondo->dbselectByField("fon_id", $_REQUEST['fon_par']);
            $row2 = $row2[0];            
            $this->fondo->setFon_id($row2->fon_id);
            $this->fondo->setFon_par($row2->fon_par);
            $this->fondo->setFon_codigo($row2->fon_codigo);
            $this->fondo->setFon_cod($row2->fon_cod);            
            $this->fondo->setFon_descripcion($row2->fon_descripcion);
            $this->fondo->setFon_estado($row2->fon_estado);
            $fon_contador = $row2->fon_contador+1;
            $this->fondo->setFon_contador($fon_contador);                        
            $this->fondo->update();         
        }else{
            // Generate code
            $this->fondo->setFon_cod($_REQUEST['fon_codigo']);
            $this->fondo->setFon_par(-1);
            $this->fondo->setFon_contador($_REQUEST['fon_contador']);
            $fon_id = $this->fondo->insert2();            
        }

        
        
        Header("Location: " . PATH_DOMAIN . "/fondo/");
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/fondo/view/" . $_REQUEST["fon_id"] . "/");
    }

    function view() {
        $fondo = new fondo();
       if(! VAR3){ die("Error del sistema 404"); }
        $this->fondo = new tab_fondo();
        $this->fondo->setRequest2Object($_REQUEST);
        $row = $this->fondo->dbselectByField("fon_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar fondo";
        $this->registry->template->fon_id = $row->fon_id;
        $this->registry->template->fon_codigo = $row->fon_codigo;
        $this->registry->template->fon_cod = $row->fon_cod;        
        $this->registry->template->fon_par = $fondo->obtenerSelectFondos($row->fon_par);
        $this->registry->template->fon_descripcion = utf8_encode($row->fon_descripcion);
        $this->registry->template->fon_contador = $row->fon_contador;
        $this->registry->template->fon_estado = $row->fon_estado;

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
        $this->registry->template->show('tab_fondo.tpl');
        $this->registry->template->show('footer');
    }
    
    function update() {
        $fondo = new fondo ();
        $this->fondo = new tab_fondo();
        $this->fondo->setRequest2Object($_REQUEST);
        $rows = $this->fondo->dbselectByField("fon_id", $_REQUEST['fon_id']);
        $this->fondo = $rows[0];
        $id = $this->fondo->fon_id;
        
        $this->fondo->setFon_id($_REQUEST['fon_id']);
        $this->fondo->setFon_codigo($_REQUEST['fon_codigo']);
        if ($_REQUEST['fon_par']){
            $this->fondo->setFon_par($_REQUEST['fon_par']);
            $this->fondo->setFon_cod($fondo->getCodigo($_REQUEST['fon_par']) . DELIMITER .$_REQUEST['fon_codigo']);
        }else{
            $this->fondo->setFon_par(-1);
            $this->fondo->setFon_cod($_REQUEST['fon_codigo']);
        }
        
        $this->fondo->setFon_descripcion($_REQUEST['fon_descripcion']);
        $this->fondo->setFon_contador($_REQUEST['fon_contador']);
        $this->fondo->setFon_estado(1);
        $this->fondo->update();

        Header("Location: " . PATH_DOMAIN . "/fondo/");
    }

    function delete() {
        $this->fondo = new tab_fondo();
        $this->fondo->setFon_id($_REQUEST['fon_id']);
        $this->fondo->setFon_estado(2);
        $this->fondo->update();
    }

    // Other    
    function validaDepen() {
        $fondo = new fondo();
        $swDepen = $fondo->validaDependencia($_REQUEST['fon_id']);
        if ($swDepen != 0) {
            echo 'No se puede eliminar el fondo ! \nTiene subfondos, secciones, series o expedientes';
        }else{
            echo '';
        }
    }     
    
    
    
    
    
    
    
    
    
    function loadAjax() {
        $res = array();
        $fon_id = $_POST["fon_id"];
        $unidad = new tab_unidad();
        $unidad = $unidad->dbselectById($fon_id);
        if ($unidad->uni_codigo != '0') {
            $add = "";
            if (isset($_POST["uni_id"]))
                $sql = "SELECT 
                        uni_id,
                        uni_descripcion
                        FROM
                        tab_unidad
                        WHERE
                        (uni_estado = '1' || fon_id = '$fon_id')
                        ORDER BY uni_descripcion ASC ";
            $unidad = new tab_unidad();
            $result = $unidad->dbSelectBySQL($sql);
            foreach ($result as $row) {
                $res[$row->uni_id] = $row->uni_descripcion;
            }
        }

        echo json_encode($res);
    }
    
    
    function obtenerCodigoFondoAjax() {
        $fondo = new tab_fondo ();
        $res = array();
        $fon_par = $_POST["Fon_par"];
        $sql = "SELECT 
            f.fon_cod,
            f.fon_contador
            FROM
            tab_fondo AS f
            WHERE
            f.fon_estado =  '1' and f.fon_id = '$fon_par'
            ORDER BY f.fon_id ";
        $rows = $fondo->dbSelectBySQL($sql);
        $contador = 0;
        foreach ($rows as $fon) {
            $contador = $fon->fon_contador+1;
            $res['fon_cod'] = $fon->fon_cod . "." . $contador;
        }
        echo json_encode($res);
    }    
    
    
    function getCodigo() {
        $res = array();
        $fon_id = $_POST["Fon_id"];        
        $fondo = new tab_fondo();        
        $res['fon_cod'] = '';
        if ($fon_id != "0") {
            $sql = "SELECT
                    tab_fondo.fon_cod
                    FROM
                    tab_fondo
                    WHERE (tab_fondo.fon_estado = '1' AND tab_fondo.fon_id='$fon_id')";
            $result = $fondo->dbSelectBySQL($sql);
            foreach ($result as $row) {
                $res['fon_cod'] = $row->fon_cod;
            }
        }
        echo json_encode($res);
    }    
    

}

?>
