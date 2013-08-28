<?php

/**
 * subcontenedorController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class subcontenedorController Extends baseController {

    function index() {
        $this->contenedor = new tab_contenedor();
        $sql = "SELECT con.con_codigo,usu.usu_nombres,usu.usu_apellidos
FROM tab_contenedor AS con 
INNER JOIN tab_usuario AS usu ON con.usu_id = usu.usu_id
WHERE con.con_id = " . VAR3;
        $resul = $this->contenedor->dbselectBySQL($sql);
        if (count($resul)) {
            $codigo = $resul[0]->con_codigo;
            $usuario = $resul[0]->usu_nombres . " " . $resul[0]->usu_nombres;
        } else {
            $codigo = "";
            $usuario = "";
        }
        $this->registry->template->suc_id = "";
        $this->registry->template->con_codigo = $codigo;
        $this->registry->template->usuario = $usuario;
        
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
        $this->registry->template->show('tab_subcontenedorg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $subcontenedor = new subcontenedor();
        $this->subcontenedor = new tab_subcontenedor();
        $this->subcontenedor->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'suc_id';
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
            if ($qtype == 'suc_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        if (VAR3!=""){  
            $sql = "SELECT
                    suc.suc_id,
                    suc.suc_codigo,
                    suc.suc_ml,
                    suc.suc_nro_balda,
                    con.con_codigo,
                    usu.usu_nombres,
                    usu.usu_apellidos
                    FROM tab_subcontenedor AS suc 
                    INNER JOIN tab_contenedor AS con ON suc.con_id = con.con_id
                    INNER JOIN tab_usuario AS usu ON con.usu_id = usu.usu_id
                    WHERE con.con_id = " . VAR3 . " 
                    AND suc.suc_estado = 1 
                    AND con.con_estado = 1 
                    $where $sort $limit";
        }else{
            $sql = "SELECT
                    suc.suc_id,
                    suc.suc_codigo,
                    suc.suc_ml,
                    suc.suc_nro_balda,
                    con.con_codigo,
                    usu.usu_nombres,
                    usu.usu_apellidos
                    FROM tab_subcontenedor AS suc 
                    INNER JOIN tab_contenedor AS con ON suc.con_id = con.con_id
                    INNER JOIN tab_usuario AS usu ON con.usu_id = usu.usu_id
                    WHERE 
                    suc.suc_estado = 1 
                    AND con.con_estado = 1 
                    $where $sort $limit";            
        }
            
        $result = $this->subcontenedor->dbselectBySQL($sql);
        $total = $subcontenedor->count($where);
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
            $json .= "id:'" . $un->suc_id . "',";
            $json .= "cell:['" . $un->suc_id . "'";
            //$json .= ",'" . addslashes($un->usu_apellidos . " " . $un->usu_nombres) . "'";
            $json .= ",'" . addslashes($un->con_codigo) . "'";
            $json .= ",'" . addslashes($un->suc_codigo) . "'";
            $json .= ",'" . addslashes($un->suc_ml) . "'";
            $json .= ",'" . addslashes($un->suc_nro_balda) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/subcontenedor/view/" . $_REQUEST["suc_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->subcontenedor = new tab_subcontenedor();
        $this->subcontenedor->setRequest2Object($_REQUEST);
        $row = $this->subcontenedor->dbselectByField("suc_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];

        $tab_contenedor = new Tab_contenedor();
       $usuario = new usuario();
        $adm = $usuario->esAdm();
        $this->registry->template->adm = $adm;    
        
        $sql = "SELECT con.con_id,con.con_codigo,usu.usu_id,usu.usu_nombres,usu.usu_apellidos
FROM tab_contenedor AS con 
INNER JOIN tab_usuario AS usu ON con.usu_id = usu.usu_id
WHERE con.con_id = " . $row->con_id;
        $result = $tab_contenedor->dbselectBySQL($sql);
        if (count($result)){
            $codigo2 = $result[0]->con_codigo;
            $usu_id = $result[0]->usu_id;
            $nombre = $result[0]->usu_nombres." ".$result[0]->usu_apellidos;
            $con_id = $result[0]->con_id;
        }
        else{
            $codigo2 = "";
            $usu_id = "";
            $nombre = "";
            $con_id = "";
        }
        
        $this->registry->template->con_id = $con_id;
        $this->registry->template->con_codigo = $codigo2;
        $this->registry->template->nombre = $nombre;
        
        $this->registry->template->titulo = "Editar Sub Contenedor";
        
        $this->registry->template->suc_id = $row->suc_id;
        //$contenedor = new contenedor();
        $this->registry->template->suc_nro_balda = $row->suc_nro_balda;
        $this->registry->template->suc_fecha_exi_min = $row->suc_fecha_exi_min;
        $this->registry->template->suc_fecha_exf_max = $row->suc_fecha_exf_max;
        $this->registry->template->suc_codigo = $row->suc_codigo;
        $this->registry->template->suc_ml = $row->suc_ml;
        

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_subcontenedor.tpl');
        $this->registry->template->show('footer');
    }


    function add() {

        $usuario = new usuario();
        $adm = $usuario->esAdm();
        $this->registry->template->adm = $adm;        
        
        $this->contenedor = new tab_subcontenedor();
        $sql = "SELECT con.con_id,con.con_codigo,usu.usu_id,usu.usu_nombres,usu.usu_apellidos
FROM tab_contenedor AS con 
INNER JOIN tab_usuario AS usu ON con.usu_id = usu.usu_id
WHERE con.con_id = " . VAR3;
        $result = $this->contenedor->dbselectBySQL($sql);
        if (count($result)){
            $codigo2 = $result[0]->con_codigo;
            $usu_id = $result[0]->usu_id;
            $nombre = $result[0]->usu_nombres." ".$result[0]->usu_apellidos;
            $con_id = $result[0]->con_id;
        }
        else{
            $codigo2 = "";
            $usu_id = "";
            $nombre = "";
            $con_id = "";
        }
        $this->registry->template->con_id = VAR3;
        $this->registry->template->con_codigo = $codigo2;
        $this->registry->template->nombre = $nombre;
        
        //$usuario = new usuario();
        $this->registry->template->titulo = "NUEVO SUBCONTENEDOR ";        
        $this->registry->template->suc_id = "";
        //$this->registry->template->usu_id = $usuario->obtenerSelect();
        //$contenedor = new contenedor();
        //$this->registry->template->con_idOption = $contenedor->selectCon($con_id, $usu_id);        
        $this->registry->template->suc_nro_balda = "";
        $this->registry->template->suc_fecha_exi_min = "";
        $this->registry->template->suc_fecha_exf_max = "";
        $this->registry->template->suc_codigo = "";
        $this->registry->template->suc_ml = "";

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
        $this->registry->template->show('tab_subcontenedor.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->subcontenedor = new tab_subcontenedor();
        $this->subcontenedor->setRequest2Object($_REQUEST);

        $this->subcontenedor->setSuc_id($_REQUEST['suc_id']);
        $this->subcontenedor->setCon_id($_REQUEST['con_id']);
        $this->subcontenedor->setSuc_nro_balda($_REQUEST['suc_nro_balda']);
//        $this->subcontenedor->setSuc_fecha_exi_min($_REQUEST['suc_fecha_exi_min']);
//        $this->subcontenedor->setSuc_fecha_exf_max($_REQUEST['suc_fecha_exf_max']);
//        $this->subcontenedor->setSuc_usu_reg($_SESSION['USU_ID']);
//        $this->subcontenedor->setSuc_fecha_reg(date("Y-m-d"));
        $this->subcontenedor->setSuc_codigo($_REQUEST['suc_codigo']);
        $this->subcontenedor->setSuc_ml($_REQUEST['suc_ml']);
        $this->subcontenedor->setSuc_estado(1);
        $suc_id = $this->subcontenedor->insert();

        Header("Location: " . PATH_DOMAIN . "/subcontenedor/index/" . $_REQUEST['con_id'] . "/");
    }

    function update() {
        $this->subcontenedor = new tab_subcontenedor();
        $this->subcontenedor->setRequest2Object($_REQUEST);

        $rows = $this->subcontenedor->dbselectByField("suc_id", $_REQUEST['suc_id']);
        $this->subcontenedor = $rows[0];
        $id = $this->subcontenedor->suc_id;

        $this->subcontenedor->setSuc_id($_REQUEST['suc_id']);
        $this->subcontenedor->setCon_id($_REQUEST['con_id']);
        $this->subcontenedor->setSuc_nro_balda($_REQUEST['suc_nro_balda']);
//        $this->subcontenedor->setSuc_fecha_exi_min($_REQUEST['suc_fecha_exi_min']);
//        $this->subcontenedor->setSuc_fecha_exf_max($_REQUEST['suc_fecha_exf_max']);
        $this->subcontenedor->setSuc_codigo($_REQUEST['suc_codigo']);
        $this->subcontenedor->setSuc_ml($_REQUEST['suc_ml']);
        $this->subcontenedor->setSuc_estado(1);
        $this->subcontenedor->update();

        Header("Location: " . PATH_DOMAIN . "/subcontenedor/index/" . $_REQUEST['con_id'] . "/");
    }

    function delete() {

        $this->subcontenedor = new tab_subcontenedor();

        $this->subcontenedor->setSuc_id($_REQUEST['suc_id']);
        $this->subcontenedor->setSuc_estado(0);
        $this->subcontenedor->update();
    }

    function loadAjax() {
        $con_id = $_POST["con_id"];
        $sql = "SELECT *
		FROM
		tab_subcontenedor
		WHERE
		tab_subcontenedor.con_id =  '$con_id' ";
        $subcontenedor = new tab_subcontenedor();
        $result = $subcontenedor->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            $res[$row->suc_id] = $row->suc_codigo;
        }
        echo json_encode($res);
    }

}

?>
