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
class lecturaArchivosController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->usu_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "view";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $tmenu = new menu();
        $tliMenu = $tmenu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $tliMenu;

        $this->registry->template->show('header');
        $this->registry->template->show('lecturaArchivosg.tpl');
        $this->registry->template->show('footer');
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $tusuario = new tab_usuario();
        $tusuario->setRequest2Object($_REQUEST);
        $row = $tusuario->dbselectByField("usu_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar Permisos de lectura del Usuario";
        $this->registry->template->usu_id = $row->usu_id;
        $unidad = new unidad();
        $usu = new usuario();
        $datosUsu = $usu->getDatos(VAR3);

        $this->registry->template->unidad = $datosUsu->uni_descripcion;
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
        $this->registry->template->leer_doc = '<option value="1" ' . $selected1 . '>LEER</option><option value="2" ' . $selected2 . '>NO LEER</option>';
        /* 1: POR IMPORTACION, 2: MANUALMENTE */

        $this->registry->template->usuario = $row->usu_nombres . " " . $row->usu_apellidos;

        $tmenu = new menu();
        $liMenu = $tmenu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->show('header');
        $this->registry->template->show('lecturaArchivos.tpl');
        $this->registry->template->show('footer');
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
            elseif ($qtype == 'rol_cod')
                $where = " and rol_id IN (SELECT rol_id FROM tab_rol WHERE rol_cod LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '$query%' ";
        }
        $sql = "SELECT u.usu_id,
                    u.usu_apellidos,
                    u.usu_nombres,
                    u.usu_login,
                    (SELECT
                    su.uni_codigo
                    FROM
                    tab_unidad AS su
                    WHERE su.uni_id=u.uni_id AND su.uni_estado = '1'
                    ) as uni_codigo,
                    IF(u.usu_leer_doc=1,'SI','NO') as usu_leer_doc,
                    (SELECT
                    sr.rol_cod
                    FROM
                    tab_rol AS sr
                    WHERE
                    sr.rol_id=u.rol_id) as rol_cod
                    FROM
                    tab_usuario AS u
                    WHERE
                    u.usu_estado =  1 $where $sort $limit ";
        $result = $this->usuario->dbselectBySQL($sql);
        $total = $usuario->count($qtype, $query);
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
            $json .= ",'" . addslashes($un->uni_codigo) . "'";
            $json .= ",'" . addslashes($un->usu_nombres . " " . $un->usu_apellidos) . "'";
            $json .= ",'" . addslashes($un->usu_login) . "'";
            $json .= ",'" . addslashes($un->usu_leer_doc) . "'";
            $json .= ",'" . addslashes($un->rol_cod) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function update() {
        $this->usuario = new tab_usuario();
        $this->usuario->setRequest2Object($_REQUEST);
        $rows = $this->usuario->dbselectByField("usu_id", $_REQUEST['usu_id']);
        $this->usuario = $rows[0];
        $id = $this->usuario->usu_id;
        $this->usuario->setUsu_id($id);
        $this->usuario->setUsu_leer_doc($_REQUEST['usu_leer_doc']);
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
        $this->usuario->setUsu_estado(1);
        $this->usuario->update();

        if ($_REQUEST['usu_pass_leer'] == '')
            $this->usuario->updateValue("usu_pass_leer", '', $id);

        Header("Location: " . PATH_DOMAIN . "/lecturaArchivos/");
    }

}

?>
