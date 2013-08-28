<?php

/**
 * ubicacionController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class ubicacionController extends baseController {

    function index() {
        $this->registry->template->ubi_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_ubicaciong.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $this->ubi = new ubicacion ();
        $this->ubicacion = new tab_ubicacion ();
        $this->ubicacion->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ubi_id';
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
            if ($qtype == 'ubi_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

//        $sql = "SELECT ubi.*,
//                loc.loc_nombre
//                FROM tab_ubicacion as ubi
//                INNER JOIN tab_localidad as loc ON ubi.loc_id = loc.loc_id
//                WHERE ubi_par='0' 
//                AND ubi_estado = 1 
//                $where $sort $limit ";

        $sql = "SELECT
                tab_departamento.dep_nombre,
                tab_provincia.pro_nombre,
                loc.loc_nombre,
                ubi.ubi_id,
                ubi.ubi_codigo,
                ubi.ubi_descripcion,
                ubi.ubi_direccion
                FROM
                tab_ubicacion AS ubi
                INNER JOIN tab_localidad AS loc ON ubi.loc_id = loc.loc_id
                INNER JOIN tab_provincia ON tab_provincia.pro_id = loc.pro_id
                INNER JOIN tab_departamento ON tab_departamento.dep_id = tab_provincia.dep_id
                WHERE ubi_par='0' 
                AND ubi_estado = 1 
                $where $sort $limit ";
        
        $result = $this->ubicacion->dbselectBySQL($sql);
        $total = $this->ubi->count2($query, $qtype);
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
            $datosPadre = $this->ubi->dameIdPadre($un->ubi_id);

            if ($datosPadre != "") {
                $padre = $this->ubi->dameDatosUbicacion($datosPadre->ubi_par);
                $codigo = "-> " . $padre->ubi_codigo; //$datosPadre->ubi_par;
            } else
                $codigo = $this->ubi->dameDatosUbicacion($un->ubi_id)->ubi_codigo; //	$codigo= " ";
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->ubi_id . "',";
            $json .= "cell:['" . $un->ubi_id . "'";
            $json .= ",'" . addslashes($un->dep_nombre) . "'";
            $json .= ",'" . addslashes($un->pro_nombre) . "'";
            $json .= ",'" . addslashes($un->loc_nombre) . "'";
            $json .= ",'" . addslashes($un->ubi_codigo) . "'";
            $json .= ",'" . addslashes($un->ubi_descripcion) . "'";
            $json .= ",'" . addslashes($un->ubi_direccion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
            //}
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $departamento = new departamento();
        $this->registry->template->dep_id = $departamento->obtenerSelect();
        $this->registry->template->pro_id = "";
        $this->registry->template->loc_id = "";

        $this->registry->template->ubi_id = "";
        $this->registry->template->ubi_par = "";
        $this->registry->template->ubi_codigo = '';
        $this->registry->template->titulo_ubi = "NUEVO EDIFICIO";
        $this->registry->template->ubi_descripcion = "";
        $this->registry->template->ubi_direccion = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_ubicacion.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->ubicacion = new tab_ubicacion ();
        $this->ubicacion->setRequest2Object($_REQUEST);
        $this->ubicacion->setLoc_id($_REQUEST['loc_id']);
        $this->ubicacion->setUbi_par('0');
        $this->ubicacion->setUbi_codigo($_REQUEST['ubi_codigo']);
        $this->ubicacion->setUbi_descripcion($_REQUEST['ubi_descripcion']);
        $this->ubicacion->setUbi_direccion($_REQUEST['ubi_direccion']);
        $this->ubicacion->setUbi_usuario_crea($_SESSION ['USU_ID']);
        $this->ubicacion->setUbi_usuario_mod(0);
        $this->ubicacion->setUbi_fecha_crea(date('Y-m-d'));
        $this->ubicacion->setUbi_fecha_mod('');
        $this->ubicacion->setUbi_estado(1);

        $this->ubicacion->insert();
        Header("Location: " . PATH_DOMAIN . "/ubicacion/");
    }    
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/ubicacion/view/" . $_REQUEST["ubi_id"] . "/");
    }

    function view() { //Edificios
        if(! VAR3){ die("Error del sistema 404"); }
        $this->ubicacion = new tab_ubicacion ();
        $tab_provincia = new tab_provincia();
        $tab_localidad = new tab_localidad();

        $this->ubicacion->setRequest2Object($_REQUEST);
        $ubi = new ubicacion ();
        $row = $this->ubicacion->dbselectByField("ubi_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row [0];

        $row_loc = $tab_localidad->dbselectByField("loc_id", $row->loc_id);
        $row_pro = $tab_provincia->dbselectByField("pro_id", $row_loc[0]->pro_id);

        $departamento = new departamento();
        $provincia = new provincia();
        $localidad = new localidad();

        $this->registry->template->dep_id = $departamento->obtenerSelect($row_pro[0]->dep_id);
        $this->registry->template->pro_id = $provincia->selectPro($row_loc[0]->pro_id, $row_pro[0]->dep_id);
        $this->registry->template->loc_id = $localidad->selectLoc($row->loc_id, $row_loc[0]->pro_id);

        $this->registry->template->ubi_id = $row->ubi_id;
        $this->registry->template->ubi_par = $row->ubi_par;
        $this->registry->template->titulo_ubi = "EDITAR EDIFICIO";
        $this->registry->template->ubi_codigo = $row->ubi_codigo;
        $this->registry->template->ubi_descripcion = $row->ubi_descripcion;
        $this->registry->template->ubi_direccion = $row->ubi_direccion;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_ubicacion.tpl');
        $this->registry->template->show('footer');
    }

    function pisog() {
        $this->registry->template->ubi_id = "";
        $this->ubicacion = new tab_ubicacion ();
        $resul = $this->ubicacion->dbselectBySQL("SELECT * FROM tab_ubicacion WHERE ubi_id = " . VAR3);
        if (count($resul))
            $codigo = $resul[0]->ubi_codigo;
        else
            $codigo = "";
        $this->registry->template->ubi_codigo = $codigo;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "addPiso";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_pisog.tpl');
        $this->registry->template->show('footer');
    }

    function loadPisos() {
        $this->ubicacion = new tab_ubicacion ();
        $this->ubicacion->setRequest2Object($_REQUEST);

        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ubi_id';
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
            if ($qtype == 'ubi_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT * FROM tab_ubicacion WHERE ubi_par = " . VAR3 . " AND ubi_estado = '1' $where $sort $limit ";

        $resul = $this->ubicacion->dbselectBySQL($sql);
        $this->ubi = new ubicacion();
        $total = $this->ubi->countPiso($query, $qtype, VAR3);
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
        foreach ($resul as $un) {
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->ubi_id . "',";
            $json .= "cell:['" . $un->ubi_id . "'";
            $json .= ",'" . addslashes($un->ubi_codigo) . "'";
            $json .= ",'" . addslashes($un->ubi_descripcion) . "'";
            $json .= ",'" . addslashes($un->ubi_direccion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
            //}
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function editarPiso() {
        Header("Location: " . PATH_DOMAIN . "/ubicacion/viewPiso/" . $_REQUEST["ubi_id"] . "/");
    }

    function viewPiso() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->ubicacion = new tab_ubicacion ();
        $row = $this->ubicacion->dbselectByField("ubi_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row [0];

        $this->registry->template->ubi_id = $row->ubi_id;
        $this->registry->template->loc_id = $row->loc_id;
        $this->registry->template->ubi_par = $row->ubi_par;
        $row_padre = $this->ubicacion->dbselectByField("ubi_id", $row->ubi_par);
        $padre = $row_padre[0];
        $this->registry->template->ubi_par2 = $padre->ubi_codigo;
        $this->registry->template->ubi_codigo = $row->ubi_codigo;
        $this->registry->template->titulo_ubi = "EDITAR PISO";
        $this->registry->template->ubi_descripcion = $row->ubi_descripcion;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "updatePiso";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_piso.tpl');
        $this->registry->template->show('footer');
    }



    function addPiso() {
        $localidad = new localidad();
        $ubicacion = new ubicacion ();
        if ($ubicacion->esPadre(VAR3) != true) {
            $row = $ubicacion->dbSelectBySQL("SELECT * FROM tab_ubicacion WHERE ubi_id='" . $ubicacion->dameIdPadre(VAR3)->ubi_par . "' AND ubi_par ='0' AND ubi_estado='1'");
        } else {
            $row = $ubicacion->dbSelectBySQL("SELECT * FROM tab_ubicacion WHERE  ubi_id='" . VAR3 . "' AND ubi_estado='1'");
            //echo $row[0];
        }
        $this->registry->template->loc_id = $localidad->buscaIdLocalidad($row [0]->ubi_id);
        $this->registry->template->ubi_id = "";
        $this->registry->template->ubi_par = VAR3;
        $this->registry->template->ubi_par2 = $row [0]->ubi_codigo;
        $this->registry->template->ubi_codigo = '';
        $this->registry->template->titulo_ubi = "NUEVO PISO";
        $this->registry->template->ubi_descripcion = "";

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "savePiso";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_piso.tpl');
        $this->registry->template->show('footer');
    }

    function savePiso() {
        $this->ubicacion = new tab_ubicacion ();
        $this->ubicacion->setRequest2Object($_REQUEST);
        $this->ubicacion->setUbi_par($_REQUEST['ubi_par']);
        $this->ubicacion->setLoc_id($_REQUEST['loc_id']);
        $this->ubicacion->setUbi_codigo($_REQUEST['ubi_codigo']);
        $this->ubicacion->setUbi_descripcion($_REQUEST['ubi_descripcion']);
        $this->ubicacion->setUbi_direccion('');
        $this->ubicacion->setUbi_usuario_crea($_SESSION ['USU_ID']);
        $this->ubicacion->setUbi_usuario_mod(0);
        $this->ubicacion->setUbi_fecha_crea(date('Y-m-d'));
        $this->ubicacion->setUbi_fecha_mod('');
        $this->ubicacion->setUbi_estado('1');

        $this->ubicacion->insert();
        Header("Location: " . PATH_DOMAIN . "/ubicacion/pisog/" . $_REQUEST['ubi_par'] . "/");
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////
    function update() {
        $this->ubicacion = new tab_ubicacion ();
        $this->ubicacion->setRequest2Object($_REQUEST);

        $rows = $this->ubicacion->dbselectByField("ubi_id", $_REQUEST['ubi_id']);
        $this->ubicacion = $rows[0];
        $this->ubicacion->setUbi_id($_REQUEST['ubi_id']);
        $this->ubicacion->setLoc_id($_REQUEST['loc_id']);
        $this->ubicacion->setUbi_codigo($_REQUEST['ubi_codigo']);
        $this->ubicacion->setUbi_descripcion($_REQUEST['ubi_descripcion']);
        $this->ubicacion->setUbi_direccion($_REQUEST['ubi_direccion']);
        $this->ubicacion->setUbi_fecha_mod(date("Y-m-d"));
        $this->ubicacion->setUbi_usuario_mod($_SESSION['USU_ID']);

        $this->ubicacion->update();
        Header("Location: " . PATH_DOMAIN . "/ubicacion/");
    }

    function updatePiso() {
        $this->ubicacion = new tab_ubicacion ();
        $this->ubicacion->setRequest2Object($_REQUEST);
        $rows = $this->ubicacion->dbselectByField("ubi_id", $_REQUEST['ubi_id']);
        $this->ubicacion = $rows[0];
        $this->ubicacion->setUbi_id($_REQUEST['ubi_id']);
        $this->ubicacion->setUbi_codigo($_REQUEST['ubi_codigo']);
        $this->ubicacion->setUbi_descripcion($_REQUEST['ubi_descripcion']);
        $this->ubicacion->setUbi_direccion(' ');
        $this->ubicacion->setUbi_usuario_mod($_SESSION ['USU_ID']);
        $this->ubicacion->setUbi_fecha_mod(date("Y-m-d"));
        $this->ubicacion->update();
        Header("Location: " . PATH_DOMAIN . "/ubicacion/pisog/" . $_REQUEST['ubi_par'] . "/");
    }

    function delete() {
        $this->ubicacion = new tab_ubicacion();
        $this->ubicacion->setRequest2Object($_REQUEST);
        $this->ubicacion->setUbi_id($_REQUEST['ubi_id']);
        $this->ubicacion->setUbi_estado(2);
        $this->ubicacion->update();
        $this->ubi = new tab_ubicacion ();
        $pisos = $this->ubi->dbSelectBySQL("SELECT * FROM  tab_ubicacion WHERE ubi_par='" . $_REQUEST['ubi_id'] . "'");
        if (count($pisos)) {
            foreach ($pisos as $piso) {
                $this->ubi->setUbi_id($piso->ubi_id);
                $this->ubi->setUbi_estado(2);
                $this->ubi->update();
            }
        }
    }

    function deletePiso() {
        $this->ubicacion = new tab_ubicacion ();
        $this->ubicacion->setRequest2Object($_REQUEST);

        $this->ubicacion->setUbi_id($_REQUEST['ubi_id']);
        $this->ubicacion->setUbi_estado(2);

        $this->ubicacion->update();
    }

    function loadAjaxPisos() {
        $par = $_POST["edif"];
        $sql = "SELECT *
		FROM
		tab_ubicacion
		WHERE
                tab_ubicacion.ubi_estado =  '1' AND
                tab_ubicacion.ubi_par =  '$par'";
        $ubicacion = new tab_ubicacion();
        $result = $ubicacion->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            $res[$row->ubi_id] = $row->ubi_codigo;
        }
        echo json_encode($res);
    }

    function verifyFields() {
        $ubicacion = new ubicacion();
        $ubi_codigo = trim($_POST['ubi_codigo']);
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
        if ($ubicacion->existeCodigo($ubi_codigo)) {
            echo 'El código ya existe, escriba otro.';            
        }
        //if (strlen($uni_codigo) < 2 || strlen($uni_codigo) > 2) {
        //    echo 'El tamaño debe de ser igual a 2.';
        //} 
        else {
            echo '';
        }
        }
        else {
            echo '';
        }
    }
    
  
    
    function verifCodigo() {
        $ubicacion = new ubicacion();
        $ubicacion->setRequest2Object($_REQUEST);
        $ubi_id = $_REQUEST['Ubi_id'];
        $ubi_codigo = strtolower(trim($_REQUEST['Ubi_codigo']));
        if ($ubicacion->existeCodigo($ubi_codigo, $ubi_id)) {
            echo 'El código ya existe, escriba otro.';
        }
        echo '';
    }
}

?>
