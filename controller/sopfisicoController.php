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
class sopfisicoController Extends baseController {

    function index() {
        $this->registry->template->sof_id = "";
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
        $this->registry->template->show('tab_sopfisicog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $sopfisico = new sopfisico();
        $this->sopfisico = new tab_sopfisico();
        $this->sopfisico->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'sof_id';
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
            if ($qtype == 'sof_id')
                $where = " and sof_id = '$query' ";
            else
                $where = " AND $qtype LIKE '$query%' ";
        }
        $sql = "SELECT *
                 FROM tab_sopfisico AS u
                 WHERE u.sof_estado =  1 $where $sort $limit";

        $result = $this->sopfisico->dbselectBySQL($sql);
        $total = $sopfisico->count($where);
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
            $json .= "id:'" . $un->sof_id . "',";
            $json .= "cell:['" . $un->sof_id . "'";
            $json .= ",'" . addslashes($un->sof_codigo) . "'";
            $json .= ",'" . addslashes($un->sof_nombre) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/sopfisico/view/" . $_REQUEST["sof_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->sopfisico = new tab_sopfisico();
        $this->sopfisico->setRequest2Object($_REQUEST);
        $row = $this->sopfisico->dbselectByField("sof_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar sopfisico";
        $this->registry->template->sof_id = $row->sof_id;
        $this->registry->template->sof_codigo = $row->sof_codigo;
        $this->registry->template->sof_nombre = $row->sof_nombre;
        $this->registry->template->sof_estado = $row->sof_estado;

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
        $this->registry->template->show('tab_sopfisico.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $this->registry->template->titulo = "Nuevo sopfisico";
        $this->registry->template->sof_id = "";
        $this->registry->template->sof_codigo = "";
        $this->registry->template->sof_nombre = "";
        $this->registry->template->sof_estado = "";
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
        $this->registry->template->show('tab_sopfisico.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->sopfisico = new tab_sopfisico();
        $this->sopfisico->setRequest2Object($_REQUEST);
        $this->sopfisico->setSof_id($_REQUEST['sof_id']);
        $this->sopfisico->setSof_codigo($_REQUEST['sof_codigo']);
        $this->sopfisico->setSof_nombre($_REQUEST['sof_nombre']);
        $this->sopfisico->setSof_estado(1);
        $sof_id = $this->sopfisico->insert();
        Header("Location: " . PATH_DOMAIN . "/sopfisico/");
    }

    function update() {
        $this->sopfisico = new tab_sopfisico();
        $this->sopfisico->setRequest2Object($_REQUEST);
        $rows = $this->sopfisico->dbselectByField("sof_id", $_REQUEST['sof_id']);
        $this->sopfisico = $rows[0];
        $id = $this->sopfisico->sof_id;
        $this->sopfisico->setSof_id($_REQUEST['sof_id']);
        $this->sopfisico->setSof_codigo($_REQUEST['sof_codigo']);
        $this->sopfisico->setSof_nombre($_REQUEST['sof_nombre']);
        $this->sopfisico->setSof_estado(1);

        $this->sopfisico->update();
        Header("Location: " . PATH_DOMAIN . "/sopfisico/");
    }

    function delete() {
        $this->sopfisico = new tab_sopfisico();
        $this->sopfisico->setSof_id($_REQUEST['sof_id']);
        $this->sopfisico->setSof_estado(2);
        $this->sopfisico->update();
    }

    function verifyFields() {
        function verifyFields() {
        $sopfisico = new sopfisico();
        $sof_codido = trim($_POST['sof_codigo']);
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
            if ($sopfisico->existeCodigo($sof_codido)) {
                echo 'El código ya existe, escriba otro.';
            }
            //if (strlen($uni_codigo) < 2 || strlen($uni_codigo) > 2) {
            //    echo 'El tamaño debe de ser igual a 2.';
            //} 
            else {
                echo '';
            }
            } else {
                echo '';
            }
        }
    }

}

?>
