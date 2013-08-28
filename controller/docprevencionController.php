<?php

/**
 * docprevencionController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class docprevencionController Extends baseController {

    function ruta() {
        $docpr = new Tab_docprevencion();
        $ruta = $docpr->dbSelectBySQL("SELECT * FROM tab_docprevencion WHERE dpr_id='" . VAR3 . "' ");
        Header("Location: " . PATH_DOMAIN . "/" . $ruta [0]->dpr_tipo . "/");
    }

    function index() {

        $docpr = new Tab_docprevencion();
        //echo $_SESSION['UNI_ID'];
        /* 		if(VAR2 !=null)
          {
          if(VAR3 !=null){
          $row = $docpr->dbSelectBySQL("SELECT * FROM tab_docprevencion WHERE uni_id='".$_SESSION['UNI_ID']."'
          AND dpr_tipo='".VAR3."' ");
          if(count($row)) Header("Location: ".PATH_DOMAIN."/".VAR3."/index/".$row[0]->dpr_id."/");
          else    Header("Location: ".PATH_DOMAIN."/docprevencion/add/".VAR3."/");
          }
          else 	Header("Location: ".PATH_DOMAIN."/".VAR3."/");
          }
          else
          {
          $this->ver();
          }
          }

          function ver() {
         */

        $this->registry->template->dpr_id = "";
        $this->registry->template->dpr_tipo = "";
        $this->registry->template->uni_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "addIndex";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_docprevenciong.tpl');
    }

    function editar() {
        Header("Location: " . PATH_DOMAIN . "/docprevencion/view/" . $_REQUEST["dpr_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->docprevencion = new tab_docprevencion();
        $this->docprevencion->setRequest2Object($_REQUEST);

        $dpr = $this->docprevencion->dbSelectBySQL("SELECT * FROM tab_docprevencion WHERE dpr_id='" . VAR3 . "' ");
        if(! $dpr){ die("Error del sistema 404"); }
        $tmenu = new tab_menu();
        $tipo = $tmenu->dbSelectBySQL("SELECT men_titulo FROM tab_menu WHERE men_enlace='" . $dpr[0]->dpr_tipo . "' ");

        $row = $this->docprevencion->dbselectByField("dpr_id", VAR3);
        $row = $row[0];
        $this->registry->template->dpr_id = $row->dpr_id;
        $this->registry->template->dpr_tipo = $row->dpr_tipo;
        $this->registry->template->tipo = $tipo[0]->men_titulo;
        $this->registry->template->uni_id = "<option value='1'>TEST</option>";
        $this->registry->template->dpr_fecha_revision = $row->dpr_fecha_revision;
        $this->registry->template->dpr_productor = $row->dpr_productor;
        $this->registry->template->dpr_cargo_productor = $row->dpr_cargo_productor;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "updateIndex";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('header');
        $this->registry->template->show('tab_docprevencion.tpl');
    }

    function load() {

        $user = new usuario();
        $admin = $user->esAdm();
        $objUnidad = new unidad();
        $this->docprevencion = new tab_docprevencion();
        $this->docprevencion->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'dpr_id';
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
            if ($qtype == 'dpr_id')
                $where = " AND $qtype = '$query' ";
            elseif ($qtype == 'unidad')
                $where = " AND uni_id IN (SELECT uni_id FROM tab_unidad WHERE uni_codigo LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        if ($admin) {
            $sql = "SELECT * FROM tab_docprevencion
                        WHERE dpr_estado = 1 $where $sort $limit ";
        } else {
            $sql = "SELECT
                        tab_docprevencion.dpr_id,
                        tab_docprevencion.dpr_tipo,
                        tab_docprevencion.uni_id,
                        tab_docprevencion.dpr_fecha_revision,
                        tab_docprevencion.dpr_productor,
                        tab_docprevencion.dpr_usu_mod,
                        tab_docprevencion.dpr_estado
                        FROM
                        tab_docprevencion
                        WHERE
                        tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "' AND
                        tab_docprevencion.dpr_estado =  '1' $where $sort $limit ";
        }
        $result = $this->docprevencion->dbselectBySQL($sql);

        $doc = new docprevencion();
        $total = $doc->count2($query, $qtype, $admin); //$this->docprevencion->count("dpr_estado",1);
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
            $unidad = $objUnidad->dameDatosUnidad($un->uni_id);
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->dpr_id . "',";
            $json .= "cell:['" . $un->dpr_id . "'";
            $json .= ",'" . addslashes($un->dpr_tipo) . "'";
            $json .= ",'" . addslashes($unidad->uni_codigo) . "'";
            $json .= ",'" . addslashes($un->dpr_fecha_revision) . "'";
            $json .= ",'" . addslashes($un->dpr_productor) . "'";
            $json .= ",'" . addslashes($un->dpr_cargo_productor) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $tmenu = new tab_menu();
        $tipo = $tmenu->dbSelectBySQL("SELECT men_titulo FROM tab_menu WHERE men_enlace='" . VAR3 . "' ");

        $this->registry->template->dpr_id = "";
        $this->registry->template->tipo = $tipo[0]->men_titulo;
        $this->registry->template->dpr_tipo = VAR3;
        $this->registry->template->dpr_fecha_revision = "";
        $this->registry->template->dpr_productor = "";
        $this->registry->template->dpr_cargo_productor = "";

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('header');
        $this->registry->template->show('tab_docprevencion.tpl');
    }

    function addIndex() {

        $this->registry->template->dpr_id = "";
        $this->registry->template->dpr_tipo = VAR3;
        $this->registry->template->dpr_fecha_revision = "";
        $this->registry->template->dpr_productor = "";
        $this->registry->template->dpr_cargo_productor = "";

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('header');
        $this->registry->template->show('tab_docprevencion.tpl');
    }

    function save() {
        $this->docprevencion = new tab_docprevencion();
        $this->docprevencion->setRequest2Object($_REQUEST);

        $fecha = explode("/", $_REQUEST['dpr_fecha_revision']);
        $newFecha = $fecha[2] . "-" . $fecha[0] . "-" . $fecha[1];
        $this->docprevencion->setDpr_id($_REQUEST['dpr_id']);
        $this->docprevencion->setDpr_tipo($_REQUEST['dpr_tipo']);
        $this->docprevencion->setUni_id($_SESSION['UNI_ID']);
        $this->docprevencion->setDpr_fecha_revision($newFecha);
        $this->docprevencion->setDpr_productor($_REQUEST['dpr_productor']);
        $this->docprevencion->setDpr_cargo_productor($_REQUEST['dpr_cargo_productor']);
        $this->docprevencion->setDpr_fecha_crea(date("Y-m-d"));
        $this->docprevencion->setDpr_usu_crea($_SESSION['USU_ID']);
        $this->docprevencion->setDpr_estado(1);

        $id_dpr = $this->docprevencion->insert();

        //Header("Location: ".PATH_DOMAIN."/docprevencion/");
        //Header("Location: ".PATH_DOMAIN."/".$_REQUEST['dpr_tipo']."/index/".$id_dpr."/");


        Header("Location: " . PATH_DOMAIN . "/" . $_REQUEST['dpr_tipo'] . "/");
        return;
    }

    function updateIndex() {
        $this->docprevencion = new tab_docprevencion();
        $this->docprevencion->setRequest2Object($_REQUEST);

        $fecha = explode("/", $_REQUEST['dpr_fecha_revision']);
        $newFecha = $fecha[2] . "-" . $fecha[0] . "-" . $fecha[1];
        //$this->docprevencion->setDpr_id($_REQUEST['dpr_id']);
        $this->docprevencion->setDpr_tipo($_REQUEST['dpr_tipo']);
        $this->docprevencion->setUni_id($_SESSION['UNI_ID']);
        $this->docprevencion->setDpr_fecha_revision($_REQUEST['dpr_fecha_revision']); //($newFecha);
        $this->docprevencion->setDpr_productor($_REQUEST['dpr_productor']);
        $this->docprevencion->setDpr_cargo_productor($_REQUEST['dpr_cargo_productor']);
        $this->docprevencion->setDpr_fecha_mod(date("Y-m-d"));
        $this->docprevencion->setDpr_usu_mod($_SESSION['USU_ID']);
        $this->docprevencion->update();
        Header("Location: " . PATH_DOMAIN . "/docprevencion/");
    }

    function delete() {
        $this->docprevencion = new tab_docprevencion();
        $this->docprevencion->setRequest2Object($_REQUEST);

        $this->docprevencion->setDpr_id($_REQUEST['dpr_id']);
        $this->docprevencion->setDpr_estado(2);
        $this->docprevencion->update();
        $docpr = new Tab_docprevencion();
        $row = $docpr->dbselectByField("dpr_id", $_REQUEST['dpr_id']);
        $objeto = "tab_" . $row[0]->dpr_tipo;
        $datos = new $objeto();
        $tipo = $row[0]->dpr_tipo;
        if ($tipo == "evalriesgos")
            $inicial = "eva";
        if ($tipo == "idenpeligros")
            $inicial = "ide";
        if ($tipo == "plandesastre")
            $inicial = "pla";
        if ($tipo == "progdesastres")
            $inicial = "des";
        //echo "<br>$objeto";		//$reg = $datos->updateValueOne($inicial,'2',"dpr_id",$_REQUEST['dpr_id']);

        $reg = $datos->dbSelectBySQL(" UPDATE tab_" . $tipo . " SET  " . $inicial . "_estado='2' WHERE dpr_id='" . $_REQUEST['dpr_id'] . "' ");
        //$reg = $datos->dbSelectBySQL("UPDATE ".$tipo." SET  ".$inicial."_estado='2' WHERE dpr_id='".$_REQUEST['dpr_id']."' ");
    }

    function verif() {

    }

}

?>
