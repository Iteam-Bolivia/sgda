<?php

/**
 * localidadController
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class localidadController Extends baseController {

    function index() {

        //verifica si es superadministrador para mostrar add y delete
        $admin = new usuario();
        $esAdmin = $admin->esAdm();
        $this->registry->template->esAdmin = $esAdmin;
        //////

        $this->provincia = new tab_provincia();
        $resul = $this->provincia->dbselectBySQL("SELECT * FROM tab_provincia WHERE pro_id = " . VAR3);
        if (count($resul)) {
            $codigo = $resul[0]->pro_nombre;
            $dep_id = $resul[0]->dep_id;
        }
        else
            $codigo = "";


        $this->registry->template->loc_id = "";
        $this->registry->template->dep_id = $dep_id;
        $this->registry->template->pro_nombre = $codigo;
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
        $this->registry->template->show('tab_localidadg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $localidad = new localidad();
        $this->localidad = new tab_localidad();
        $this->localidad->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'loc_id';
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
            if ($qtype == 'loc_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT loc_id,loc_nombre,loc_codigo
                 FROM tab_localidad
                 WHERE pro_id = " . VAR3 . " AND loc_estado =  1 $where $sort $limit";

//        printf($sql);
//        die();
        $result = $this->localidad->dbselectBySQL($sql);
        $total = $localidad->count($where, VAR3);
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
            $json .= "id:'" . $un->loc_id . "',";
            $json .= "cell:['" . $un->loc_id . "'";
            $json .= ",'" . addslashes($un->loc_codigo) . "'";
            $json .= ",'" . addslashes($un->loc_nombre) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    function add() {

        $this->provincia = new tab_provincia();
        $resul = $this->provincia->dbselectBySQL("SELECT * FROM tab_provincia WHERE pro_id = " . VAR3);
        if (count($resul))
            $codigo2 = $resul[0]->pro_nombre;
        else
            $codigo2 = "";

        $this->registry->template->titulo = "Nueva Localidad";

        $this->registry->template->loc_id = "";
        $this->registry->template->nom_pro2 = $codigo2;
        $this->registry->template->pro_id = VAR3;
        $this->registry->template->loc_nombre = "";
        $this->registry->template->loc_codigo = "";

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
        $this->registry->template->show('tab_localidad.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->localidad = new tab_localidad();
        $this->localidad->setRequest2Object($_REQUEST);

        $this->localidad->setpro_id($_REQUEST['pro_id']);
        $this->localidad->setloc_id($_REQUEST['loc_id']);
        $this->localidad->setloc_nombre($_REQUEST['loc_nombre']);
        $this->localidad->setloc_codigo($_REQUEST['loc_codigo']);
        $this->localidad->setloc_estado(1);

        $loc_id = $this->localidad->insert();

        Header("Location: " . PATH_DOMAIN . "/localidad/index/" . $_REQUEST['pro_id'] . "/");
    }    
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/localidad/view/" . $_REQUEST["loc_id"] . "/");
    }

    function view() {

        if(! VAR3){ die("Error del sistema 404"); }
        $this->localidad = new tab_localidad();
        $this->localidad->setRequest2Object($_REQUEST);
        $row = $this->localidad->dbselectByField("loc_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "Editar Localidad";
        $this->registry->template->loc_id = $row->loc_id;

        $this->provincia = new tab_provincia();
        $row_padre = $this->provincia->dbselectByField("pro_id", $row->pro_id);
        $padre = $row_padre[0]->pro_nombre;

        $this->registry->template->nom_pro2 = $padre;
        $this->registry->template->pro_id = $row->pro_id;
        $this->registry->template->loc_nombre = $row->loc_nombre;
        $this->registry->template->loc_codigo = $row->loc_codigo;

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
        $this->registry->template->show('tab_localidad.tpl');
        $this->registry->template->show('footer');
    }




    function update() {
        $this->localidad = new tab_localidad();
        $this->localidad->setRequest2Object($_REQUEST);

        $rows = $this->localidad->dbselectByField("loc_id", $_REQUEST['loc_id']);
        $this->localidad = $rows[0];
        $id = $this->localidad->loc_id;

        $this->localidad->setloc_id($_REQUEST['loc_id']);
        $this->localidad->setpro_id($_REQUEST['pro_id']);
        $this->localidad->setloc_nombre($_REQUEST['loc_nombre']);
        $this->localidad->setloc_codigo($_REQUEST['loc_codigo']);
        $this->localidad->setloc_estado(1);

        $this->localidad->update();

        /* $PATH_DOMAIN ?>/provincia/index/"+id+"/" */
        Header("Location: " . PATH_DOMAIN . "/localidad/index/" . $_REQUEST['pro_id'] . "/");
    }

    function validaDepen() {
        $localidad = new localidad();
        $swDepen = $localidad->validaDependenciaLoc($_REQUEST['loc_id']);
        if ($swDepen != 0) {
            echo 'No se puede borrar la localidad tiene ubicaciones .';
        }
        echo '';
    }

    function delete() {
        $this->localidad = new tab_localidad();
        $this->localidad->setloc_id($_REQUEST['loc_id']);
        $this->localidad->setloc_estado(2);
        $this->localidad->update();
    }

    function listLocalidadJson() {
        $this->loc = new localidad();
        echo $this->loc->listLocalidadJson();
    }

    function verifyFields() {
        $localidad = new localidad();
        $loc_codigo = trim($_POST['loc_codigo']);
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
            if ($localidad->existeCodigo($loc_codigo)) {
                echo 'El código ya existe, escriba otro.';
            }
            if (strlen($loc_codigo) < 2 || strlen($loc_codigo) > 2) {
                echo 'El tamaño debe de ser igual a 2.';
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    }
    
    function verifCodigo() {
        $localidad = new localidad();
        $localidad->setRequest2Object($_REQUEST);
        $loc_id = $_REQUEST['Loc_id'];
        $loc_codigo = strtolower(trim($_REQUEST['Loc_codigo']));
        if ($localidad->existeCodigo($loc_codigo, $loc_id)) {
            echo 'El código ya existe, escriba otro.';
        }
        echo '';
    }
}

?>
