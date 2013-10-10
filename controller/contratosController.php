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
class contratosController Extends baseController {

    function index() {
        //$this->contratos = new tab_contratos();
        //$this->contratos->setRequest2Object($_REQUEST);
        //$exp_id = $_REQUEST['exp_id'];
        $exp_id = "";

        $this->registry->template->ctt_id = "";
        $this->registry->template->exp_id = $exp_id;
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
        $this->registry->template->show('tab_contratosg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        //$unidad = new unidad();

        $contratos = new contratos();
        $this->contratos = new tab_contratos();
        $this->contratos->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        //$exp_id = $_REQUEST['exp_id'];
        if (!$sortname)
            $sortname = 'exp_id';
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
        //$where = " WHERE exp_id = '$exp_id' ";

        /*
          if ($query){
          if($qtype=='usu_id')
          $where = " and usu_id = '$query' ";
          elseif($qtype=='usu_leer_doc'){
          if(strtolower($query)=='s' || strtolower($query)=='si')
          $where = " and usu_leer_doc = '1' ";
          if(strtolower($query)=='n' || strtolower($query)=='no')
          $where = " and usu_leer_doc = '2' ";
          }elseif($qtype=='unidad')
          $where = " and uni_id IN (SELECT uni_id FROM tab_unidad WHERE uni_codigo LIKE '%$query%') ";
          elseif($qtype=='rol_cod')
          $where = " and rol_id IN (SELECT rol_id FROM tab_rol WHERE rol_cod LIKE '%$query%') ";
          else
          $where = " AND $qtype LIKE '$query%' ";
          }
         */

        $sql = "SELECT public.tab_contratos.ctt_id, public.tab_contratos.exp_id, public.tab_contratos.ctt_codigo, public.tab_contratos.ctt_descripcion, public.tab_contratos.ctt_proveedor, public.tab_contratos.ctt_gestion, public.tab_contratos.ctt_cite, public.tab_contratos.ctt_precbasrefunit, public.tab_contratos.ctt_fecha, public.tab_unidad.uni_descripcion, public.tab_tiposolicitud.sol_descripcion, public.tab_modalidad.mod_descripcion, public.tab_fuentefinanciamiento.ff_descripcion
		FROM public.tab_contratos Inner Join public.tab_fuentefinanciamiento ON public.tab_fuentefinanciamiento.ff_id = public.tab_contratos.ff_id Inner Join public.tab_modalidad ON public.tab_modalidad.mod_id = public.tab_contratos.mod_id Inner Join public.tab_tiposolicitud ON public.tab_tiposolicitud.sol_id = public.tab_contratos.sol_id Inner Join public.tab_unidad ON public.tab_unidad.uni_id = public.tab_contratos.uni_id $sort $limit";


        /*
          $sql = "SELECT u.usu_id, u.usu_apellidos, u.usu_nombres, u.usu_login, u.usu_fono, u.usu_email, u.usu_nro_item,
          (SELECT su.uni_codigo FROM tab_unidad AS su WHERE su.uni_id=u.uni_id AND su.uni_estado = '1' ) as uni_codigo,
          (CASE (u.usu_leer_doc) WHEN 1 THEN 'SI' WHEN 2 THEN 'NO' END) as usu_leer_doc,
          (CASE (u.usu_crear_doc) WHEN 1 THEN 'SI' WHEN 2 THEN 'NO' END) as creado_x_import,
          (SELECT sr.rol_cod FROM tab_rol AS sr WHERE sr.rol_id=u.rol_id) as rol_cod
          FROM tab_usuario AS u
          WHERE u.usu_estado =  1 $where $sort $limit";
         */

        $result = $this->contratos->dbselectBySQL($sql);
        $total = $contratos->count($where);

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
            $json .= "id:'" . $un->ctt_id . "',";
            $json .= "cell:['" . $un->ctt_id . "'";
            $json .= ",'" . addslashes($un->exp_id) . "'";
            $json .= ",'" . addslashes($un->ctt_codigo) . "'";
            //$json .= ",'".addslashes($un->ctt_detalle)."'";
            $json .= ",'" . addslashes($un->ctt_descripcion) . "'";
            $json .= ",'" . addslashes($un->ctt_proveedor) . "'";
            $json .= ",'" . addslashes($un->ctt_gestion) . "'";
            $json .= ",'" . addslashes($un->ctt_cite) . "'";
            $json .= ",'" . addslashes($un->ctt_precbasrefunit) . "'";
            $json .= ",'" . addslashes($un->ctt_fecha) . "'";
            $json .= ",'" . addslashes($un->uni_descripcion) . "'";
            $json .= ",'" . addslashes($un->sol_descripcion) . "'";
            $json .= ",'" . addslashes($un->mod_descripcion) . "'";
            $json .= ",'" . addslashes($un->ff_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->contratos = new tab_contratos();
        $this->contratos->setRequest2Object($_REQUEST);
        $row = $this->contratos->dbselectByField("ctt_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $this->registry->template->titulo = "Editar Usuario";
        $this->registry->template->ctt_id = $row->ctt_id;
        $this->registry->template->mod_login = " disabled=\"disabled\"";

        $expediente = new expediente();
        $this->registry->template->exp_id = $expediente->listExpediente(0, $row->exp_id);

        $this->registry->template->ctt_codigo = $row->ctt_codigo;
        $this->registry->template->ctt_detalle = $row->ctt_detalle;
        $this->registry->template->ctt_descripcion = $row->ctt_descripcion;
        $this->registry->template->ctt_proveedor = $row->ctt_proveedor;
        $this->registry->template->ctt_gestion = $row->ctt_gestion;
        $this->registry->template->ctt_cite = $row->ctt_cite;
        $this->registry->template->ctt_precbasrefunit = $row->ctt_precbasrefunit;
        $this->registry->template->ctt_fecha = $row->ctt_fecha;


        $unidad = new unidad();
        $this->registry->template->uni_id = $unidad->obtenerSelect($row->uni_id);

        $tiposolicitud = new tiposolicitud();
        $this->registry->template->sol_id = $tiposolicitud->obtenerSelect($row->sol_id);

        $modalidad = new modalidad();
        $this->registry->template->mod_id = $modalidad->obtenerSelect($row->mod_id);

        $fuentefinanciamiento = new fuentefinanciamiento();
        $this->registry->template->ff_id = $fuentefinanciamiento->obtenerSelect($row->ctt_id);

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
        $this->registry->template->show('tab_contratos.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $this->registry->template->titulo = "Nuevo Contrato";

        $unidad = new unidad();
        $this->registry->template->uni_id = $unidad->listUnidad(0);

        $expediente = new expediente();
        $this->registry->template->exp_id = $expediente->listExpediente(0);

        $this->registry->template->ctt_id = "";
        $this->registry->template->ctt_codigo = "";
        $this->registry->template->ctt_detalle = "";
        $this->registry->template->ctt_descripcion = "";
        $this->registry->template->ctt_proveedor = "";
        $this->registry->template->ctt_gestion = "";
        $this->registry->template->ctt_cite = "";
        $this->registry->template->ctt_precbasrefunit = "";
        $this->registry->template->ctt_fecha = "";
        /**/
        $tiposolicitud = new tiposolicitud();
        //$this->registry->template->sol_id = $tiposolicitud->listTipoSolicitud(0);
        $this->registry->template->sol_id = $tiposolicitud->obtenerSelect(0);


        $modalidad = new modalidad();
        $this->registry->template->mod_id = $modalidad->obtenerSelect(0);

        $fuentefinanciamiento = new fuentefinanciamiento();
        $this->registry->template->ff_id = $fuentefinanciamiento->obtenerSelect(0);

        /**/

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
        $this->registry->template->show('tab_contratos.tpl');
        $this->registry->template->show('footer');
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/contratos/view/" . $_REQUEST["ctt_id"] . "/");
    }

    function save() {
        $this->contratos = new tab_contratos();
        $this->contratos->setRequest2Object($_REQUEST);
        $this->contratos->setCtt_id($_REQUEST['ctt_id']);
        $this->contratos->setCtt_codigo($_REQUEST['ctt_codigo']);
        $this->contratos->setCtt_detalle($_REQUEST['ctt_detalle']);
        $this->contratos->setCtt_descripcion($_REQUEST['ctt_descripcion']);
        $this->contratos->setCtt_proveedor($_REQUEST['ctt_proveedor']);
        $this->contratos->setCtt_gestion($_REQUEST['ctt_gestion']);
        $this->contratos->setCtt_cite($_REQUEST['ctt_cite']);
        $this->contratos->setCtt_precbasrefunit($_REQUEST['ctt_precbasrefunit']);
        $this->contratos->setCtt_fecha($_REQUEST['ctt_fecha']);
        $this->contratos->setUni_id($_REQUEST['uni_id']);
        $this->contratos->setSol_id($_REQUEST['sol_id']);
        $this->contratos->setMod_id($_REQUEST['mod_id']);
        $this->contratos->setFF_id($_REQUEST['ff_id']);
        $this->contratos->setExp_id($_REQUEST['exp_id']);
        $this->contratos->setCtt_fecha_crea(date("Y-m-d"));
        $this->contratos->setCtt_usuario_crea($_SESSION['USU_ID']);
        $this->contratos->setCtt_estado(1);
        $ctt_id = $this->contratos->insert();

        Header("Location: " . PATH_DOMAIN . "/contratos/");
    }

    function update() {
        $this->contratos = new tab_contratos();
        $this->contratos->setRequest2Object($_REQUEST);
        $rows = $this->contratos->dbselectByField("ctt_id", $_REQUEST['ctt_id']);
        $this->contratos = $rows[0];
        $id = $this->contratos->ctt_id;

        $this->contratos->setCtt_id($_REQUEST['ctt_id']);
        $this->contratos->setCtt_codigo($_REQUEST['ctt_codigo']);
        $this->contratos->setCtt_detalle($_REQUEST['ctt_detalle']);
        $this->contratos->setCtt_descripcion($_REQUEST['ctt_descripcion']);
        $this->contratos->setCtt_proveedor($_REQUEST['ctt_proveedor']);
        $this->contratos->setCtt_gestion($_REQUEST['ctt_gestion']);
        $this->contratos->setCtt_cite($_REQUEST['ctt_cite']);
        $this->contratos->setCtt_precbasrefunit($_REQUEST['ctt_precbasrefunit']);
        $this->contratos->setCtt_fecha($_REQUEST['ctt_fecha']);
        $this->contratos->setUni_id($_REQUEST['uni_id']);
        $this->contratos->setSol_id($_REQUEST['sol_id']);
        $this->contratos->setMod_id($_REQUEST['mod_id']);
        $this->contratos->setFF_id($_REQUEST['ff_id']);
        $this->contratos->setExp_id($_REQUEST['exp_id']);
        $this->contratos->setCtt_fecha_mod(date("Y-m-d"));
        $this->contratos->setCtt_usuario_mod($_SESSION['USU_ID']);
        $this->contratos->setCtt_estado(1);
        $this->contratos->update();

        Header("Location: " . PATH_DOMAIN . "/contratos/");
    }

    function delete() {
        $this->contratos = new tab_contratos();
        /* $this->usurolmenu = new Tab_usurolmenu();
          $this->usuario->setRequest2Object($_REQUEST);
          $sql = "UPDATE tab_usurolmenu SET urm_estado='2' Where usu_id='".$_REQUEST['usu_id']."' ";
          $this->usurolmenu->dbselectBySQL($sql); */
        $this->contratos->setCtt_id($_REQUEST['ctt_id']);
        $this->contratos->setCtt_estado(2);
        $this->contratos->update();
    }

    /* GARBAGE */

    function listUsuarioJson() {
        $this->usu = new usuario();
        echo $this->usu->listUsuarioJson();
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

}

?>
