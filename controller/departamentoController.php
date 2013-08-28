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
class departamentoController Extends baseController {

    function index() {
        $admin = new usuario();
        $esAdmin = $admin->esAdm();
        $this->registry->template->esAdmin = $esAdmin;
        $this->registry->template->dep_id = "";
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
        $this->registry->template->show('tab_departamentog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $departamento = new departamento();
        $this->departamento = new tab_departamento();
        $this->departamento->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'dep_id';
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
            if ($qtype == 'dep_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT 
                 dep_id, 
                 dep_nombre, 
                 dep_codigo
                 FROM tab_departamento
                 WHERE dep_estado = 1 $where $sort $limit";

        $result = $this->departamento->dbselectBySQL($sql);
        $total = $departamento->count($where);
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
            $json .= "id:'" . $un->dep_id . "',";
            $json .= "cell:['" . $un->dep_id . "'";
            $json .= ",'" . addslashes($un->dep_codigo) . "'";
            $json .= ",'" . addslashes($un->dep_nombre) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->dep_id = "";
        $this->registry->template->dep_nombre = "";
        $this->registry->template->dep_codigo = "";

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->titulo = "NUEVO DEPARTAMENTO";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_departamento.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->departamento = new tab_departamento();
        $this->departamento->setRequest2Object($_REQUEST);
        $this->departamento->setdep_id($_REQUEST['dep_id']);
        $this->departamento->setdep_codigo($_REQUEST['dep_codigo']);
        $this->departamento->setdep_nombre($_REQUEST['dep_nombre']);
        $this->departamento->setdep_estado(1);
        $dep_id = $this->departamento->insert();

        Header("Location: " . PATH_DOMAIN . "/departamento/");
    }
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/departamento/view/" . $_REQUEST["dep_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->departamento = new tab_departamento();
        $this->departamento->setRequest2Object($_REQUEST);
        $row = $this->departamento->dbselectByField("dep_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "EDITAR DEPARTAMENTO";
        $this->registry->template->dep_id = $row->dep_id;
        $this->registry->template->dep_nombre = $row->dep_nombre;
        $this->registry->template->dep_codigo = $row->dep_codigo;

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
        $this->registry->template->show('tab_departamento.tpl');
        $this->registry->template->show('footer');
    }



    function update() {
        $this->departamento = new tab_departamento();
        $this->departamento->setRequest2Object($_REQUEST);
        $rows = $this->departamento->dbselectByField("dep_id", $_REQUEST['dep_id']);
        $this->departamento = $rows[0];
        $id = $this->departamento->dep_id;
        $this->departamento->setdep_id($_REQUEST['dep_id']);
        $this->departamento->setdep_codigo($_REQUEST['dep_codigo']);
        $this->departamento->setdep_nombre($_REQUEST['dep_nombre']);
        $this->departamento->setdep_estado(1);
        $this->departamento->update();

        Header("Location: " . PATH_DOMAIN . "/departamento/");
    }

    function delete() {
        $this->departamento = new tab_departamento();
        $this->departamento->setdep_id($_REQUEST['dep_id']);
        $this->departamento->setdep_estado(2);
        $this->departamento->update();
    }

    function validaDepen() {
        $departamento = new departamento();
        $swDepen = $departamento->validaDependencia($_REQUEST['dep_id']);
        if ($swDepen != 0) {
            echo 'No se puede borrar el departamento tiene provincias .';
        }
        echo '';
    }    
    
    function listDepartamentoJson() {
        $this->dep = new departamento();
        echo $this->dep->listDepartamentoJson();
    }

    function obtenerPro() {
        $provincia = new provincia();
        $res = $provincia->selectPro(0, $_REQUEST['Dep_id']);
        echo $res;
    }
    function verifyFields() {
        $departamento = new departamento();
        $dep_codigo = trim($_POST['dep_codigo']);
        if ($departamento->existeCodigo($dep_codigo)) {
            echo 'El código ya existe, escriba otro.';
        }
        //if (strlen($uni_codigo) < 2 || strlen($uni_codigo) > 2) {
        //    echo 'El tamaño debe de ser igual a 2.';
        //} 
        else {
            echo '';
        }
    }
    function verifLogin() {
        $departamento = new departamento();
        $departamento->setRequest2Object($_REQUEST);
        $dep_codigo = $_REQUEST['dep_codigo'];
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
            if ($departamento->existeCodigo($dep_codigo)) {
                echo 'El código ya existe, escriba otro.';
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    }
    
//    function verifCodigo() {
//        $departamento = new departamento();
//        $departamento->setRequest2Object($_REQUEST);
//        $departamento->setRequest2Object($_REQUEST);
//        $dep_codigo = $_REQUEST['dep_codigo'];
//        $Path_event = trim($_POST['Path_event']);
//        if ($Path_event != 'update') {
//            if ($departamento->existeCodigo($dep_codigo)) {
//                echo 'El código ya existe, escriba otro.';
//            } else {
//                echo '';
//            }
//        } else {
//            echo '';
//        }
//    }
    
    function verifCodigo() {
        $departamento = new departamento();
        $departamento->setRequest2Object($_REQUEST);
        $dep_id = $_REQUEST['Dep_id'];
        $dep_codigo = strtolower(trim($_REQUEST['Dep_codigo']));
        if ($departamento->existeCodigo($dep_codigo, $dep_id)) {
            echo 'El código ya existe, escriba otro.';
        }
        echo '';
    }

    
    
    function getCodigo() { 
        $res = array();
        $dep_id = $_POST["Dep_id"];
        $uni_id = $_POST["Uni_id"];
        $departamento = new tab_departamento();
        $sql = "SELECT
                dep_id,
                dep_codigo
                FROM
                tab_departamento
                WHERE (dep_estado = '1' AND dep_id='$dep_id')";
        $result = $departamento->dbSelectBySQL($sql);
        foreach ($result as $row) {
            $res['dep_codigo'] = $row->dep_codigo;
        }
        $res['uni_codigo'] = '';
        if($uni_id!="0"){
         $sql = "SELECT
                uni_id,
                uni_codigo
                FROM
                tab_unidad
                WHERE (uni_estado = '1' AND uni_id='$uni_id')";
        $result = $departamento->dbSelectBySQL($sql);
        foreach ($result as $row) {
            $res['uni_codigo'] = $row->uni_codigo;
        }
        }
        
        if($uni_id != "0" && $dep_id != "0" ){
            $sql="select max(split_part(ser_codigo, '.', 3)) as contador from tab_series where uni_id='$uni_id' and dep_id= '$dep_id' and ser_estado=1";
            $result = $departamento->dbSelectBySQL($sql);
            foreach ($result as $row) {
                $res['uni_contador'] = sprintf("%02d", $row->contador+1);
            }
        }
        echo json_encode($res);
    }    
}

?>
