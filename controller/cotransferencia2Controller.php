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
class coTransferencia2Controller extends baseController {

    function index() {    
        
        $str_id = VAR3;
        $this->registry->template->str_id = VAR3;
        
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;   
        $this->registry->template->titulo = "Confirmar Transferencias";
        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_cotransferencia2g.tpl');
        $this->registry->template->show('footer');        
    }

    function load() {
        $this->soltransferencia = new tab_soltransferencia ();
        $this->soltransferencia->setRequest2Object($_REQUEST);

        //$tipo = $this->usuario->getTipo($_SESSION ['USU_ID']);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'tab_expediente.exp_fecha_exf';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder ";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query != "") {
            if ($qtype == 'exp_id')
                $where .= " and tab_expediente.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                if ($query!='TODOS'){
                    $where .= " and tab_series.ser_categoria LIKE '%$query%' ";
                }
            elseif ($qtype == 'custodio') {
                $nomArray = explode(" ", $query);
                foreach ($nomArray as $nom) {
                    $where .= " and (tab_usuario.usu_nombres LIKE '%$nom%' OR tab_usuario.usu_apellidos LIKE '%$nom%') ";
                }
            }else{
                if ($query=='TODOS'){
                    $where .= "";
                }else{
                    $where .= " and $qtype LIKE '%$query%' ";
                }
            }
                
        }

        $sql = "SELECT
                tab_soltransferencia.str_id,
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_unidad.uni_id,
                tab_series.ser_id,
                tab_expediente.exp_id,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                (tab_expisadg.exp_fecha_exi + 
                                    (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                                    FROM tab_retensiondoc 
                                    WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf,
                tab_usuario.usu_nombres,
                tab_usuario.usu_apellidos,
                tab_expusuario.eus_estado,
                tab_expediente.exp_estado
                FROM
                tab_unidad
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                INNER JOIN tab_exptransferencia ON tab_expediente.exp_id = tab_exptransferencia.exp_id
                INNER JOIN tab_soltransferencia ON tab_soltransferencia.str_id = tab_exptransferencia.str_id
                WHERE
                tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . "
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_usuario.usu_estado = 1
                AND tab_expusuario.eus_estado = 3
                 $where $sort $limit";

                 // VAR3
        $expediente = new expediente ();
        $soltransferencia = new soltransferencia();
        $result = $this->soltransferencia->dbselectBySQL($sql);
        $total = $soltransferencia->count($where);

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
            
            $chk = "<input id=\"chk_" . $un->exp_id . "\" restric=\"" . $un->exp_id . "\" class=\"exp_chk\" type=\"checkbox\" value=\"" . $un->exp_id . "\" />";
            
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->exp_id . "',";            
            $json .= "cell:['" . $un->exp_id . "'";            
            $json .= ",'" . $chk . "'";
            
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo .  DELIMITER . $un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= ",'" . addslashes($un->exp_titulo) . "'";
            //$json .= ",'" . addslashes($un->exp_descripcion) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exi) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exf) . "'";
            $json .= ",'" . addslashes($expediente->obtenerCustodios($un->exp_id)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;

    }
    
    function confirmar() {
        $ids = substr($_REQUEST['Ids'], 0, -1);
        $array = explode(",",$ids);
        
        $str_id = $_REQUEST['Str_id'];
        $sql = "SELECT
            tab_soltransferencia.str_id,
            tab_expediente.exp_id
            FROM
            tab_unidad
            INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
            INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
            INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
            INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
            INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
            INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
            INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
            INNER JOIN tab_exptransferencia ON tab_expediente.exp_id = tab_exptransferencia.exp_id
            INNER JOIN tab_soltransferencia ON tab_soltransferencia.str_id = tab_exptransferencia.str_id
            WHERE tab_series.ser_estado = 1
            AND tab_expediente.exp_estado = 1
            AND tab_usuario.usu_estado = 1
            AND tab_expusuario.eus_estado = 3
            AND tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . "
            AND tab_soltransferencia.str_id = '" . $str_id . "' " ;         

        $res = "";
        $soltransferencia = new tab_soltransferencia();
        $result = $soltransferencia->dbselectBySQL($sql);
        foreach ($result as $un) {
            $i = 1;
            foreach ($array as $valor) {
                 if ($un->exp_id==$valor){                     
                     $res = "Ok";
                     
                 }else {
                     if ($i==count($array)) break;
                     $res = "";
                 }
                 $i++;
            }
            if ($res==""){
                break;
            }
            
        }
        
        if ($res=='Ok'){ 
            if (count($array) > 0) {
                 for ($x=0;$x<count($array); $x++) {               
                     // tab_expusuario
                     $expediente = new expediente();
                     $eus_id = $expediente->obtenerExpUsuarioIdConfirmacion($array[$x]);

                     // Confirmar transferencia
                     $this->expusuario = new tab_expusuario();
                     $this->expusuario->setEus_id($eus_id);
                     $this->expusuario->setUsu_id($_REQUEST['usu_id']);
                     $this->expusuario->setExp_id($array[$x]);
                     $this->expusuario->setEus_estado(1);
                     $this->expusuario->update();
                 }  
                 
                 // Cambiar de estado la transferencia
                $this->soltransferencia = new tab_soltransferencia ();
                $this->soltransferencia->setStr_id($str_id);
                $this->soltransferencia->setStr_estado(2);
                $this->soltransferencia->update();                 
             }               
        }else{
            $res = "Nok";
        }
        echo $res;
    }    
    

}

?>
