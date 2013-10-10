<?php

/**
 * expcampoController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expcampoController extends baseController {

    function index() {
        $this->series = new tab_series();
        $sql = "SELECT 
                ser_categoria 
                FROM tab_series 
                WHERE ser_id = " . VAR3;
        $resul = $this->series->dbselectBySQL($sql);
        if (count($resul))
            $codigo = $resul[0]->ser_categoria;
        else
            $codigo = "";
        $this->registry->template->ecp_id = "";
        $this->registry->template->ser_categoria = $codigo;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_expcampog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $expcampo = new expcampo();
        $this->expcampo = new tab_expcampo ();
        $this->expcampo->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ecp_id';
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
            if ($qtype == 'ecp_id')
                $where = " where $qtype = '$query' ";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT *
                                FROM tab_expcampo
                                $where and ecp_estado = 1 $sort $limit";
        } else {
            if (VAR3!=""){               
               $sql = "SELECT
                    tab_series.ser_id,
                    tab_expcampo.ecp_id,
                    tab_expcampo.ecp_orden,
                    tab_expcampo.ecp_nombre,
                    tab_expcampo.ecp_eti,
                    tab_expcampo.ecp_tipdat,
                    tab_expcampo.ecp_estado
                    FROM
                    tab_series
                    INNER JOIN tab_expcampo ON tab_expcampo.ser_id = tab_series.ser_id
                    WHERE tab_series.ser_id = " . VAR3 . " 
                    AND tab_expcampo.ecp_estado = 1 $sort $limit";                
            }else{
                $sql = "SELECT *
                        FROM tab_expcampo
                        WHERE ecp_estado = 1 $sort $limit";                
            }
        }
        $result = $this->expcampo->dbselectBySQL($sql);
        
        //$total = $expcampo->count($qtype, $query);
        $total = $expcampo->count2($where, VAR3);
        /* header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
          header ( "Cache-Control: no-cache, must-revalidate" );
          header ( "Pragma: no-cache" ); */
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
            $json .= "id:'" . $un->ecp_id . "',";
            $json .= "cell:['" . $un->ecp_id . "'";
            $json .= ",'" . addslashes($un->ecp_orden) . "'";
            $json .= ",'" . addslashes($un->ecp_nombre) . "'";
            $json .= ",'" . addslashes($un->ecp_eti) . "'";
            $json .= ",'" . addslashes($un->ecp_tipdat) . "'";
            $json .= ",'" . addslashes($un->ecp_estado) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/expcampo/view/" . $_REQUEST["ecp_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $expcampo = new expcampo();
        $ser_categoria = "";
        $this->expcampo = new tab_expcampo();
        $sql = "SELECT * 
                FROM tab_expcampo 
                WHERE ecp_id = " . VAR3;
        $resul = $this->expcampo->dbselectBySQL($sql);
        
        if(! $resul){ die("Error del sistema 404"); }
        
        if (count($resul)){
            $ser_id = $resul[0]->ser_id;
            $series = new series();
            $ser_categoria = $series->getTitle($ser_id);                        
        }else
            $ser_id = "";        
        
        $this->expcampo->setRequest2Object($_REQUEST);
        $ecp_id = VAR3;
        $row = $this->expcampo->dbselectByField("ecp_id", $ecp_id);
        $row = $row [0];
        $this->registry->template->ser_categoria = $ser_categoria;
        $this->registry->template->ser_id = $ser_id;
        $this->registry->template->ecp_id = $row->ecp_id;
        $this->registry->template->ecp_orden = $row->ecp_orden;
        $this->registry->template->ecp_nombre = $row->ecp_nombre;
        $this->registry->template->ecp_eti = $row->ecp_eti;
        $this->registry->template->ecp_tipdat = $expcampo->obtenerSelectTipoDato($row->ecp_tipdat);
        $this->registry->template->titulo = "Editar ";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;        
        
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_expcampo.tpl');
        $this->registry->template->show('footer');
    }


    function add() {
        $expcampo = new expcampo();
        
        
        $this->series = new tab_series();
        $sql = "SELECT * 
                FROM tab_series 
                WHERE ser_id = " . VAR3;
        $resul = $this->series->dbselectBySQL($sql);
        if (count($resul))
            $codigo2 = $resul[0]->ser_categoria;
        else
            $codigo2 = "";
       
        $this->registry->template->ser_id = VAR3;
        $this->registry->template->ser_categoria = $codigo2;
        $this->registry->template->ecp_id = "";
        $this->registry->template->ecp_orden = "";
        $this->registry->template->ecp_nombre = "";
        $this->registry->template->ecp_eti = "";
        $this->registry->template->ecp_tipdat = $expcampo->obtenerSelectTipoDato();
        
        $this->registry->template->titulo = "NUEVO CAMPO EXPEDIENTE ";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
                               
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_expcampo.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->expcampo = new tab_expcampo ();
        $this->expcampo->setRequest2Object($_REQUEST);
        $this->expcampo->setSer_id($_REQUEST['ser_id']);
        $this->expcampo->setEcp_orden($_REQUEST['ecp_orden']);
        $this->expcampo->setEcp_nombre($_REQUEST['ecp_nombre']);
        $this->expcampo->setSer_id($_REQUEST['ser_id']);
        $this->expcampo->setEcp_eti($_REQUEST['ecp_eti']);
        $this->expcampo->setEcp_tipdat($_REQUEST['ecp_tipdat']);
        $this->expcampo->setEcp_estado(1);
        $ecp_id = $this->expcampo->insert();
        
        Header("Location: " . PATH_DOMAIN . "/expcampo/index/" . $_REQUEST['ser_id'] . "/");
        //Header("Location: " . PATH_DOMAIN . "/expcampo/");
    }

    function update() {
        $this->expcampo = new tab_expcampo ();
        $this->expcampo->setRequest2Object($_REQUEST);
        $expcampo_id = $_REQUEST['ecp_id'];
        $this->expcampo->setEcp_id($expcampo_id);
        $this->expcampo->setEcp_orden($_REQUEST['ecp_orden']);
        $this->expcampo->setEcp_nombre($_REQUEST['ecp_nombre']);
        $this->expcampo->setSer_id($_REQUEST['ser_id']);
        $this->expcampo->setEcp_eti($_REQUEST['ecp_eti']);
        $this->expcampo->setEcp_tipdat($_REQUEST['ecp_tipdat']);
//        $this->expcampo->setEcp_fecha_mod(date("Y-m-d"));
//        $this->expcampo->setEcp_usuario_mod($_SESSION ['USU_ID']);
        $this->expcampo->update();

        Header("Location: " . PATH_DOMAIN . "/expcampo/index/" . $_REQUEST['ser_id'] . "/");
    }

    function delete() {
        $this->expcampo = new tab_expcampo ();
        $this->expcampo->setRequest2Object($_REQUEST);
        $ecp_id = $_REQUEST['ecp_id'];
        $this->expcampo->setEcp_id($ecp_id);
        $this->expcampo->setEcp_estado(2);
        $this->expcampo->update();

    }


}

?>