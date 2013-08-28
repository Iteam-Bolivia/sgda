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
class provinciaController Extends baseController {

    function index() {
        //verifica si es superadministrador para mostrar add y delete
        $admin = new usuario();
        $esAdmin = $admin->esAdm();
        $this->registry->template->esAdmin = $esAdmin;
        //////

        $this->departamento = new tab_departamento();
        $resul = $this->departamento->dbselectBySQL("SELECT * FROM tab_departamento WHERE dep_id = " . VAR3);
        if (count($resul))
            $codigo = $resul[0]->dep_nombre;
        else
            $codigo = "";

        $this->registry->template->pro_id = "";
        $this->registry->template->dep_nombre = $codigo;
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
        $this->registry->template->show('tab_provinciag.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $provincia = new provincia();
        $this->provincia = new tab_provincia();
        $this->provincia->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'pro_id';
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
            if ($qtype == 'pro_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT pro_id,pro_nombre,pro_codigo
                 FROM tab_provincia
                 WHERE dep_id = " . VAR3 . " 
                 AND pro_estado =  1 $where $sort $limit";

        $result = $this->provincia->dbselectBySQL($sql);
        $total = $provincia->count($where, VAR3);
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
            $json .= "id:'" . $un->pro_id . "',";
            $json .= "cell:['" . $un->pro_id . "'";
            $json .= ",'" . addslashes($un->pro_codigo) . "'";
            $json .= ",'" . addslashes($un->pro_nombre) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }    
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/provincia/view/" . $_REQUEST["pro_id"] . "/");
    }

    function view() {

        if(! VAR3){ die("Error del sistema 404"); }
        $this->provincia = new tab_provincia();
        $this->provincia->setRequest2Object($_REQUEST);
        $row = $this->provincia->dbselectByField("pro_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "Editar Provincia";
        $this->registry->template->pro_id = $row->pro_id;

        $this->departamento = new tab_departamento();
        $row_padre = $this->departamento->dbselectByField("dep_id", $row->dep_id);
        $padre = $row_padre[0]->dep_nombre;

        $this->registry->template->nom_dep2 = $padre;
        $this->registry->template->dep_id = $row->dep_id;
        $this->registry->template->pro_nombre = $row->pro_nombre;
        $this->registry->template->pro_codigo = $row->pro_codigo;

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
        $this->registry->template->show('tab_provincia.tpl');
        $this->registry->template->show('footer');
    }


    function add() {

        $this->departamento = new tab_departamento();
        $resul = $this->departamento->dbselectBySQL("SELECT * FROM tab_departamento WHERE dep_id = " . VAR3);
        if (count($resul))
            $codigo2 = $resul[0]->dep_nombre;
        else
            $codigo2 = "";

        $this->registry->template->titulo = "Nueva Provincia";

        $this->registry->template->pro_id = "";
        $this->registry->template->nom_dep2 = $codigo2;
        $this->registry->template->dep_id = VAR3;
        $this->registry->template->pro_nombre = "";
        $this->registry->template->pro_codigo = "";

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
        $this->registry->template->show('tab_provincia.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->provincia = new tab_provincia();
        $this->provincia->setRequest2Object($_REQUEST);

        $this->provincia->setdep_id($_REQUEST['dep_id']);
        $this->provincia->setpro_id($_REQUEST['pro_id']);
        $this->provincia->setpro_nombre($_REQUEST['pro_nombre']);
        $this->provincia->setpro_codigo($_REQUEST['pro_codigo']);
        $this->provincia->setpro_estado(1);

        $pro_id = $this->provincia->insert();

        Header("Location: " . PATH_DOMAIN . "/provincia/index/" . $_REQUEST['dep_id'] . "/");
    }

    function update() {
        $this->provincia = new tab_provincia();
        $this->provincia->setRequest2Object($_REQUEST);

        $rows = $this->provincia->dbselectByField("pro_id", $_REQUEST['pro_id']);
        $this->provincia = $rows[0];
        $id = $this->provincia->pro_id;

        $this->provincia->setpro_id($_REQUEST['pro_id']);
        $this->provincia->setpro_nombre($_REQUEST['pro_nombre']);
        $this->provincia->setpro_codigo($_REQUEST['pro_codigo']);
        $this->provincia->setpro_estado(1);

        $this->provincia->update();

        /* $PATH_DOMAIN ?>/provincia/index/"+id+"/" */
        Header("Location: " . PATH_DOMAIN . "/provincia/index/" . $_REQUEST['dep_id'] . "/");
    }

    function validaDepen() {

        $provincia = new provincia();

        //$this->departamento->setdep_id($_REQUEST['dep_id']);

        $swDepen = $provincia->validaDependenciaPr($_REQUEST['pro_id']);
        if ($swDepen != 0) {
            echo 'No se puede borrar la provincia tiene ubicaciones .';
        }
        echo '';
        // $this->departamento->setdep_estado(0);
        //$this->departamento->update();
    }

    function delete() {

        $this->provincia = new tab_provincia();
        $this->provincia->setpro_id($_REQUEST['pro_id']);
        $this->provincia->setpro_estado(2);
        $this->provincia->update();
    }

    function listProvinciaJson() {
        $this->pro = new provincia();
        echo $this->pro->listProvinciaJson();
    }

    function obtenerLoc() {
        $provincia = new localidad();
        //$area = array();
        $res = $provincia->selectLoc(0, $_REQUEST['Pro_id']);
        echo $res;
    }
    function verifyFields() {
        $provincia = new provincia();
        $pro_codigo = trim($_POST['pro_codigo']);
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
            if ($provincia->existeCodigo($pro_codigo)) {
                echo 'El código ya existe, escriba otro.';
            }
            //if (strlen($uni_codigo) < 2 || strlen($uni_codigo) > 2) {
            //    echo 'El tamaño debe de ser igual a 2.';
            //} 
            else {
                echo '';
            }
        } else {
            echo '';
        }
    }
    function verifCodigo() {
        $provincia = new provincia();
        $provincia->setRequest2Object($_REQUEST);
        $pro_id = $_REQUEST['Pro_id'];
        $pro_codigo = strtolower(trim($_REQUEST['Pro_codigo']));
        if ($provincia->existeCodigo($pro_codigo, $pro_id)) {
            echo 'El código ya existe, escriba otro.';
        }
        echo '';
    }
}

?>
