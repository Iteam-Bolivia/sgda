<?php

/**
 * archivoController
 *
 * @package
 * @author lic. arsenio castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class empresas_extController Extends baseController {

    function index() {
        $unidad = new unidad();
        $this->registry->template->emp_id = "";
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
        $this->registry->template->show('tab_empresas_extg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $empresas_ext = new empresas_ext();
        //$unidad = new unidad();
        $this->empresas_ext = new tab_empresas_ext();
        $this->empresas_ext->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'emp_id';
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
        $sql = "SELECT * FROM tab_empresas_ext AS m
                 WHERE m.emp_estado = 1 $where $sort $limit";
        $result = $this->empresas_ext->dbselectBySQL($sql);
        $total = $empresas_ext->count($where);
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
            $json .= "id:'" . $un->emp_id . "',";
            $json .= "cell:['" . $un->emp_id . "'";
            $json .= ",'" . addslashes($un->emp_nombre) . "'";
            $json .= ",'" . addslashes($un->emp_sigla) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/empresas_ext/view/" . $_REQUEST["emp_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->empresas_ext = new tab_empresas_ext();
        $this->empresas_ext->setRequest2Object($_REQUEST);
        $row = $this->empresas_ext->dbselectByField("emp_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $this->registry->template->titulo = "Editar Empresas Externas";
        $this->registry->template->emp_id = $row->emp_id;
        $this->registry->template->emp_nombre = $row->emp_nombre;
        $this->registry->template->emp_sigla = $row->emp_sigla;

        /*
          if($row->emp_sigla){
          $this->registry->template->emp_sigla = $row->emp_sigla;
          }else{
          $this->registry->template->emp_sigla = "<input name='emp_sigla' type='text' id='emp_sigla'	value='".$row->emp_sigla."' class='required alpha' maxlength='2'	size='25' autocomplete='off' title='Codigo' />";
          }
         */

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
        $this->registry->template->show('tab_empresas_ext.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $this->registry->template->titulo = "Nueva Empresa Externa";
        $this->registry->template->emp_id = "";
        $this->registry->template->emp_nombre = "";
        $this->registry->template->emp_sigla = "";

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
        $this->registry->template->show('tab_empresas_ext.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->empresas_ext = new tab_empresas_ext();
        $this->empresas_ext->setRequest2Object($_REQUEST);
        $this->empresas_ext->setEmp_id($_REQUEST['emp_id']);
        $this->empresas_ext->setEmp_nombre($_REQUEST['emp_nombre']);
        $this->empresas_ext->setEmp_sigla($_REQUEST['emp_sigla']);
        $this->empresas_ext->setEmp_estado(1);
        $emp_id = $this->empresas_ext->insert();
        Header("Location: " . PATH_DOMAIN . "/empresas_ext/");
    }

    function update() {
        $this->empresas_ext = new tab_empresas_ext();
        $this->empresas_ext->setRequest2Object($_REQUEST);
        $rows = $this->empresas_ext->dbselectByField("emp_id", $_REQUEST['emp_id']);
        $this->empresas_ext = $rows[0];
        $id = $this->empresas_ext->emp_id;
        $this->empresas_ext->setEmp_id($_REQUEST['emp_id']);
        $this->empresas_ext->setEmp_nombre($_REQUEST['emp_nombre']);
        $this->empresas_ext->setEmp_sigla($_REQUEST['emp_sigla']);
        $this->empresas_ext->setEmp_estado(1);
        $this->empresas_ext->update();

        Header("Location: " . PATH_DOMAIN . "/empresas_ext/");
    }

    function delete() {
        $this->empresas_ext = new tab_empresas_ext();
        $this->empresas_ext->setEmp_id($_REQUEST['emp_id']);
        $this->empresas_ext->setEmp_estado(2);
        $this->empresas_ext->update();
    }

    function listUsuarioJson() {
        $this->usu = new empresas_ext();
        echo $this->usu->listUsuarioJson();
    }

}

?>
