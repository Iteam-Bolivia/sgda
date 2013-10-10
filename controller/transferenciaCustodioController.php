<?php

/**
 * transferenciaController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class transferenciaCustodioController extends baseController {

    function index() {

        $this->registry->template->trn_id = "";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->trn_descripcion = "";
        $this->registry->template->trn_contenido = "";
        $this->registry->template->trn_uni_origen = "";
        $this->registry->template->trn_uni_destino = "";
        $this->registry->template->trn_confirmado = "";
        $this->registry->template->trn_fecha_crea = "";
        $this->registry->template->trn_usuario_crea = "";
        $this->registry->template->trn_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_transferenciag.tpl');
    }

    function view() {
        $this->transferencia = new tab_transferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);
        $row = $this->transferencia->dbselectByField("trn_id", $_REQUEST ["trn_id"]);
        $row = $row [0];
        $this->registry->template->trn_id = $row->trn_id;
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->trn_descripcion = $row->trn_descripcion;
        $this->registry->template->trn_contenido = $row->trn_contenido;
        $this->registry->template->trn_uni_origen = $row->trn_uni_origen;
        $this->registry->template->trn_uni_destino = $row->trn_uni_destino;
        $this->registry->template->trn_confirmado = $row->trn_confirmado;
        $this->registry->template->trn_fecha_crea = $row->trn_fecha_crea;
        $this->registry->template->trn_usuario_crea = $row->trn_usuario_crea;
        $this->registry->template->trn_estado = $row->trn_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_transferencia.tpl');
    }

    function load() {

        $this->transferencia = new tab_transferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'trn_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query) {
            $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * FROM tab_transferencia $where and trn_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * FROM tab_transferencia WHERE trn_estado = 1 $sort $limit ";
        }
        $result = $this->transferencia->dbselectBySQL($sql);
        $total = $this->transferencia->count("trn_estado", 1);
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
            $json .= "id:'" . $un->trn_id . "',";
            $json .= "cell:['" . $un->trn_id . "'";
            $json .= ",'" . addslashes($un->exp_id) . "'";
            $json .= ",'" . addslashes($un->trn_descripcion) . "'";
            $json .= ",'" . addslashes($un->trn_contenido) . "'";
            $json .= ",'" . addslashes($un->trn_uni_origen) . "'";
            $json .= ",'" . addslashes($un->trn_uni_destino) . "'";
            $json .= ",'" . addslashes($un->trn_confirmado) . "'";
            $json .= ",'" . addslashes($un->trn_fecha_crea) . "'";
            $json .= ",'" . addslashes($un->trn_usuario_crea) . "'";
            $json .= ",'" . addslashes($un->trn_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $this->registry->template->trn_id = "";
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->trn_descripcion = "";
        $this->registry->template->trn_contenido = "";
        $this->registry->template->trn_uni_origen = "";
        $this->registry->template->trn_uni_destino = "";
        $this->registry->template->trn_confirmado = "";
        $this->registry->template->trn_fecha_crea = "";
        $this->registry->template->trn_usuario_crea = "";
        $this->registry->template->trn_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_transferencia.tpl');
    }

    function save() {
        $this->transferencia = new tab_transferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);

        $this->transferencia->setTrn_id = $_REQUEST ['trn_id'];
        $this->transferencia->setExp_id = $_REQUEST ['exp_id'];
        $this->transferencia->setTrn_descripcion = $_REQUEST ['trn_descripcion'];
        $this->transferencia->setTrn_contenido = $_REQUEST ['trn_contenido'];
        $this->transferencia->setTrn_uni_origen = $_REQUEST ['trn_uni_origen'];
        $this->transferencia->setTrn_uni_destino = $_REQUEST ['trn_uni_destino'];
        $this->transferencia->setTrn_confirmado = $_REQUEST ['trn_confirmado'];
        $this->transferencia->setTrn_fecha_crea = $_REQUEST ['trn_fecha_crea'];
        $this->transferencia->setTrn_usuario_crea = $_REQUEST ['trn_usuario_crea'];
        $this->transferencia->setTrn_estado = 1;

        $this->transferencia->insert();
        Header("Location: " . PATH_DOMAIN . "/transferencia/");
    }

    function update() {
        $this->transferencia = new tab_transferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);

        $this->transferencia->setTrn_id = $_REQUEST ['trn_id'];
        $this->transferencia->setExp_id = $_REQUEST ['exp_id'];
        $this->transferencia->setTrn_descripcion = $_REQUEST ['trn_descripcion'];
        $this->transferencia->setTrn_contenido = $_REQUEST ['trn_contenido'];
        $this->transferencia->setTrn_uni_origen = $_REQUEST ['trn_uni_origen'];
        $this->transferencia->setTrn_uni_destino = $_REQUEST ['trn_uni_destino'];
        $this->transferencia->setTrn_confirmado = $_REQUEST ['trn_confirmado'];
        $this->transferencia->setTrn_fecha_crea = $_REQUEST ['trn_fecha_crea'];
        $this->transferencia->setTrn_usuario_crea = $_REQUEST ['trn_usuario_crea'];
        $this->transferencia->setTrn_estado = $_REQUEST ['trn_estado'];

        $this->transferencia->update();
        Header("Location: " . PATH_DOMAIN . "/transferencia/");
    }

    function delete() {
        $this->transferencia = new tab_transferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);

        $this->transferencia->setTrn_id($_REQUEST ['trn_id']);
        $this->transferencia->setTrn_estado(2);

        $this->transferencia->update();
    }

    function verif() {

    }

}

?>
