<?php

/**
 * archivoController
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class exp_nurController Extends baseController {

    function index() {
//verifica si es superadministrador para mostrar add y delete
        $this->registry->template->exn_id = "";
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
        $this->registry->template->show('tab_exp_nurg.tpl');
        $this->registry->template->show('footer');
    }

//    function edit() {
//        Header("Location: " . PATH_DOMAIN . "/exp_nur/view/" . $_REQUEST["exn_id"] . "/");
//    }
//    function view() {
//        $this->exp_nur = new tab_exp_nur();
//        $this->exp_nur->setRequest2Object($_REQUEST);
//        $row = $this->exp_nur->dbselectByField("exn_id", VAR3);
//        $row = $row[0];
//
//        $this->registry->template->titulo = "Editar ";
//        $this->registry->template->exn_id = $row->exn_id;
//        $this->registry->template->exn_nombre = $row->exn_nombre;
//        $this->registry->template->exn_codigo = $row->exn_codigo;
//
//        $this->menu = new menu();
//        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
//        $this->registry->template->men_titulo = $this->liMenu;
//
//        $this->registry->template->PATH_WEB = PATH_WEB;
//        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
//        $this->registry->template->PATH_EVENT = "update";
//        $this->registry->template->PATH_J = "jquery";
//        $this->registry->template->GRID_SW = "true";
//        $this->registry->template->FORM_SW = "";
//        $this->registry->template->show('headerF');
//        $this->registry->template->show('tab_exp_nur.tpl');
//        $this->registry->template->show('footer');
//    }

    function load() {
        $exp_nur = new exp_nur();
        $this->exp_nur = new tab_exp_nur();
        $this->exp_nur->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'exn_id';
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
            if ($qtype == 'exn_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        $sql = "SELECT * FROM tab_exp_nur
                 WHERE exn_estado =  1 $where $sort $limit";

        $result = $this->exp_nur->dbselectBySQL($sql);
        $total = $exp_nur->count($where);
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
            $json .= "id:'" . $un->exn_id . "',";
            $json .= "cell:['" . $un->exn_id . "'";
            $json .= ",'" . addslashes($un->exn_user) . "'";
            $json .= ",'" . addslashes($un->exn_nur) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

//    function add() {
//        $this->registry->template->titulo = "Nuevo exp_nur";
//
//        $this->registry->template->exn_id = "";
//        $this->registry->template->exn_nombre = "";
//        $this->registry->template->exn_codigo = "";
//
//        $this->menu = new menu();
//        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
//        $this->registry->template->men_titulo = $this->liMenu;
//
//        $this->registry->template->PATH_WEB = PATH_WEB;
//        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
//        $this->registry->template->PATH_EVENT = "save";
//        $this->registry->template->GRID_SW = "true";
//        $this->registry->template->FORM_SW = "";
//        $this->registry->template->PATH_J = "jquery-1.4.1";
//        $this->registry->template->show('headerF');
//        $this->registry->template->show('tab_exp_nur.tpl');
//        $this->registry->template->show('footer');
//    }
//    function save() {
//        $this->exp_nur = new tab_exp_nur();
//        $this->exp_nur->setRequest2Object($_REQUEST);
//
//        $this->exp_nur->setexn_id($_REQUEST['exn_id']);
//        $this->exp_nur->setexn_codigo($_REQUEST['exn_codigo']);
//        $this->exp_nur->setexn_nombre($_REQUEST['exn_nombre']);
//        $this->exp_nur->setexn_estado(1);
//
//        $exn_id = $this->exp_nur->insert();
//
//        Header("Location: " . PATH_DOMAIN . "/exp_nur/");
//    }
//    function update() {
//        $this->exp_nur = new tab_exp_nur();
//        $this->exp_nur->setRequest2Object($_REQUEST);
//
//        $rows = $this->exp_nur->dbselectByField("exn_id", $_REQUEST['exn_id']);
//        $this->exp_nur = $rows[0];
//        $id = $this->exp_nur->exn_id;
//
//        $this->exp_nur->setexn_id($_REQUEST['exn_id']);
//        $this->exp_nur->setexn_codigo($_REQUEST['exn_codigo']);
//        $this->exp_nur->setexn_nombre($_REQUEST['exn_nombre']);
//        $this->exp_nur->setexn_estado(1);
//
//        $this->exp_nur->update();
//
//        Header("Location: " . PATH_DOMAIN . "/exp_nur/");
//    }



    function delete() {

        $this->exp_nur = new tab_exp_nur();

        $this->exp_nur->setexn_id($_REQUEST['exn_id']);
        $this->exp_nur->setexn_estado(0);
        $this->exp_nur->update();
    }

    function selecNur() {
        $exn_id = $_REQUEST['Exn_id'];
        $exp_nur = new exp_nur();
        if ($exp_nur->obtenerNur($exn_id)) {
            $_SESSION['NUR'] = $exp_nur->obtenerNur($exn_id);
            echo "";
        } else {
            echo "se obtubo nur con exito...";
        }
    }

}

?>
