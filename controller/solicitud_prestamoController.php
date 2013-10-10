<?php

/**
 * solicitud_prestamoController
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class solicitud_prestamoController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->spr_id = "";
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
        $this->registry->template->show('tab_solicitud_prestamog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $uni_id = $_SESSION['UNI_ID'];
        $solicitud_prestamo = new solicitud_prestamo();
        $this->solicitud_prestamo = new tab_solicitud_prestamo();
        $this->solicitud_prestamo->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'spr_id';
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
            if ($qtype == 'spr_id')
                $where = " and spr_id = '$query' ";
            elseif ($qtype == 'unidad')
                $where = " and uni_id IN (SELECT uni_id FROM tab_unidad WHERE uni_codigo LIKE '%$query%') ";
            elseif ($qtype == 'rol_cod')
                $where = " and rol_id IN (SELECT rol_id FROM tab_rol WHERE rol_cod LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '$query%' ";
        }

        $sql = "SELECT
                tab_solicitud_prestamo.spr_id,
                tab_solicitud_prestamo.spr_tipo,
                tab_solicitud_prestamo.spr_fecha,
                (SELECT uni_codigo FROM tab_unidad WHERE uni_id=tab_solicitud_prestamo.uni_id AND uni_estado = '1' ) as uni_codigo,
                tab_solicitud_prestamo.spr_docsolen,
                (SELECT int_descripcion FROM tab_institucion WHERE int_id=tab_solicitud_prestamo.int_id AND int_estado = '1' ) as int_id,
                tab_solicitud_prestamo.spr_solicitante,
                tab_solicitud_prestamo.spr_email,
                tab_solicitud_prestamo.spr_tel,
                (SELECT uni_codigo FROM tab_unidad WHERE uni_id=tab_solicitud_prestamo.unid_id AND uni_estado = '1' ) as unid_codigo,
                tab_solicitud_prestamo.spr_fecini,
                tab_solicitud_prestamo.spr_fecfin,
                tab_solicitud_prestamo.spr_fecren,
                tab_solicitud_prestamo.spr_obs,
                tab_solicitud_prestamo.spr_estado
                FROM
                tab_solicitud_prestamo
                WHERE tab_solicitud_prestamo.spr_estado = 1
                AND tab_solicitud_prestamo.uni_id = '$uni_id'
                $where $sort $limit ";

        //(SELECT int_descripcion FROM tab_institucion WHERE int_id=tab_solicitud_prestamo.int_id AND int_estado = '1' ) as int_id,


        $result = $this->solicitud_prestamo->dbselectBySQL($sql);
        $total = $solicitud_prestamo->count($where);
        $total = 1;
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
            $json .= "id:'" . $un->spr_id . "',";
            $json .= "cell:['" . $un->spr_id . "'";
            $json .= ",'" . addslashes($un->spr_tipo) . "'";
            $json .= ",'" . addslashes($un->spr_fecha) . "'";
            $json .= ",'" . addslashes($un->uni_codigo) . "'";
            $json .= ",'" . addslashes($un->spr_docsolen) . "'";
            $json .= ",'" . addslashes($un->int_id) . "'";
            $json .= ",'" . addslashes($un->spr_solicitante) . "'";
            $json .= ",'" . addslashes($un->spr_email) . "'";
            $json .= ",'" . addslashes($un->spr_tel) . "'";
            $json .= ",'" . addslashes($un->unid_codigo) . "'";
            $json .= ",'" . addslashes($un->spr_fecini) . "'";
            $json .= ",'" . addslashes($un->spr_fecfin) . "'";
            $json .= ",'" . addslashes($un->spr_fecren) . "'";
            $json .= ",'" . addslashes($un->spr_obs) . "'";
            $json .= ",'" . addslashes($un->spr_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
            //$json .= ",'" . addslashes($un->int_id) . "'";
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/solicitud_prestamo/view/" . $_REQUEST["spr_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->solicitud_prestamo = new tab_solicitud_prestamo();
        $this->solicitud_prestamo->setRequest2Object($_REQUEST);
        $row = $this->solicitud_prestamo->dbselectByField("spr_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar solicitud_prestamo";
        $this->registry->template->spr_id = $row->spr_id;
        $this->registry->template->mod_login = " disabled=\"disabled\"";
        $unidad = new unidad();

        $this->registry->template->uni_id = $unidad->listUnidad(0, $row->uni_id);
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
        $this->registry->template->crear_doc = ($row->usu_crear_doc == '1' ? 'SI' : 'NO');
        /* 1: POR IMPORTACION, 2: MANUALMENTE */

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

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $series = new series();
        $this->registry->template->lista_series = $series->obtenerCheck($row->spr_id);

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_solicitud_prestamo.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $unidad = new unidad();
        $this->registry->template->titulo = "Nuevo solicitud_prestamo";

        $this->registry->template->spr_id = "";
        $this->registry->template->spr_tipo = "";
        $this->registry->template->spr_fecha = "";
        $this->registry->template->uni_id = $unidad->listUnidad(0);
        $this->registry->template->spr_docsolen = "";
        $this->registry->template->int_id = $unidad->listUnidad(0);
        $this->registry->template->spr_solicitante = "";
        $this->registry->template->spr_email = "";
        $this->registry->template->spr_tel = "";
        $this->registry->template->unid_id = $unidad->listUnidad(0);
        $this->registry->template->spr_fecini = "";
        $this->registry->template->spr_fecfin = "";
        $this->registry->template->spr_fecren = "";
        $this->registry->template->spr_obs = "";

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
        $this->registry->template->show('tab_solicitud_prestamo.tpl');
        $this->registry->template->show('footer');
    }

    function verifLogin() {
        $solicitud_prestamo = new solicitud_prestamo();
        $solicitud_prestamo->setRequest2Object($_REQUEST);
        $spr_id = $_REQUEST['spr_id'];
        $login = strtolower(trim($_REQUEST['login']));
        if ($solicitud_prestamo->existeLogin($login, $spr_id)) {
            echo 'Login ya existe, escriba otro.';
        }
        echo '';
    }

    function save() {
        $this->solicitud_prestamo = new tab_solicitud_prestamo();
        $userLogin = new solicitud_prestamo();
        $this->solicitud_prestamo->setRequest2Object($_REQUEST);
        $this->solicitud_prestamo->setUsu_id($_REQUEST['spr_id']);
        $this->solicitud_prestamo->setUni_id($_REQUEST['uni_id']);
        $this->solicitud_prestamo->setUsu_nombres($_REQUEST['usu_nombres']);
        $this->solicitud_prestamo->setUsu_apellidos($_REQUEST['usu_apellidos']);
        $this->solicitud_prestamo->setUsu_iniciales('AA');
        $this->solicitud_prestamo->setUsu_fono($_REQUEST['usu_fono']);
        $this->solicitud_prestamo->setUsu_email($_REQUEST['usu_email']);
        $this->solicitud_prestamo->setUsu_nro_item($_REQUEST['usu_nro_item']);
        $this->solicitud_prestamo->setUsu_fech_ing(date("Y-m-d"));
        //$this->solicitud_prestamo->setUsu_fech_fin(date("Y-m-d"));
        if ($_REQUEST['usu_login'] == "")
            $this->solicitud_prestamo->setUsu_login($userLogin->generarLogin($_REQUEST['usu_nombres'], $_REQUEST['usu_apellidos']));
        else
            $this->solicitud_prestamo->setUsu_login($_REQUEST['usu_login']);
        if ($_REQUEST['usu_pass'] != '')
            $pass = md5($_REQUEST['usu_pass']);
        else
            $pass = '';
        $this->solicitud_prestamo->setUsu_pass($pass);
        $this->solicitud_prestamo->setUsu_leer_doc($_REQUEST['usu_leer_doc']);
        $pass_leer = '';
        $pass_dias = '';
        if ($_REQUEST['usu_leer_doc'] == '1') {
            if ($_REQUEST['usu_pass_leer'] != '')
                $pass_leer = md5($_REQUEST['usu_pass_leer']);
            if ($_REQUEST['usu_pass_dias'] != '')
                $pass_dias = $_REQUEST['usu_pass_dias'];
        }
        $this->solicitud_prestamo->setUsu_pass_leer($pass_leer);
        $this->solicitud_prestamo->setUsu_pass_fecha(date("Y-m-d"));
        $this->solicitud_prestamo->setUsu_pass_dias($pass_dias);
        $this->solicitud_prestamo->setUsu_crear_doc(2);
        $this->solicitud_prestamo->setUsu_fecha_crea(date("Y-m-d"));
        $this->solicitud_prestamo->setUsu_crea($_SESSION['USU_ID']);
        $this->solicitud_prestamo->setUsu_estado(1);
        $this->solicitud_prestamo->setRol_id($_REQUEST['usu_rol_id']);
        $spr_id = $this->solicitud_prestamo->insert();
        if (isset($_REQUEST['lista_serie'])) {
            $series = $_REQUEST['lista_serie'];
            foreach ($series as $serie) {
                $use = new tab_usu_serie();
                $use->setUsu_id($spr_id);
                $use->setSer_id($serie);
                $use->setUse_estado(1);
                $use->setUse_fecha_crea(date("Y-m-d"));
                $use->setUse_usu_crea($_SESSION['USU_ID']);
                $use->insert();
            }
        }
        Header("Location: " . PATH_DOMAIN . "/solicitud_prestamo/");
    }

    function update() {
        $this->solicitud_prestamo = new tab_solicitud_prestamo();
        $this->solicitud_prestamo->setRequest2Object($_REQUEST);
        $rol = new rol();
        $this->registry->template->roles = $rol->obtenerSelectRoles();
        $rows = $this->solicitud_prestamo->dbselectByField("spr_id", $_REQUEST['spr_id']);
        $this->solicitud_prestamo = $rows[0];
        $id = $this->solicitud_prestamo->spr_id;
        $this->solicitud_prestamo->setUsu_id($_REQUEST['spr_id']);
        $this->solicitud_prestamo->setUni_id($_REQUEST['uni_id']);
        $this->solicitud_prestamo->setUsu_nombres($_REQUEST['usu_nombres']);
        $this->solicitud_prestamo->setUsu_apellidos($_REQUEST['usu_apellidos']);
        $this->solicitud_prestamo->setUsu_iniciales('AA');
        $this->solicitud_prestamo->setUsu_fono($_REQUEST['usu_fono']);
        $this->solicitud_prestamo->setUsu_email($_REQUEST['usu_email']);
        $this->solicitud_prestamo->setUsu_nro_item($_REQUEST['usu_nro_item']);
        $this->solicitud_prestamo->setUsu_leer_doc($_REQUEST['usu_leer_doc']);
        if ($_REQUEST['usu_pass'] != '')
            $this->solicitud_prestamo->setUsu_pass(md5($_REQUEST['usu_pass']));
        if ($_REQUEST['usu_leer_doc'] == '1') {
            if ($_REQUEST['usu_pass_leer'] != '' && $_REQUEST['usu_pass_dias'] != '') {
                $this->solicitud_prestamo->setUsu_pass_leer(md5($_REQUEST['usu_pass_leer']));
                $this->solicitud_prestamo->setUsu_pass_fecha(date("Y-m-d"));
                $this->solicitud_prestamo->setUsu_pass_dias($_REQUEST['usu_pass_dias']);
            }
        }
        if ($_REQUEST['usu_leer_doc'] == '2') {
            $this->solicitud_prestamo->setUsu_pass_fecha('');
        }
        $this->solicitud_prestamo->setUsu_fecha_mod(date("Y-m-d"));
        $this->solicitud_prestamo->setUsu_mod($_SESSION['USU_ID']);
        $this->solicitud_prestamo->setUsu_leer_doc($_REQUEST['usu_leer_doc']);
        $this->solicitud_prestamo->setRol_id($_REQUEST['usu_rol_id']);
        $this->solicitud_prestamo->setUsu_estado(1);
        $this->solicitud_prestamo->update();


        // MODIFIED: CASTELLON
        //if($_REQUEST['usu_pass_leer']=='')
        //	$this->solicitud_prestamo->updateValue("usu_pass_leer", '', $id);
        //if($_REQUEST['usu_nro_item']=='')
        //	$this->solicitud_prestamo->updateValue("usu_nro_item", '', $id);
        //if($_REQUEST['usu_email']=='')
        //	$this->solicitud_prestamo->updateValue("usu_email", '', $id);
        //if($_REQUEST['usu_fono']=='')
        //	$this->solicitud_prestamo->updateValue("usu_fono", '', $id);
        // MODIFIED: CASTELLON
        //if($_REQUEST['usu_nro_item']=='')
        //	$this->solicitud_prestamo->updateValue("usu_nro_item", '', $id);

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
                    $tuse->setUse_fecha_mod(date("Y-m-d"));
                    $tuse->setUse_usu_mod($_SESSION['USU_ID']);
                    $tuse->update();
                } else {
                    //insert
                    $tuse = new tab_usu_serie();
                    $tuse->setUsu_id($id);
                    $tuse->setSer_id($serie);
                    $tuse->setUse_estado('1');
                    $tuse->setUse_fecha_crea(date("Y-m-d"));
                    $tuse->setUse_usu_crea($_SESSION['USU_ID']);
                    $tuse->insert();
                }
            }
        }
        Header("Location: " . PATH_DOMAIN . "/solicitud_prestamo/");
    }

    function delete() {
        $this->solicitud_prestamo = new tab_solicitud_prestamo();
        /* $this->usurolmenu = new Tab_usurolmenu();
          $this->solicitud_prestamo->setRequest2Object($_REQUEST);
          $sql = "UPDATE tab_usurolmenu SET urm_estado='2' Where spr_id='".$_REQUEST['spr_id']."' ";
          $this->usurolmenu->dbselectBySQL($sql); */
        $this->solicitud_prestamo->setUsu_id($_REQUEST['spr_id']);
        $this->solicitud_prestamo->setUsu_estado(2);
        $this->solicitud_prestamo->update();
        $usu_serie = new usu_serie();
        $usu_serie->deleteXsolicitud_prestamo($_REQUEST['spr_id']);
        $usu_uni = new usu_uni();
        $usu_uni->deleteXsolicitud_prestamo($_REQUEST['spr_id']);
    }

    function verificaPass() {
        $solicitud_prestamo = new Tab_solicitud_prestamo();
        $row = $solicitud_prestamo->dbSelectBySQL("SELECT * FROM tab_solicitud_prestamo WHERE
		spr_id='" . $_SESSION['USU_ID'] . "' AND
		usu_pass ='" . md5($_REQUEST['pass_usu']) . "' ");
        if (count($row))
            echo 'OK';
        else
            echo 'Password incorrecto.';
    }

    function listsolicitud_prestamoJson() {
        $this->usu = new solicitud_prestamo();
        echo $this->usu->listsolicitud_prestamoJson();
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

    function obtenerCon() {
        $contenedor = new contenedor();
        $res = $contenedor->selectCon(0, $_REQUEST['Usu_id']);
        echo $res;
    }

}

?>
