<?php

/**
 * sistemaController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class sistemaController extends baseController {

    function index() {
        $this->registry->template->sis_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_sistemag.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $sistema = new sistema();
        $this->sistema = new tab_sistema ();
        $this->sistema->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'sis_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query) {
            if ($qtype == 'sis_id')
                $where = " WHERE $qtype = '$query' ";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * 
                    FROM tab_sistema 
                    $where AND
                    sis_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT 
                    sis_id,
                    sis_codigo,
                    sis_nombre,
                    (CASE (sis_tipcarga) 
                    WHEN '1' THEN 'BD'
                    WHEN '2' THEN 'SERVIDOR' END) AS sis_tipcarga,
                    sis_tammax,
                    sis_ruta,
                    sis_estado
                    FROM tab_sistema 
                    WHERE sis_estado = 1 $sort $limit ";
        }
        $result = $this->sistema->dbselectBySQL($sql);
        $total = $sistema->count($query);
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
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
            $json .= "id:'" . $un->sis_id . "',";
            $json .= "cell:['" . $un->sis_id . "'";
            $json .= ",'" . addslashes($un->sis_codigo) . "'";
            $json .= ",'" . addslashes($un->sis_nombre) . "'";
            $json .= ",'" . addslashes($un->sis_tipcarga) . "'";            
            $json .= ",'" . addslashes($un->sis_tammax) . "'";
            $json .= ",'" . addslashes($un->sis_ruta) . "'";
            $json .= ",'" . addslashes($un->sis_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    function add() {
        $this->fondo = new fondo ();
        $this->registry->template->titulo = "DATOS DEL SISTEMA";
        $this->registry->template->sis_id = "";
        $this->registry->template->sis_codigo = "";
        $this->registry->template->sis_nombre = "";
        $this->registry->template->sis_tipcarga = "";
        $this->registry->template->sis_tammax = "";
        $this->registry->template->sis_ruta = "";
        $this->registry->template->fon_id = $this->fondo->obtenerSelectFondos();

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_sistema.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        
        $this->sistema = new tab_sistema ();
        $this->fondo = new tab_fondo ();
        $this->menu = new Tab_menu ();
        $this->usurolmenu = new Tab_usurolmenu ();

        $this->sistema->setRequest2Object($_REQUEST);
        $this->sistema->setSis_codigo($_REQUEST ['sis_codigo']);
        $this->sistema->setSis_nombre($_REQUEST ['sis_nombre']);
        $this->sistema->setSis_tipcarga($_REQUEST ['sis_tipcarga']);
        $this->sistema->setSis_tammax($_REQUEST ['sis_tammax']);
        $this->sistema->setSis_ruta($_REQUEST ['sis_ruta']);
        $this->sistema->setRol_estado(1);
        $idRol = $this->sistema->insert();

        //$this->usurolmenu->insert();
        Header("Location: " . PATH_DOMAIN . "/sistema/");
    }

    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/sistema/view/" . $_REQUEST ["sis_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $sistema = new sistema();
        $this->sistema = new tab_sistema ();
        $this->sistema->setRequest2Object($_REQUEST);
        $row = $this->sistema->dbselectByField("sis_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row [0];
        $this->registry->template->titulo = "EDITAR DATOS DEL SISTEMA";
        $this->registry->template->sis_id = $row->sis_id;
        $this->registry->template->sis_codigo = $row->sis_codigo;
        $this->registry->template->sis_nombre = $row->sis_nombre;
        $this->registry->template->sis_tipcarga = $sistema->obtenerSelect($row->sis_tipcarga);
        $this->registry->template->sis_tammax = $row->sis_tammax;
        $this->registry->template->sis_ruta = $row->sis_ruta;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery";

        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_sistema.tpl');
        $this->registry->template->show('footer');
    }


    function update() {
        $this->sistema = new tab_sistema ();
        $this->sistema->setRequest2Object($_REQUEST);
        $this->sistema->setSis_id($_REQUEST ['sis_id']);
        $this->sistema->setSis_codigo($_REQUEST ['sis_codigo']);
        $this->sistema->setSis_nombre($_REQUEST ['sis_nombre']);
        $this->sistema->setSis_tipcarga($_REQUEST ['sis_tipcarga']);
        $this->sistema->setSis_tammax($_REQUEST ['sis_tammax']);
        $this->sistema->setSis_ruta($_REQUEST ['sis_ruta']);
        $this->sistema->setSis_estado(1);
        $this->sistema->update();

        Header("Location: " . PATH_DOMAIN . "/sistema/");
    }

    function delete() {
        $this->sistema = new tab_sistema ();
        $this->sistema->setRequest2Object($_REQUEST);
        $this->sistema->setSis_id($_REQUEST ['sis_id']);
        $this->sistema->setSis_estado(2);
        $this->sistema->update();
    }

}
?>
