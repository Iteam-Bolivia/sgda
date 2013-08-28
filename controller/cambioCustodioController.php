<?php

/**
 * cambioCustodioController
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class cambioCustodioController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->usu_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('header');
        $this->registry->template->show('tab_usuariog.tpl');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/usuario/view/" . $_REQUEST["usu_id"] . "/");
    }

    function view() {
        $this->usuario = new tab_usuario();
        $this->usuario->setRequest2Object($_REQUEST);
        $row = $this->usuario->dbselectByField("usu_id", VAR3);
        $row = $row[0];
        $this->registry->template->titulo = "Editar Usuario";
        $this->registry->template->usu_id = $row->usu_id;
        $unidad = new unidad();

        $this->registry->template->uni_id = $unidad->listUnidad($row->uni_id);
        $rol = new rol();
        $this->registry->template->roles = $rol->obtenerSelectRoles($row->rol_id);
        if ($row->usu_leer_doc == '1') {
            $selected1 = " selected";
            $selected2 = "";
        }
        if ($row->usu_leer_doc == '2') {
            $selected2 = " selected";
            $selected1 = "";
        }
        if ($row->usu_crear_doc == '1') {
            $selC1 = " selected";
            $selC2 = "";
        }
        if ($row->usu_crear_doc == '2') {
            $selC2 = " selected";
            $selC1 = "";
        }
        $this->registry->template->leer_doc = '<option value="1" ' . $selected1 . '>LEER</option><option value="2" ' . $selected2 . '>NO LEER</option>';
        $this->registry->template->crear_doc = '<option value="1" ' . $selC1 . '>SI</option><option value="2" ' . $selC2 . '>NO</option>';

        $this->registry->template->usu_nombres = $row->usu_nombres;
        $this->registry->template->usu_apellidos = $row->usu_apellidos;
        $this->registry->template->usu_fono = $row->usu_fono;
        $this->registry->template->usu_email = $row->usu_email;
        $this->registry->template->usu_nro_item = $row->usu_nro_item;
        $this->registry->template->usu_fech_ing = $row->usu_fech_ing;
        $this->registry->template->usu_fech_fin = $row->usu_fech_fin;
        $this->registry->template->usu_login = $row->usu_login;
        $this->registry->template->usu_leer_doc = $row->usu_leer_doc;
        $this->registry->template->usu_crear_doc = $row->usu_crear_doc;

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_usuario.tpl');
    }

    function load() {
        $usuario = new usuario();
        $unidad = new unidad();
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
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
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
            else
                $where = " AND $qtype LIKE '$query%' ";
        }
        $sql = "SELECT * FROM tab_usuario WHERE usu_estado = 1 $where $sort $limit";
        $result = $this->usuario->dbselectBySQL($sql);
        $total = $usuario->count($qtype, $query);
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
            if ($un->usu_leer_doc == '1')
                $leer_doc = "SI";
            elseif ($un->usu_leer_doc == '2')
                $leer_doc = "NO";
            else
                $leer_doc = " ";
            if ($un->usu_nombres != "")
                $nombre = $un->usu_nombres;
            else
                $nombre = "&nbsp;";
            if ($un->usu_apellidos != "")
                $apellido = $un->usu_apellidos;
            else
                $apellido = "&nbsp;";
            if ($un->usu_fono != "")
                $fono = $un->usu_fono;
            else
                $fono = "&nbsp;";
            if ($un->usu_email != "")
                $mail = $un->usu_email;
            else
                $mail = "&nbsp;";
            if ($un->usu_nro_item != "")
                $item = $un->usu_nro_item;
            else
                $item = "&nbsp;";
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->usu_id . "',";
            $json .= "cell:['" . $un->usu_id . "'";
            $json .= ",'" . addslashes($unidad->getCodigo($un->uni_id)) . "'";
            $json .= ",'" . addslashes($nombre) . "'";
            $json .= ",'" . addslashes($apellido) . "'";
            $json .= ",'" . addslashes($fono) . "'";
            $json .= ",'" . addslashes($mail) . "'";
            $json .= ",'" . addslashes($item) . "'";
            $json .= ",'" . addslashes($leer_doc) . "'";
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
        $rol = new rol();
        $this->registry->template->titulo = "Nuevo Usuario";

        $this->registry->template->roles = $rol->obtenerSelectRoles();
        $this->registry->template->uni_id = $unidad->listUnidad();
        $this->registry->template->usu_id = "";
        $this->registry->template->usu_nombres = "";
        $this->registry->template->usu_apellidos = "";
        $this->registry->template->usu_fono = "";
        $this->registry->template->usu_email = "";
        $this->registry->template->usu_nro_item = "";
        $this->registry->template->usu_fech_ing = "";
        $this->registry->template->usu_fech_fin = "";
        $this->registry->template->usu_login = "";
        $this->registry->template->usu_leer_doc = "";
        $this->registry->template->leer_doc = '<option value="1">LEER</option><option value="2">NO LEER</option>';
        $this->registry->template->crear_doc = '<option value="1">SI</option><option value="2">NO</option>';
        $this->registry->template->usu_crear_doc = "";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_usuario.tpl');
    }

    function save() {
        $this->usuario = new tab_usuario();
        $userLogin = new usuario();

        $this->usuario->setRequest2Object($_REQUEST);

        $this->usuario->setUsu_id($_REQUEST['usu_id']);
        $this->usuario->setUni_id($_REQUEST['uni_id']);
        $this->usuario->setUsu_nombres($_REQUEST['usu_nombres']);
        $this->usuario->setUsu_apellidos($_REQUEST['usu_apellidos']);
        $this->usuario->setUsu_fono($_REQUEST['usu_fono']);
        $this->usuario->setUsu_email($_REQUEST['usu_email']);
        $this->usuario->setUsu_nro_item($_REQUEST['usu_nro_item']);
        $this->usuario->setUsu_fech_ing(date("Y-m-d"));
        //$this->usuario->setUsu_fech_fin(date("Y-m-d"));
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
        $this->usuario->setUsu_crear_doc($_REQUEST['usu_crear_doc']);
        $this->usuario->setUsu_fecha_crea(date("Y-m-d"));
        $this->usuario->setUsu_crea($_SESSION['USU_ID']);
        $this->usuario->setUsu_estado(1);
        $this->usuario->setRol_id($_REQUEST['usu_rol_id']);
        $this->usuario->insert();
        Header("Location: " . PATH_DOMAIN . "/usuario/");
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
        $this->usuario->setUsu_fono($_REQUEST['usu_fono']);
        $this->usuario->setUsu_email($_REQUEST['usu_email']);
        $this->usuario->setUsu_nro_item($_REQUEST['usu_nro_item']);
        $this->usuario->setUsu_crear_doc($_REQUEST['usu_crear_doc']);
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
            $this->usuario->setUsu_pass_fecha('0000-00-00');
        }
        $this->usuario->setUsu_fecha_mod(date("Y-m-d"));
        $this->usuario->setUsu_mod($_SESSION['USU_ID']);
        $this->usuario->setUsu_leer_doc($_REQUEST['usu_leer_doc']);
        $this->usuario->setUsu_crear_doc($_REQUEST['usu_crear_doc']);
        $this->usuario->setRol_id($_REQUEST['usu_rol_id']);
        $this->usuario->setUsu_estado(1);
        $this->usuario->update();

        if ($_REQUEST['usu_pass_leer'] == '')
            $this->usuario->updateValue("usu_pass_leer", '', $id);
        if ($_REQUEST['usu_nro_item'] == '')
            $this->usuario->updateValue("usu_nro_item", '', $id);
        if ($_REQUEST['usu_email'] == '')
            $this->usuario->updateValue("usu_email", '', $id);
        if ($_REQUEST['usu_fono'] == '')
            $this->usuario->updateValue("usu_fono", '', $id);
        if ($_REQUEST['usu_nro_item'] == '')
            $this->usuario->updateValue("usu_nro_item", '', $id);
        Header("Location: " . PATH_DOMAIN . "/usuario/");
    }

    function delete() {
        $this->usuario = new tab_usuario();
        $this->usurolmenu = new Tab_usurolmenu();
        $this->usuario->setRequest2Object($_REQUEST);
        $sql = "UPDATE tab_usurolmenu SET urm_estado='2' Where usu_id='" . $_REQUEST['usu_id'] . "' ";
        $this->usurolmenu->dbselectBySQL($sql);
        $this->usuario->setUsu_id($_REQUEST['usu_id']);
        $this->usuario->setUsu_estado(2);
        $this->usuario->update();
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

}

?>
