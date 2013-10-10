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
class tramoController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->trm_id = "";
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
        $this->registry->template->show('tab_tramog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $tramo = new tramo();
        $unidad = new unidad();

        $this->tramo = new tab_tramo();
        $this->tramo->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'trm_id';
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
            if ($qtype == 'trm_id')
                $where = " and trm_id = '$query' ";
            elseif ($qtype == 'proy_nombre')
                $where = " and pry_id IN (SELECT pry_id FROM tab_proyecto WHERE rol_nombre LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '$query%' ";
        }
        $sql = "SELECT
                    tab_tramo.trm_id,
                    tab_proyecto.pry_nombre,
                    tab_tramo.trm_codigo,
                    tab_tramo.trm_nombre,
                    tab_tramo.trm_estado
                    FROM
                    tab_tramo
                    INNER JOIN tab_proyecto ON tab_proyecto.pry_id = tab_tramo.pry_id
                    WHERE tab_tramo.trm_estado = 1 $where $sort $limit";

        $result = $this->tramo->dbselectBySQL($sql);
        $total = $tramo->count($where);
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
            $json .= "id:'" . $un->trm_id . "',";
            $json .= "cell:['" . $un->trm_id . "'";
            $json .= ",'" . addslashes($un->pry_nombre) . "'";
            $json .= ",'" . addslashes($un->trm_codigo) . "'";
            $json .= ",'" . addslashes($un->trm_nombre) . "'";
            $json .= ",'" . addslashes($un->trm_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/tramo/view/" . $_REQUEST["trm_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->tramo = new tab_tramo();
        $this->tramo->setRequest2Object($_REQUEST);
        $row = $this->tramo->dbselectByField("trm_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar tramo";
        $this->registry->template->trm_id = $row->trm_id;
        $this->registry->template->mod_login = " disabled=\"disabled\"";

        $proyecto = new proyecto();
        $this->registry->template->pry_id = $proyecto->obtenerSelect($row->pry_id);
        $this->registry->template->trm_codigo = $row->trm_codigo;
        $this->registry->template->trm_nombre = $row->trm_nombre;
        $this->registry->template->trm_estado = $row->trm_estado;

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
        $this->registry->template->show('tab_tramo.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $proyecto = new proyecto();
        $this->registry->template->titulo = "Nuevo tramo";

        $this->registry->template->pry_id = $proyecto->obtenerSelect();
        $this->registry->template->trm_id = "";
        $this->registry->template->trm_codigo = "";
        $this->registry->template->trm_nombre = "";

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
        $this->registry->template->show('tab_tramo.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->tramo = new tab_tramo();
        $userLogin = new tramo();
        $this->tramo->setRequest2Object($_REQUEST);
        $this->tramo->setTrm_id($_REQUEST['trm_id']);
        $this->tramo->setPry_id($_REQUEST['pry_id']);
        $this->tramo->setTrm_codigo($_REQUEST['trm_codigo']);
        $this->tramo->setTrm_nombre($_REQUEST['trm_nombre']);
        $this->tramo->settrm_estado(1);
        $trm_id = $this->tramo->insert();

        Header("Location: " . PATH_DOMAIN . "/tramo/");
    }

    function update() {
        $this->tramo = new tab_tramo();
        $this->tramo->setRequest2Object($_REQUEST);
//        $rol = new rol();
//        $this->registry->template->roles = $rol->obtenerSelectRoles();
        $rows = $this->tramo->dbselectByField("trm_id", $_REQUEST['trm_id']);
        $this->tramo = $rows[0];
        $id = $this->tramo->trm_id;

        $this->tramo->setTrm_id($_REQUEST['trm_id']);
        $this->tramo->setPry_id($_REQUEST['pry_id']);
        $this->tramo->setTrm_codigo($_REQUEST['trm_codigo']);
        $this->tramo->setTrm_nombre($_REQUEST['trm_nombre']);
        $this->tramo->settrm_estado(1);
        $this->tramo->update();

        Header("Location: " . PATH_DOMAIN . "/tramo/");
    }

    function delete() {
        $this->tramo = new tab_tramo();
        $this->tramo->settrm_id($_REQUEST['trm_id']);
        $this->tramo->settrm_estado(2);
        $this->tramo->update();
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

}

?>
