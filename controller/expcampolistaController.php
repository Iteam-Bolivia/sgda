<?php

/**
 * expcampolistaController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expcampolistaController extends baseController {

    function index() {
        $this->expcampo = new tab_expcampo();        
        $sql = "SELECT
                tab_series.ser_id,
                tab_expcampo.ecp_id,
                tab_expcampo.ecp_nombre
                FROM
                tab_series
                INNER JOIN tab_expcampo ON tab_expcampo.ser_id = tab_series.ser_id
                WHERE tab_expcampo.ecp_id = " . VAR3 . " 
                AND tab_expcampo.ecp_estado = 1 ";        
        $resul = $this->expcampo->dbselectBySQL($sql);
        if (count($resul)) {
            $codigo = $resul[0]->ecp_nombre;
            $ecp_id = $resul[0]->ecp_id;
            $ser_id = $resul[0]->ser_id;
        }
        else{
            $codigo = "";
            $ecp_id = 0;
            $ser_id = 0;
        }
        $this->registry->template->ecl_id = "";
        $this->registry->template->ecp_id = $ecp_id;
        $this->registry->template->ser_id = $ser_id;
        $this->registry->template->ecp_tipdat = $codigo;
              
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
        $this->registry->template->show('tab_expcampolistag.tpl');
        $this->registry->template->show('footer');        
    }

    function load() {
        $expcampolista = new expcampolista();
        $this->expcampolista = new tab_expcampolista ();
        $this->expcampolista->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ecl_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        if ($query) {
            if ($qtype == 'ecl_id')
                $where = " WHERE $qtype = '$query' ";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT *
                    FROM tab_expcampolista
                    $where and ecl_estado = 1
                    $sort $limit";
        } else {
            if (VAR3!=""){
                $sql = "SELECT
                        tab_expcampolista.ecp_id,
                        tab_expcampolista.ecl_id,
                        tab_expcampolista.ecl_valor,
                        tab_expcampolista.ecl_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampolista ON tab_expcampo.ecp_id = tab_expcampolista.ecp_id
                        WHERE tab_expcampolista.ecp_id = " . VAR3 . " AND tab_expcampolista.ecl_estado = 1
                        $sort $limit";                
            }else{
                $sql = "SELECT *
                        FROM tab_expcampolista
                        WHERE ecl_estado = 1
                        $sort $limit";
            }
        }
        $result = $this->expcampolista->dbselectBySQL($sql);
        $total = $expcampolista->count2($where, VAR3);
//        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//        header("Cache-Control: no-cache, must-revalidate");
//        header("Pragma: no-cache");
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
            $json .= "id:'" . $un->ecl_id . "',";
            $json .= "cell:['" . $un->ecl_id . "'";
            $json .= ",'" . addslashes(utf8_encode($un->ecl_valor)) . "'";
            $json .= ",'" . addslashes(utf8_encode($un->ecl_estado)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/expcampolista/view/" . $_REQUEST["ecl_id"] . "/");
    }

    function view() {    
    if(! VAR3){ die("Error del sistema 404"); }
        $this->expcampo = new tab_expcampo();
        $sql = "SELECT
                tab_expcampo.ecp_id,
                tab_expcampo.ecp_nombre,
                tab_expcampolista.ecl_id
                FROM
                tab_expcampolista
                INNER JOIN tab_expcampo ON tab_expcampo.ecp_id = tab_expcampolista.ecp_id
                WHERE tab_expcampolista.ecl_id = " . VAR3;
        $resul = $this->expcampo->dbselectBySQL($sql);
        if(! $resul){ die("Error del sistema 404"); }
        if (count($resul))
            $codigo = $resul[0]->ecp_nombre;
        else
            $codigo = "";
        
        
        $this->expcampolista = new tab_expcampolista ();
        $this->expcampolista->setRequest2Object($_REQUEST);
        $ecl_id = VAR3;
        $row = $this->expcampolista->dbselectByField("ecl_id", $ecl_id);
        $row = $row [0];
        
        $this->registry->template->ecp_nombre = $codigo;        
        $this->registry->template->ecp_id = $row->ecp_id;
        $this->registry->template->ecl_id = $row->ecl_id;
        $this->registry->template->ecl_valor = $row->ecl_valor;
        $this->registry->template->ecl_estado = $row->ecl_estado;
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
        $this->registry->template->show('tab_expcampolista.tpl');
        $this->registry->template->show('footer');
    }


    function add() {
        $this->expcampo = new tab_expcampo();
        $sql = "SELECT ecp_nombre
                FROM tab_expcampo 
                WHERE ecp_id = " . VAR3;
        $resul = $this->expcampo->dbselectBySQL($sql);
        if (count($resul))
            $codigo = $resul[0]->ecp_nombre;
        else
            $codigo = "";

        $this->registry->template->titulo = "Nuevo valor de lista";
        $this->registry->template->ecp_nombre = $codigo;        
        $this->registry->template->ecp_id = VAR3;        
        $this->registry->template->ecl_id = "";
        $this->registry->template->ecl_valor = "";
        $this->registry->template->titulo = "Nuevo ";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";

        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_expcampolista.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->expcampolista = new tab_expcampolista ();
        $this->expcampolista->setRequest2Object($_REQUEST);        
        $this->expcampolista->setEcl_id($_REQUEST['ecl_id']);
        $this->expcampolista->setEcp_id($_REQUEST['ecp_id']);
        $this->expcampolista->setEcl_valor($_REQUEST['ecl_valor']);
//        $this->expcampolista->setEcl_fecha_crea(date("Y-m-d"));
//        $this->expcampolista->setEcl_usuario_crea($_SESSION ['USU_ID']);
        $this->expcampolista->setEcl_estado(1);
        $ecl_id = $this->expcampolista->insert();
        
        Header("Location: " . PATH_DOMAIN . "/expcampolista/index/" . $_REQUEST['ecp_id'] . "/");
        //Header("Location: " . PATH_DOMAIN . "/expcampolista/");
    }

    function update() {
        $this->expcampolista = new tab_expcampolista ();
        $this->expcampolista->setRequest2Object($_REQUEST);
        $ecl_id = $_REQUEST['ecl_id'];
        $this->expcampolista->setEcl_id($ecl_id);  
        $this->expcampolista->setEcp_id($_REQUEST['ecp_id']);  
        $this->expcampolista->setEcl_valor($_REQUEST['ecl_valor']);        
//        $this->expcampolista->setEcl_fecha_mod(date("Y-m-d"));
//        $this->expcampolista->setEcl_usuario_mod($_SESSION ['USU_ID']);
        $this->expcampolista->update();
        
        Header("Location: " . PATH_DOMAIN . "/expcampolista/index/" . $_REQUEST['ecp_id'] . "/");
    }

    function delete() {
        $texpcampolista = new tab_expcampolista();
        $texpcampolista->setRequest2Object($_REQUEST);

        $texpcampolista->setEcl_id($_REQUEST['ecl_id']);
        $texpcampolista->setEcl_estado(2);
//        $texpcampolista->setEcl_fecha_mod(date("Y-m-d"));
//        $texpcampolista->setEcl_usuario_mod($_SESSION['USU_ID']);
        $texpcampolista->update();
    }

}

?>
