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
class proyectoController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->pry_id = "";
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
        $this->registry->template->show('tab_proyectog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $proyecto = new proyecto();
        $unidad = new unidad();
        $this->proyecto = new tab_proyecto();
        $this->proyecto->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'pry_id';
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
            if ($qtype == 'pry_id')
                $where = " and pry_id = '$query' ";
            else
                $where = " AND $qtype LIKE '$query%' ";
        }
        $sql = "SELECT *
                 FROM tab_proyecto AS u
                 WHERE u.pry_estado =  1 $where $sort $limit";

        $result = $this->proyecto->dbselectBySQL($sql);
        $total = $proyecto->count($where);
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
            $json .= "id:'" . $un->pry_id . "',";
            $json .= "cell:['" . $un->pry_id . "'";
            $json .= ",'" . addslashes($un->pry_codigo) . "'";
            $json .= ",'" . addslashes($un->pry_nombre) . "'";
            $json .= ",'" . addslashes($un->pry_grod) . "'";
            $json .= ",'" . addslashes($un->pry_imp) . "'";
            $json .= ",'" . addslashes($un->pry_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/proyecto/view/" . $_REQUEST["pry_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->proyecto = new tab_proyecto();
        $departamento = new departamento();
        $tipoproy = new tipoproy();
        $tipoctt = new tipoctt();
        
        $this->proyecto->setRequest2Object($_REQUEST);
        $row = $this->proyecto->dbselectByField("pry_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar proyecto";
        $this->registry->template->pry_id = $row->pry_id;
        $this->registry->template->mod_login = " disabled=\"disabled\"";
        $this->registry->template->pry_codigo = $row->pry_codigo;
        $this->registry->template->pry_nombre = $row->pry_nombre;
        $this->registry->template->pry_grod = $row->pry_grod;
        $this->registry->template->pry_imp = $row->pry_imp;
        $this->registry->template->pry_estado = $row->pry_estado;
        
        $this->registry->template->dep_id = $departamento->obtenerSelect($row->dep_id);
        $this->registry->template->pry_fecini = $row->pry_fecini;
        $this->registry->template->pry_nroctt = $row->pry_nroctt;
        $this->registry->template->pry_licitacion = $row->pry_licitacion;
        $this->registry->template->pry_empctt = $row->pry_empctt;
        $this->registry->template->pry_empctt = $row->pry_empctt;
        $this->registry->template->pry_supervisor = $row->pry_supervisor;
        $this->registry->template->pry_finan = $row->pry_finan;
        $this->registry->template->tpy_id = $tipoproy->obtenerSelect($row->tpy_id);
        $this->registry->template->tct_id = $tipoctt->obtenerSelect($row->tct_id);
        $this->registry->template->pry_fecactprov = $row->pry_fecactprov;
        $this->registry->template->pry_fecactfin = $row->pry_fecactfin;
        $this->registry->template->pry_estproy = $row->pry_estproy;
    
    
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
        $this->registry->template->show('tab_proyecto.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $unidad = new unidad();
        $rol = new rol();
        $departamento = new departamento();
        $tipoproy = new tipoproy();
        $tipoctt = new tipoctt();
        
        
        $this->registry->template->titulo = "Nuevo proyecto";

        $this->registry->template->pry_id = "";
        $this->registry->template->pry_codigo = "";
        $this->registry->template->pry_nombre = "";
        $this->registry->template->pry_grod = "";
        $this->registry->template->pry_imp = "";
        $this->registry->template->pry_estado = "";
        
        $this->registry->template->dep_id = $departamento->obtenerSelect();
        $this->registry->template->pry_fecini = "";
        $this->registry->template->pry_nroctt = "";
        $this->registry->template->pry_licitacion = "";
        $this->registry->template->pry_empctt = "";
        $this->registry->template->pry_supervisor = "";
        $this->registry->template->pry_finan = "";
        $this->registry->template->tpy_id = $tipoproy->obtenerSelect();
        $this->registry->template->tct_id = $tipoctt->obtenerSelect();
        $this->registry->template->pry_fecactprov = "";
        $this->registry->template->pry_fecactfin = "";
        $this->registry->template->pry_estproy = "";
        
        
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
        $this->registry->template->show('tab_proyecto.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->proyecto = new tab_proyecto();
        $userLogin = new proyecto();
        $this->proyecto->setRequest2Object($_REQUEST);
        $this->proyecto->setPry_id($_REQUEST['pry_id']);
        $this->proyecto->setPry_codigo($_REQUEST['pry_codigo']);
        $this->proyecto->setPry_nombre($_REQUEST['pry_nombre']);
        $this->proyecto->setPry_grod($_REQUEST['pry_grod']);
        $this->proyecto->setPry_imp($_REQUEST['pry_imp']);
        $this->proyecto->setPry_estado(1);
        
        $this->proyecto->setDep_id($_REQUEST['dep_id']);
        $this->proyecto->setPry_fecini($_REQUEST['pry_fecini']);
        $this->proyecto->setPry_nroctt($_REQUEST['pry_nroctt']);
        $this->proyecto->setPry_licitacion($_REQUEST['pry_licitacion']);
        $this->proyecto->setPry_empctt($_REQUEST['pry_empctt']);
        $this->proyecto->setPry_supervisor($_REQUEST['pry_supervisor']);
        $this->proyecto->setPry_finan($_REQUEST['pry_finan']);
        $this->proyecto->setTpy_id($_REQUEST['tpy_id']);
        $this->proyecto->setTct_id($_REQUEST['tct_id']);
        $this->proyecto->setPry_fecactprov($_REQUEST['pry_fecactprov']);
        $this->proyecto->setPry_fecactfin($_REQUEST['pry_fecactfin']);
        if($_REQUEST['pry_estproy']=='Vigente'){
            $this->proyecto->setPry_estproy(1);
        }elseif($_REQUEST['pry_estproy']=='Concluido'){
            $this->proyecto->setPry_estproy(1);
        }elseif($_REQUEST['pry_estproy']=='Cerrado'){
            $this->proyecto->setPry_estproy(2);
        }
        
    
        
        $this->proyecto->setPry_imp($_REQUEST['pry_imp']);
        
        $pry_id = $this->proyecto->insert();
        Header("Location: " . PATH_DOMAIN . "/proyecto/");
    }

    function update() {
        $this->proyecto = new tab_proyecto();
        $this->proyecto->setRequest2Object($_REQUEST);
//        $rol = new rol();
//        $this->registry->template->roles = $rol->obtenerSelectRoles();
        $rows = $this->proyecto->dbselectByField("pry_id", $_REQUEST['pry_id']);
        $this->proyecto = $rows[0];
        $id = $this->proyecto->pry_id;
        $this->proyecto->setPry_id($_REQUEST['pry_id']);
        $this->proyecto->setPry_codigo($_REQUEST['pry_codigo']);
        $this->proyecto->setPry_nombre($_REQUEST['pry_nombre']);
        $this->proyecto->setPry_grod($_REQUEST['pry_grod']);
        $this->proyecto->setPry_imp($_REQUEST['pry_imp']);
        $this->proyecto->setPry_estado(1);
        
        $this->proyecto->setDep_id($_REQUEST['dep_id']);
        $this->proyecto->setPry_fecini($_REQUEST['pry_fecini']);
        $this->proyecto->setPry_nroctt($_REQUEST['pry_nroctt']);
        $this->proyecto->setPry_licitacion($_REQUEST['pry_licitacion']);
        $this->proyecto->setPry_empctt($_REQUEST['pry_empctt']);
        $this->proyecto->setPry_supervisor($_REQUEST['pry_supervisor']);
        $this->proyecto->setPry_finan($_REQUEST['pry_finan']);
        $this->proyecto->setTpy_id($_REQUEST['tpy_id']);
        $this->proyecto->setTct_id($_REQUEST['tct_id']);
        $this->proyecto->setPry_fecactprov($_REQUEST['pry_fecactprov']);
        $this->proyecto->setPry_fecactfin($_REQUEST['pry_fecactfin']);
        $this->proyecto->setPry_estproy($_REQUEST['pry_estproy']);
        
        $this->proyecto->update();
        Header("Location: " . PATH_DOMAIN . "/proyecto/");
    }

    function delete() {
        $this->proyecto = new tab_proyecto();
        $this->proyecto->setPry_id($_REQUEST['pry_id']);
        $this->proyecto->setPry_estado(2);
        $this->proyecto->update();
    }

    function verifyFields() {
        $unidad = new unidad ();
        $rol_id = $_POST["Rol_id"];
        $uni_id = $_POST["Uni_id"];
        //el ingreso es normal
        $sql = "SELECT *
                FROM tab_unidad
                WHERE uni_id='" . $id . "'";
        $row = $unidad->dbselectBySQL($ql);
        if (count($row)) {
            return $row[0];
        } else {
            return $this->aux;
        }
    }
    function verifCodigo() {
        $proyecto = new proyecto();
        $proyecto->setRequest2Object($_REQUEST);
        $pry_codigo = trim($_REQUEST['pry_codigo']);
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
            if ($proyecto->existeCodigo($pry_codigo)) {
                echo 'El código ya existe, escriba otro.';
            }
            if (strlen($pry_codigo) == 0) {
                echo 'Debe de ingreasr un codigo.';
            }
            //if (strlen($uni_codigo) < 2 || strlen($uni_codigo) > 2) {
            //    echo 'El tamaño debe de ser igual a 2.';
            //} 
            else {
                echo "";
            }
        } else {
            echo "";
        }
    }
}

?>
