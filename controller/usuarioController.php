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
class usuarioController Extends baseController {

    function index() {
        
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;        
        $this->registry->template->usu_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_usuariog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $usuario = new usuario();
        $this->usuario = new tab_usuario();
        $this->usuario->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'usu_id';
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
            if ($qtype == 'usu_id')
                $where = " and usu_id = '$query' ";
            elseif ($qtype == 'usu_leer_doc') {
                if (strtolower($query) == 's' || strtolower($query) == 'si')
                    $where = " and usu_leer_doc = '1' ";
                if (strtolower($query) == 'n' || strtolower($query) == 'no')
                    $where = " and usu_leer_doc = '2' ";
            }elseif ($qtype == 'unidad')
                $where = " and uni_id IN (SELECT uni_id FROM tab_unidad WHERE uni_codigo LIKE '%$query%') ";
            elseif ($qtype == 'rol_cod')
                $where = " and rol_id IN (SELECT rol_id FROM tab_rol WHERE rol_cod LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '$query%' ";
        }
        $root = "";
        if ($_SESSION ["ROL_COD"]=='ROOT'){
            $root = "OR u.usu_estado = 0";    
        }
        $sql = "SELECT
                u.usu_id,
                u.usu_apellidos,
                u.usu_nombres,
                u.usu_login,
                u.usu_fono,
                u.usu_email,
		(SELECT su.uni_descripcion FROM tab_unidad AS su WHERE su.uni_id=u.uni_id AND su.uni_estado = '1' ) as uni_descripcion,
                (CASE (u.usu_leer_doc) WHEN 1 THEN 'SI' WHEN 2 THEN 'NO' END) as usu_leer_doc,
                (SELECT sr.rol_cod FROM tab_rol AS sr WHERE sr.rol_id=u.rol_id) as rol_cod
                FROM tab_usuario AS u
                WHERE u.usu_estado = 1 $root $where $sort $limit";

        $result = $this->usuario->dbselectBySQL($sql);
        $total = $usuario->count($where);
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
            $json .= "id:'" . $un->usu_id . "',";
            $json .= "cell:['" . $un->usu_id . "'";
            $json .= ",'" . addslashes($un->usu_nombres) . "'";
            $json .= ",'" . addslashes($un->usu_apellidos) . "'";
            $json .= ",'" . addslashes($un->uni_descripcion) . "'";
            $json .= ",'" . addslashes($un->rol_cod) . "'";
            $json .= ",'" . addslashes($usuario->getSeries($un->usu_id)) . "'";
            //$json .= ",'" . addslashes($un->creado_x_import) . "'";
            $json .= ",'" . addslashes($un->usu_leer_doc) . "'";
            $json .= ",'" . addslashes($un->usu_fono) . "'";
            $json .= ",'" . addslashes($un->usu_email) . "'";
            $json .= ",'" . addslashes($un->usu_login) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $unidad = new unidad();
        $usuario = new usuario();
        $rol = new rol();
        $this->registry->template->titulo = "NUEVO USUARIO DEL SISTEMA";
        $this->registry->template->roles = $rol->obtenerSelectRoles();
        $this->registry->template->uni_id = $unidad->obtenerSelectUnidades(0);
        $this->registry->template->usu_id = "";
        $this->registry->template->mod_login = "";
        $this->registry->template->usu_nombres = "";
        $this->registry->template->usu_apellidos = "";
        $this->registry->template->usu_fono = "";
        $this->registry->template->usu_email = "";
//        $this->registry->template->usu_nro_item = "";
        $this->registry->template->usu_fech_ing = "";
        $this->registry->template->usu_fech_fin = "";
        $this->registry->template->usu_login = "";
        $this->registry->template->usu_leer_doc = "";
        $this->registry->template->usu_verproy = "NO";

        $this->registry->template->lista_seccion = "";
        $this->registry->template->leer_doc = '<option value="1">LEER</option><option value="2">NO LEER</option>';
        $this->registry->template->crear_doc = 'NO';
        
        $series = new series();
        $this->registry->template->lista_series = $usuario->allSeries(); 

        
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
        $this->registry->template->show('tab_usuario.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->usuario = new tab_usuario();
        $userLogin = new usuario();
        $this->usuario->setRequest2Object($_REQUEST);
        $this->usuario->setUsu_id($_REQUEST['usu_id']);
        $this->usuario->setUni_id($_REQUEST['uni_id']);
        $this->usuario->setUsu_nombres($_REQUEST['usu_nombres']);
        $this->usuario->setUsu_apellidos($_REQUEST['usu_apellidos']);
        $this->usuario->setUsu_iniciales('AA');
        $this->usuario->setUsu_fono($_REQUEST['usu_fono']);
        $this->usuario->setUsu_email($_REQUEST['usu_email']);
        $this->usuario->setUsu_fech_ing(date("Y-m-d"));
        if ($_REQUEST['usu_login'] == "")
            $this->usuario->setUsu_login($userLogin->generarLogin($_REQUEST['usu_nombres'], $_REQUEST['usu_apellidos']));
        else
            $this->usuario->setUsu_login($_REQUEST['usu_login']);
        if ($_REQUEST['usu_pass'] != '')
            $pass = md5($_REQUEST['usu_pass']);
        else
            $pass = '';
        $this->usuario->setUsu_pass($pass);
        $this->usuario->setUsu_leer_doc($_REQUEST['usu_leer_doc']);
        $pass_leer = '';
        $pass_dias = '';
        if ($_REQUEST['usu_leer_doc'] == '1') {
            if ($_REQUEST['usu_pass_leer'] != '')
                $pass_leer = md5($_REQUEST['usu_pass_leer']);
            if ($_REQUEST['usu_pass_dias'] != '')
                $pass_dias = $_REQUEST['usu_pass_dias'];
        }
        $this->usuario->setUsu_pass_leer($pass_leer);
        $this->usuario->setUsu_pass_fecha(date("Y-m-d"));
        $this->usuario->setUsu_pass_dias($pass_dias);
        $this->usuario->setUsu_estado(1);
        $this->usuario->setRol_id($_REQUEST['usu_rol_id']);
        //$this->usuario->setUsu_verproy($_REQUEST['usu_verproy']);
        $usu_id = $this->usuario->insert();
        
        
        if (isset($_REQUEST['lista_serie'])) {
            $series = $_REQUEST['lista_serie'];
            foreach ($series as $serie) {
                $use = new tab_usu_serie();
                $use->setUsu_id($usu_id);
                $use->setSer_id($serie);
                $use->setUse_estado(1);
                $use->insert();
            }
        }
        Header("Location: " . PATH_DOMAIN . "/usuario/");
    }
    
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/usuario/view/" . $_REQUEST["usu_id"] . "/");
    }

    function view() {
        //if(! VAR3){ die("Error del sistema 404"); }
        $this->usuario = new tab_usuario();
        $usuario = new usuario();
        $this->usuario->setRequest2Object($_REQUEST);
        $row = $this->usuario->dbselectByField("usu_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "EDITAR USUARIO DEL SISTEMA";
        $this->registry->template->usu_id = $row->usu_id;
        $this->registry->template->mod_login = " disabled=\"disabled\"";
        $unidad = new unidad();
        $this->registry->template->uni_id = $unidad->listUnidad($row->uni_id);
        $rol = new rol();
        $this->registry->template->roles = $rol->obtenerSelectRoles($row->rol_id);
        if ($row->usu_leer_doc == '1') {
            $selected1 = " selected";
            $selected2 = "";
        }else {
            if ($row->usu_leer_doc == '2') {
                $selected2 = " selected";
                $selected1 = "";
            }else{
                $selected1 = "";
                $selected2 = "";
            }            
        }
        $this->registry->template->leer_doc = '<option value="1" ' . $selected1 . '>LEER</option><option value="2" ' . $selected2 . '>NO LEER</option>';
        //$this->registry->template->crear_doc = ($row->usu_crear_doc == '1' ? 'SI' : 'NO');

        $this->registry->template->usu_nombres = $row->usu_nombres;
        $this->registry->template->usu_apellidos = $row->usu_apellidos;
        //$this->registry->template->usu_iniciales = $row->usu_iniciales;
        $this->registry->template->usu_fono = $row->usu_fono;
        $this->registry->template->usu_email = $row->usu_email;
        $this->registry->template->usu_nro_item = $row->usu_nro_item;
        $this->registry->template->usu_fech_ing = $row->usu_fech_ing;
        $this->registry->template->usu_fech_fin = $row->usu_fech_fin;
        $this->registry->template->usu_login = $row->usu_login;
        $this->registry->template->usu_leer_doc = $row->usu_leer_doc;
        $this->registry->template->usu_verproy = $row->usu_verproy;

        $series = new series();
        $this->registry->template->lista_series = $usuario->allSeriesSeleccionado($row->usu_id); //$series->obtenerCheck($row->usu_id);
        $unidad = new unidad();
        $this->registry->template->lista_seccion = "";//$unidad->obtenerCheck($row->uni_id, $row->usu_id);

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
        $this->registry->template->show('tab_usuario.tpl');
        $this->registry->template->show('footer');
    }

    function clonar() {
        Header("Location: " . PATH_DOMAIN . "/usuario/clonar_view/" . $_REQUEST["usu_id"] . "/");
    }

    function clonar_view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->usuario = new tab_usuario();
        $usuario = new usuario();
        $this->usuario->setRequest2Object($_REQUEST);
        $row = $this->usuario->dbselectByField("usu_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "NUEVO USUARIO DEL SISTEMA";
        $this->registry->template->usu_id = "";
        $this->registry->template->mod_login = "";
        $unidad = new unidad();
        $this->registry->template->uni_id = $unidad->listUnidad($row->uni_id);
        $rol = new rol();
        $this->registry->template->roles = $rol->obtenerSelectRoles($row->rol_id);
        $this->registry->template->leer_doc = '<option value="1">LEER</option><option value="2">NO LEER</option>';
        $this->registry->template->crear_doc = 'NO';

        $this->registry->template->usu_nombres = "";
        $this->registry->template->usu_apellidos = "";
        //$this->registry->template->usu_iniciales = $row->usu_iniciales;
        $this->registry->template->usu_fono = "";
        $this->registry->template->usu_email = "";
        $this->registry->template->usu_nro_item = "";
        $this->registry->template->usu_fech_ing = "";
        $this->registry->template->usu_fech_fin = "";
        $this->registry->template->usu_login = "";
        $this->registry->template->usu_leer_doc = "";
        $this->registry->template->usu_verproy = "";


        $series = new series();
        $this->registry->template->lista_series = $usuario->allSeriesSeleccionado($row->usu_id); //$series->obtenerCheck($row->usu_id);


        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_usuario.tpl');
        $this->registry->template->show('footer');
    }


    function update() {
        $this->usuario = new tab_usuario();
        $this->usuario->setRequest2Object($_REQUEST);
        $rol = new rol();
        $this->registry->template->roles = $rol->obtenerSelectRoles();
        $rows = $this->usuario->dbselectByField("usu_id", $_REQUEST['usu_id']);
        $this->usuario = $rows[0];
        $id = $this->usuario->usu_id;
        $this->usuario->setUsu_id($_REQUEST['usu_id']);
        $this->usuario->setUni_id($_REQUEST['uni_id']);
        $this->usuario->setUsu_nombres($_REQUEST['usu_nombres']);
        $this->usuario->setUsu_apellidos($_REQUEST['usu_apellidos']);
        $this->usuario->setUsu_iniciales('AA');
        $this->usuario->setUsu_fono($_REQUEST['usu_fono']);
        $this->usuario->setUsu_email($_REQUEST['usu_email']);
//        $this->usuario->setUsu_nro_item($_REQUEST['usu_nro_item']);
        $this->usuario->setUsu_leer_doc($_REQUEST['usu_leer_doc']);
        if ($_REQUEST['usu_pass'] != '')
            $this->usuario->setUsu_pass(md5($_REQUEST['usu_pass']));
        if ($_REQUEST['usu_leer_doc'] == '1') {
            if ($_REQUEST['usu_pass_leer'] != '' && $_REQUEST['usu_pass_dias'] != '') {
                $this->usuario->setUsu_pass_leer(md5($_REQUEST['usu_pass_leer']));
                $this->usuario->setUsu_pass_fecha(date("Y-m-d"));
                $this->usuario->setUsu_pass_dias($_REQUEST['usu_pass_dias']);
            }
        }
        if ($_REQUEST['usu_leer_doc'] == '2') {
            $this->usuario->setUsu_pass_fecha('');
        }
//        $this->usuario->setUsu_fecha_mod(date("Y-m-d"));
//        $this->usuario->setUsu_mod($_SESSION['USU_ID']);
        $this->usuario->setUsu_leer_doc($_REQUEST['usu_leer_doc']);
        $this->usuario->setRol_id($_REQUEST['usu_rol_id']);
        //$this->usuario->setUsu_verproy($_REQUEST['usu_verproy']);
        //$this->usuario->setUsu_verproy(1);
        $this->usuario->setUsu_estado(1);
        $this->usuario->update();


        // MODIFIED: CASTELLON
        //if($_REQUEST['usu_pass_leer']=='')
        //	$this->usuario->updateValue("usu_pass_leer", '', $id);
        //if($_REQUEST['usu_nro_item']=='')
        //	$this->usuario->updateValue("usu_nro_item", '', $id);
        //if($_REQUEST['usu_email']=='')
        //	$this->usuario->updateValue("usu_email", '', $id);
        //if($_REQUEST['usu_fono']=='')
        //	$this->usuario->updateValue("usu_fono", '', $id);
        // MODIFIED: CASTELLON
        //if($_REQUEST['usu_nro_item']=='')
        //	$this->usuario->updateValue("usu_nro_item", '', $id);

        $use = new usu_serie();
        $use->delete($id);
        if (isset($_REQUEST['lista_serie'])) {
            $series = $_REQUEST['lista_serie'];
            foreach ($series as $serie) {
                // damos de baja todas las ocurrencias
                // damos de alta las que se encuentran en $series o insertamos en caso de q no existan
                $use_id = $use->existe($serie, $id);
                if ($use_id != null) {
                    //update
                    $tuse = new tab_usu_serie();
                    $tuse->setUse_id($use_id);
                    $tuse->setUsu_id($id);
                    $tuse->setSer_id($serie);
                    $tuse->setUse_estado('1');
//                    $tuse->setUse_fecha_mod(date("Y-m-d"));
//                    $tuse->setUse_usu_mod($_SESSION['USU_ID']);
                    $tuse->update();
                } else {
                    //insert
                    $tuse = new tab_usu_serie();
                    $tuse->setUsu_id($id);
                    $tuse->setSer_id($serie);
                    $tuse->setUse_estado('1');
//                    $tuse->setUse_fecha_crea(date("Y-m-d"));
//                    $tuse->setUse_usu_crea($_SESSION['USU_ID']);
                    $tuse->insert();
                }
            }
        }

//        //Secciones
//        $use = new usu_sec();
//        $use->delete($id);
//        if (isset($_REQUEST['lista_sec'])) {
//            $seccion = $_REQUEST['lista_sec'];
//            foreach ($seccion as $sec) {
//                // damos de baja todas las ocurrencias
//                // damos de alta las que se encuentran en $series o insertamos en caso de q no existan
//                $use_id = $use->existe($sec, $id);
//                if ($use_id != null) {
//                    //update
//                    $tuse = new tab_usu_sec();
//                    $tuse->setUse_id($use_id);
//                    $tuse->setUsu_id($id);
//                    $tuse->setSec_id($sec);
//                    $tuse->setUse_estado('1');
//                    $tuse->update();
//                } else {
//                    //insert
//                    $tuse = new tab_usu_sec();
//                    $tuse->setUsu_id($id);
//                    $tuse->setSec_id($sec);
//                    $tuse->setUse_estado('1');
//                    $tuse->insert();
//                }
//            }
//        }


        Header("Location: " . PATH_DOMAIN . "/usuario/");
    }

    function delete() {
        $this->usuario = new tab_usuario();
        /* $this->usurolmenu = new Tab_usurolmenu();
          $this->usuario->setRequest2Object($_REQUEST);
          $sql = "UPDATE tab_usurolmenu SET urm_estado='2' Where usu_id='".$_REQUEST['usu_id']."' ";
          $this->usurolmenu->dbselectBySQL($sql); */
        $this->usuario->setUsu_id($_REQUEST['usu_id']);
        $this->usuario->setUsu_estado(2);
        $this->usuario->update();
        $usu_serie = new usu_serie();
        $usu_serie->deleteXUsuario($_REQUEST['usu_id']);
        $usu_uni = new usu_uni();
        $usu_uni->deleteXUsuario($_REQUEST['usu_id']);
    }

    function verifLogin() {
        $usuario = new usuario();
        $usuario->setRequest2Object($_REQUEST);
        $usu_id = $_REQUEST['usu_id'];
        $login = strtolower(trim($_REQUEST['login']));
        if ($usuario->existeLogin($login, $usu_id)) {
            echo 'Login ya existe, escriba otro.';
        }
        echo '';
    }

    function verificaPass() {
        $usuario = new Tab_usuario();
        $row = $usuario->dbSelectBySQL("SELECT * FROM tab_usuario WHERE
		usu_id='" . $_SESSION['USU_ID'] . "' AND
		usu_pass ='" . md5($_REQUEST['pass_usu']) . "' ");
        if (count($row))
            echo 'OK';
        else
            echo 'Password incorrecto.';
    }

    function listUsuarioJson() {
        $this->usu = new usuario();
        echo $this->usu->listUsuarioJson();
    }

    function obtenerCon() {
        $contenedor = new contenedor();
        $res = $contenedor->selectCon(0, $_REQUEST['Usu_id']);
        echo $res;
    }

    function loadAjaxCkeck() {
        $unidad = new unidad();
        $usu_id = $_REQUEST['Usu_id'];
        $uni_id = $_REQUEST['Uni_id'];
        $lista = $unidad->obtenerCheck($uni_id, $usu_id);
        echo $lista;
    }

    function verifyFieldsLogin() {
        $usuario = new usuario();
        $usu_id = $_POST['usu_id'];
        $usu_login = strtolower(trim($_POST['usu_login']));
        if ($usuario->existeLogin($usu_login, $usu_id)) {
            echo 'Login ya existe, escriba otro.';
        } else {
            echo '';
        }
    }

}

?>
