<?php

/**
 * contenedorController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class contenUsuarioController Extends baseController {

    function index() {
        $this->registry->template->con_id = "";
        $this->registry->template->adm = false;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_CONTROLADOR = 'contenUsuario';
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_contenedorg.tpl');
    }

    function edit() {
        header("Location: " . PATH_DOMAIN . "/contenUsuario/view/" . $_REQUEST["con_id"] . "/");
    }

    function view() {
        $this->contenedor = new tab_contenedor();
        $row = $this->contenedor->dbselectByField("con_id", VAR3);
        $row = $row[0];
        $this->registry->template->con_id = $row->con_id;
        $contenedor = new contenedor();
        $this->registry->template->tipo_contenedores = $contenedor->obtenerTiposContenedor($row->ctp_id);
        $this->registry->template->con_codigo = $row->con_codigo;
        $usuario = new usuario();
        $this->registry->template->usuario = $usuario->obtenerNombre($row->usu_id);
        $this->registry->template->usu_id = $row->usu_id;
        $this->registry->template->adm = false;
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_CONTROLADOR = 'contenUsuario';
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_contenedor.tpl');
    }

    function load() {
        $usu = new usuario();
        $adm = $usu->esAdm();
        $this->contenedor = new tab_contenedor();
        $this->contenedor->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'con_id';
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
        $usuario_id = $_SESSION['USU_ID'];
        $where = "";
        if ($query) {
            if ($qtype == 'con_id')
                $where = " AND c.$qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT
            tc.ctp_codigo,
            c.con_codigo,
            c.con_id,
            (SELECT uni_codigo FROM tab_unidad WHERE uni_id=u.uni_id ) as uni_codigo,
            (u.usu_nombres || ' ' || u.usu_apellidos) AS usu_nomape
            FROM
            tab_contenedor AS c
            Inner Join tab_tipocontenedor AS tc ON tc.ctp_id = c.ctp_id
            Inner Join tab_usuario AS u ON c.usu_id = u.usu_id
            WHERE
            c.con_estado =  '1' AND  c.usu_id =  '" . $usuario_id . "' $where $sort $limit";

        $result = $this->contenedor->dbselectBySQL($sql);
        $conten = new contenedor();
        $total = $conten->countUsu($qtype, $query, $usuario_id);
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
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->con_id . "',";
            $json .= "cell:['" . $un->con_id . "'";
            $json .= ",'" . addslashes($un->ctp_codigo) . "'";
            $json .= ",'" . addslashes($un->con_codigo) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $contenedor = new contenedor();

        $this->registry->template->con_id = "";
        $this->registry->template->tipo_contenedores = $contenedor->obtenerTiposContenedor("");
        $this->registry->template->con_codigo = "";
        $usuario = new usuario();
        $this->registry->template->usuario = $usuario->obtenerNombre($_SESSION['USU_ID']);
        $this->registry->template->usu_id = $_SESSION['USU_ID'];
        $this->registry->template->adm = false;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_CONTROLADOR = 'contenUsuario';
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('header');
        $this->registry->template->show('tab_contenedor.tpl');
    }

    function save() {
        $this->contenedor = new tab_contenedor();
        $this->contenedor->setRequest2Object($_REQUEST);

        $this->contenedor->setCon_usu_reg($_SESSION['USU_ID']);
        $this->contenedor->setCon_fecha_reg(date("Y-m-d"));
        $this->contenedor->setCon_estado(1);

        $this->contenedor->insert();
        Header("Location: " . PATH_DOMAIN . "/contenedor/");
    }

    function update() {
        $this->contenedor = new tab_contenedor();
        $this->contenedor->setRequest2Object($_REQUEST);
        $this->contenedor->setCon_usu_mod($_SESSION['USU_ID']);
        $this->contenedor->setCon_fecha_mod(date("Y-m-d"));
        $this->contenedor->update();
        Header("Location: " . PATH_DOMAIN . "/contenedor/");
    }

    function delete() {
        $this->contenedor = new tab_contenedor();
        $this->contenedor->setRequest2Object($_REQUEST);

        $this->contenedor->setCon_id($_REQUEST['con_id']);
        $this->contenedor->setCon_estado(2);

        $this->contenedor->update();
    }

}

?>
