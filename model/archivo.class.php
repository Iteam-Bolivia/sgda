<?php

/**
 * archivo.class.php Model
 *
 * @package
 * @author iteam
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */

class archivo extends tab_archivo {

    function __construct() {
        $this->archivo = new Tab_archivo();
    }

    function obtenerSelectEstante($default=null) {
        // uso de la funcin lenght o count investigaar
        //$abecedario = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
        $abecedario = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $option = "";
       for($i=0;$i<strlen($abecedario);$i++){
           if ($default == $abecedario[$i] ){
                $option .="<option value='" . $abecedario[$i] . "' selected>" . $abecedario[$i] . "</option>";
           }else{
               $option .="<option value='" . $abecedario[$i] . "'>" . $abecedario[$i] . "</option>";
           }
        }                
        return $option;
    }
    
    function count($where) {
        $where = "";
        $sql = "SELECT COUNT(distinct ta.fil_id) as num
        FROM tab_archivo AS ta Inner Join tab_exparchivo AS tea ON tea.fil_id = ta.fil_id
        Inner join tab_expediente AS te ON te.exp_id = tea.exp_id
        Inner join tab_series AS se ON tea.ser_id = se.ser_id
        Inner join tab_tramite AS tt ON tea.tra_id = tt.tra_id
        Inner join tab_cuerpos AS tc ON tea.cue_id = tc.cue_id
		WHERE tea.exa_estado='1' ";
        $num = $this->archivo->countBySQL($sql);
        return $num;
    }

    function obtenerCodigoArchivo($fil_id) {
        $archivo = new Tab_archivo();
        $fil_codigo = "";
        $rows = "";
        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_cuerpos.cue_codigo,
                tab_archivo.fil_codigo
                FROM
                tab_fondo
                INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_exparchivo.cue_id
                INNER JOIN tab_tramitecuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                WHERE
                tab_fondo.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_archivo.fil_estado = 1 AND
                tab_cuerpos.cue_estado = 1 AND
                tab_tramite.tra_estado = 1 AND
                tab_tramitecuerpos.trc_estado = 1 
                AND tab_archivo.fil_id = '$fil_id' ";        
        $rows = $archivo->dbselectBySQL($sql);
        foreach ($rows as $val) {
            $fil_codigo = $val->fon_cod . DELIMITER . $val->uni_cod . DELIMITER . $val->tco_codigo . DELIMITER . $val->ser_codigo . DELIMITER . $val->exp_codigo . DELIMITER . $val->cue_codigo . DELIMITER . $val->fil_codigo ;
        }
        return $fil_codigo;
    }
    

    function obtenerCajaArchivo($fil_id) {
        $archivo = new Tab_archivo();
        $fil_nrocaj = "";
        $rows = "";
        $sql = "SELECT
                fil_nrocaj
                FROM
                tab_archivo
                WHERE
                fil_estado = 1 AND
                fil_id = '$fil_id' ";        
        $rows = $archivo->dbselectBySQL($sql);
        foreach ($rows as $val) {
            $fil_nrocaj = $val->fil_nrocaj ;
        }
        return $fil_nrocaj;
    }
    

    // Busqueda Prestamos
    
    function buscarPrestamos($busquedaArray) {
        
        $page = $busquedaArray['page'];
        $rp = $busquedaArray['rp'];
        $sortname = $busquedaArray['sortname'];
        $sortorder = $busquedaArray['sortorder'];
        
        //
//        $fon_id = $busquedaArray['fon_id'];
        $uni_id = $busquedaArray['uni_id'];
        $ser_id = $busquedaArray['ser_id'];        
        $tra_id = $busquedaArray['tra_id'];
        $cue_id = $busquedaArray['cue_id'];
        $exp_titulo = $busquedaArray['exp_titulo'];
        $fil_nur = $busquedaArray['fil_nur'];
        $fil_titulo = $busquedaArray['fil_titulo'];
        $pac_nombre = $busquedaArray['pac_nombre'];
        $fil_subtitulo = $busquedaArray['fil_subtitulo'];
        $fil_proc = $busquedaArray['fil_proc'];
        $fil_firma = $busquedaArray['fil_firma'];
        $fil_cargo = $busquedaArray['fil_cargo'];
        
        
        // Search
        $archivo = new archivo();
        $tarchivo = new tab_archivo ();
        $tarchivo->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'fil_id';
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
            if ($qtype == 'fil_id')
                $where = " WHERE $qtype = '$query' ";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * 
                    FROM tab_rol 
                    $where AND
                    rol_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * 
                    FROM tab_rol 
                    WHERE rol_estado = 1 $sort $limit ";
        }        
        
        $usu_id = $_SESSION['USU_ID'];
        
        $select = "SELECT
                tab_archivo.fil_id,
                (SELECT fon_codigo from tab_fondo WHERE fon_id=f.fon_par) AS fon_codigo,
                tab_unidad.uni_descripcion,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                f.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_id,
                tab_expediente.exp_codigo,
                tab_cuerpos.cue_codigo,
                tab_archivo.fil_codigo,
                tab_cuerpos.cue_descripcion,
                tab_archivo.fil_titulo,
                tab_archivo.fil_subtitulo,
                tab_archivo.fil_proc,
                tab_archivo.fil_firma,
                tab_archivo.fil_cargo,
                tab_archivo.fil_nrofoj,
                tab_archivo.fil_tomovol,
                tab_archivo.fil_nroejem,
                tab_archivo.fil_nrocaj,
                tab_archivo.fil_sala,
                tab_archivo.fil_estante,
                tab_archivo.fil_cuerpo,
                tab_archivo.fil_balda,
                tab_archivo.fil_tipoarch,
                tab_archivo.fil_mrb,
                tab_archivo.fil_ori,
                tab_archivo.fil_cop,
                tab_archivo.fil_fot,
                (CASE tab_exparchivo.exa_condicion 
                                    WHEN '1' THEN 'DISPONIBLE' 
                                    WHEN '2' THEN 'PRESTADO' END) AS disponibilidad,
                (SELECT fil_nomoriginal FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_nomoriginal,
                (SELECT fil_extension FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_extension,
                (SELECT fil_tamano/1048576 FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_tamano,
                (SELECT fil_nur FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_nur,                
                (SELECT fil_asunto FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_asunto,                
                tab_archivo.fil_obs";
        $from = "FROM
                tab_fondo as f
                INNER JOIN tab_unidad ON f.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_exparchivo.cue_id
                INNER JOIN tab_tramitecuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                WHERE
                f.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_archivo.fil_estado = 1 AND
                tab_exparchivo.exa_estado = 1 AND
                tab_expusuario.eus_estado = 1 AND
                tab_expusuario.usu_id='$usu_id' ";
        
        $where = "";        
//        if (strlen($fon_id)> 0 && $fon_id!='null') {
//            $where .= " AND tab_fondo.fon_id='$fon_id' ";            
//        }
        
        if (strlen($uni_id) > 0 && $uni_id!='null') {
            $where .= " AND tab_unidad.uni_id='$uni_id' ";            
        }
        if (strlen($ser_id) > 0 && $ser_id!='null') {
            $where .= " AND tab_series.ser_id='$ser_id' ";           
        }
        if (strlen($tra_id) > 0 && $tra_id!='null') {
            $where .= " AND tab_tramite.tra_id='$tra_id' ";            
        }
        if (strlen($cue_id) > 0 && $cue_id!='null') {
            $where .= " AND tab_cuerpos.cue_id='$cue_id' ";            
        }
        if (strlen($exp_titulo)) {
            $where .= " AND tab_expisadg.exp_titulo like '%$exp_titulo%' ";            
        }
        if (strlen($fil_nur)) {
            $where .= " AND tab_archivo.fil_nur like '%$fil_nur%' ";            
        }        
        if (strlen($fil_titulo)) {
            $where .= " AND tab_archivo.fil_titulo like '%$fil_titulo%' ";            
        }              
        if (strlen($fil_subtitulo)) {
            $where .= " AND tab_archivo.fil_subtitulo like '%$fil_subtitulo%' ";            
        }
        if (strlen($fil_proc)) {
            $where .= " AND tab_archivo.fil_proc like '%$fil_proc%' ";            
        }   
        if (strlen($fil_firma)) {
            $where .= " AND tab_archivo.fil_firma like '%$fil_firma%' ";            
        }                 
        if (strlen($fil_cargo)) {
            $where .= " AND tab_archivo.fil_cargo like '%$fil_cargo%' ";            
        }             
        // Search addwords
        if (strlen($pac_nombre)) {
            $palclave = new palclave();
            $ids = $palclave->listaPCSearchFile($pac_nombre);
            $where .= " AND tab_archivo.fil_id IN ($ids) ";            
        }  
        
        $sql = "$select $from $where $sort $limit";
        $result = $tarchivo->dbSelectBySQL($sql); //print $sql;
        $sql_c = "SELECT COUNT(tab_archivo.fil_id) $from $where ";
        $total = $tarchivo->countBySQL($sql_c);
        
        $exp = new expediente ();        
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
            $json .= "id:'" . $un->fil_id . "',";
            //$json .= "cell:['" . $un->fil_id . "'";
            $json .= "cell:[";
            $json .= "'<input id=\"chkid_" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"fil_chk\" type=\"checkbox\" value=\"" . $un->fil_id . "\" />'";
            if ($un->fil_confidencialidad == 3) {
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFileP icon\" />'";
            } else {
                //$json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/document-$un->fil_extension.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
                ///web/lib/32/document-". $una->fil_extension .".png'
            }

            if ($un->fil_confidencialidad == 3) {
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewP icon\" />'";
            } else {
                //$json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"view icon\" />'";
                ///web/lib/32/document-". $una->fil_extension .".png'
            }

            
            $json .= ",'" . $un->fil_id . "'";                        
            $json .= ",'" . addslashes($un->fon_codigo) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->uni_descripcion)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->ser_categoria)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->exp_titulo)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->cue_descripcion)) . "'";            
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo . DELIMITER . $un->exp_codigo . DELIMITER . $un->cue_codigo .  DELIMITER . $un->fil_codigo) . "'";            
            $json .= ",'" . addslashes(utf8_decode($un->fil_titulo)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_proc)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_firma)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_cargo)) . "'";
            $json .= ",'" . addslashes($un->fil_nrofoj) . "'";
            $json .= ",'" . addslashes($un->fil_nrocaj) . "'";
            $json .= ",'" . addslashes($un->fil_sala) . "'";
            $json .= ",'" . addslashes($un->fil_estante) . "'";
            $json .= ",'" . addslashes($un->fil_cuerpo) . "'";
            $json .= ",'" . addslashes($un->fil_balda) . "'";
            $json .= ",'" . addslashes($un->fil_tipoarch) . "'";
            $json .= ",'" . addslashes($un->fil_mrb) . "'";
            $json .= ",'" . addslashes($un->fil_ori) . "'";
            $json .= ",'" . addslashes($un->fil_cop) . "'";
            $json .= ",'" . addslashes($un->fil_fot) . "'";
            
            $json .= ",'" . addslashes($un->fil_nur) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_asunto)) . "'";
            
            $json .= ",'" . addslashes($un->disponibilidad) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_nomoriginal)) . "'";
            $json .= ",'" . addslashes($un->fil_tamano) . "'";            
            $json .= ",'" . addslashes(utf8_decode($un->fil_obs)) . "'";
            
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;

    }
    

    
    
    
    
    
    
    // Busqueda principal
    function buscar($busquedaArray) {
         $valor="";$id_listar="";
        if(isset($_SESSION['id_lista'])){
          $id_listar=$_SESSION['id_lista'];
          //$id_listar=$_SESSION['id_lista'];

        }
        $page = $busquedaArray['page'];
        $rp = $busquedaArray['rp'];
        $sortname = $busquedaArray['sortname'];
        $sortorder = $busquedaArray['sortorder'];
        if(isset($_SESSION['id_lista'])){
            
        }
        
        $palabra = $busquedaArray['palabra'];
//        $fon_id = $busquedaArray['fon_id'];
        $uni_id = $busquedaArray['uni_id'];
        $ser_id = $busquedaArray['ser_id'];        
        $tra_id = $busquedaArray['tra_id'];
        $cue_id = $busquedaArray['cue_id'];
        $exp_titulo = $busquedaArray['exp_titulo'];
        $fil_nur = $busquedaArray['fil_nur'];
        $fil_titulo = $busquedaArray['fil_titulo'];
        $pac_nombre = $busquedaArray['pac_nombre'];
        $fil_subtitulo = $busquedaArray['fil_subtitulo'];
        $fil_proc = $busquedaArray['fil_proc'];
        $fil_firma = $busquedaArray['fil_firma'];
        $fil_cargo = $busquedaArray['fil_cargo'];
        $fil_tipoarch = $busquedaArray['fil_tipoarch'];
        
        
        // Search
        $archivo = new archivo();
        $tarchivo = new tab_archivo ();
        $tarchivo->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'fil_id';
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
            if ($qtype == 'fil_id')
                $where = " WHERE $qtype = '$query' ";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * 
                    FROM tab_rol 
                    $where AND
                    rol_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * 
                    FROM tab_rol 
                    WHERE rol_estado = 1 $sort $limit ";
        }        
        
        $usu_id = $_SESSION['USU_ID'];
        
        $select = "SELECT
                tab_archivo.fil_id,
                (SELECT fon_codigo from tab_fondo WHERE fon_id=f.fon_par) AS fon_codigo,
                tab_unidad.uni_descripcion,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                f.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_id,
                tab_expediente.exp_codigo,
                tab_cuerpos.cue_codigo,
                tab_archivo.fil_codigo,
                tab_cuerpos.cue_descripcion,
                tab_archivo.fil_titulo,
                tab_archivo.fil_subtitulo,
                tab_archivo.fil_proc,
                tab_archivo.fil_firma,
                tab_archivo.fil_cargo,
                tab_archivo.fil_nrofoj,
                tab_archivo.fil_tomovol,
                tab_archivo.fil_nroejem,
                tab_archivo.fil_nrocaj,
                tab_archivo.fil_sala,
                tab_archivo.fil_estante,
                tab_archivo.fil_cuerpo,
                tab_archivo.fil_balda,
                tab_archivo.fil_tipoarch,
                tab_archivo.fil_mrb,
                tab_archivo.fil_ori,
                tab_archivo.fil_cop,
                tab_archivo.fil_fot,
                (CASE tab_exparchivo.exa_condicion 
                                    WHEN '1' THEN 'DISPONIBLE' 
                                    WHEN '2' THEN 'PRESTADO' END) AS disponibilidad,
                (SELECT fil_nomoriginal FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_nomoriginal,
                (SELECT fil_extension FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_extension,
                (SELECT fil_tamano/1048576 FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_tamano,
                (SELECT fil_nur FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_nur,                
                (SELECT fil_asunto FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_asunto,                
                tab_archivo.fil_obs";
        $from = "FROM
                tab_fondo as f
                INNER JOIN tab_unidad ON f.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_exparchivo.cue_id
                INNER JOIN tab_tramitecuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                WHERE
                f.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_archivo.fil_estado = 1 AND
                tab_exparchivo.exa_estado = 1 AND
                tab_expusuario.eus_estado = 1 AND
                tab_expusuario.usu_id='$usu_id' ";
        
        $where = "";        
        if($id_listar<>""){
           $explode=explode(",",$id_listar);
            $cantidad=  count($explode);	
            for($i=0;$i<$cantidad;$i++){
                                    $valor.="tab_archivo.fil_id<>".$explode[$i];
                                    if($i<$cantidad-1){
                                    $valor.=" and ";
                                    }
            }
            $where .= " AND $valor ";                    
        }
        
        
        //
        if (strlen($palabra)) {
            $where .= " AND (tab_expisadg.exp_titulo like '%$palabra%' "; 
            $where .= " OR f.fon_descripcion like '%$palabra%' "; 
            $where .= " OR tab_unidad.uni_descripcion like '%$palabra%' "; 
            $where .= " OR tab_series.ser_categoria like '%$palabra%' ";             
            $where .= " OR tab_archivo.fil_titulo like '%$palabra%' "; 
            $where .= " OR tab_archivo.fil_subtitulo like '%$palabra%' "; 
            $where .= " OR tab_archivo.fil_proc like '%$palabra%' "; 
            $where .= " OR tab_archivo.fil_firma like '%$palabra%' "; 
            $where .= " OR tab_archivo.fil_cargo like '%$palabra%' "; 
            $where .= " OR tab_archivo.fil_tipoarch like '%$palabra%' "; 

            $palclave = new palclave();
            $ids = $palclave->listaPCSearchFile($palabra);
            if ($ids == ""){                
            }else{
                $where .= " OR tab_archivo.fil_id IN ($ids) ";             
            }
            $where .= " ) "; 
        }        
        
        
        if (strlen($uni_id) > 0 && $uni_id!='null') {
            $where .= " AND tab_unidad.uni_id='$uni_id' ";            
        }
        if (strlen($ser_id) > 0 && $ser_id!='null') {
            $where .= " AND tab_series.ser_id='$ser_id' ";           
        }
        if (strlen($tra_id) > 0 && $tra_id!='null') {
            $where .= " AND tab_tramite.tra_id='$tra_id' ";            
        }
        if (strlen($cue_id) > 0 && $cue_id!='null') {
            $where .= " AND tab_cuerpos.cue_id='$cue_id' ";            
        }
        if (strlen($exp_titulo)) {
            $where .= " AND tab_expisadg.exp_titulo like '%$exp_titulo%' ";            
        }       
        if (strlen($fil_titulo)) {
            $where .= " AND tab_archivo.fil_titulo like '%$fil_titulo%' ";            
        }              
        if (strlen($fil_subtitulo)) {
            $where .= " AND tab_archivo.fil_subtitulo like '%$fil_subtitulo%' ";            
        }
        if (strlen($fil_proc)) {
            $where .= " AND tab_archivo.fil_proc like '%$fil_proc%' ";            
        }   
        if (strlen($fil_firma)) {
            $where .= " AND tab_archivo.fil_firma like '%$fil_firma%' ";            
        }                 
        if (strlen($fil_cargo)) {
            $where .= " AND tab_archivo.fil_cargo like '%$fil_cargo%' ";            
        }           
        if (strlen($fil_tipoarch)) {
            $where .= " AND tab_archivo.fil_tipoarch like '%$fil_tipoarch%' ";            
        }   

        
//        if (strlen($fil_nur)) {
//            $where .= " AND tab_archivo.fil_nur like '%$fil_nur%' ";            
//        }         
        
        // Search addwords
        if (strlen($pac_nombre)) {
            $palclave = new palclave();
            $ids = $palclave->listaPCSearchFile($pac_nombre);
            if ($ids == ""){                            
            }else{
                $where .= " AND tab_archivo.fil_id IN ($ids) "; 
            }
        }  
        
        $sql = "$select $from $where $sort $limit";
        $result = $tarchivo->dbSelectBySQL($sql); //print $sql;
        $sql_c = "SELECT COUNT(tab_archivo.fil_id) $from $where ";
        $total = $tarchivo->countBySQL($sql_c);
        
        $exp = new expediente ();        
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
        $i = 0;$j=1;
        foreach ($result as $un) {
            
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->fil_id . "',";
            //$json .= "cell:['" . $un->fil_id . "'";
            $json .= "cell:[";
            $json .= "'<input id=\"chkid_" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"fil_chk".$j."\" type=\"checkbox\" value=\"" . $un->fil_id . "\" />'";
            
            if ($un->fil_confidencialidad == 3) {
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFileP icon\" />'";
            } else {
                //$json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/document-$un->fil_extension.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
                ///web/lib/32/document-". $una->fil_extension .".png'
            }

            if ($un->fil_confidencialidad == 3) {
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewP icon\" />'";
            } else {
                //$json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"view icon\" />'";
                ///web/lib/32/document-". $una->fil_extension .".png'
            }

            
            $json .= ",'" . $un->fil_id . "'";                        
            $json .= ",'" . addslashes($un->fon_codigo) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->uni_descripcion)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->ser_categoria)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->exp_titulo)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->cue_descripcion)) . "'";            
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo . DELIMITER . $un->exp_codigo . DELIMITER . $un->cue_codigo .  DELIMITER . $un->fil_codigo) . "'";            
            $json .= ",'" . addslashes(utf8_decode($un->fil_titulo)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_proc)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_firma)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_cargo)) . "'";
            $json .= ",'" . addslashes($un->fil_nrofoj) . "'";
            $json .= ",'" . addslashes($un->fil_nrocaj) . "'";
            $json .= ",'" . addslashes($un->fil_sala) . "'";
            $json .= ",'" . addslashes($un->fil_estante) . "'";
            $json .= ",'" . addslashes($un->fil_cuerpo) . "'";
            $json .= ",'" . addslashes($un->fil_balda) . "'";
            $json .= ",'" . addslashes($un->fil_tipoarch) . "'";
            $json .= ",'" . addslashes($un->fil_mrb) . "'";
            $json .= ",'" . addslashes($un->fil_ori) . "'";
            $json .= ",'" . addslashes($un->fil_cop) . "'";
            $json .= ",'" . addslashes($un->fil_fot) . "'";
            
            $json .= ",'" . addslashes($un->fil_nur) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_asunto)) . "'";
            
            $json .= ",'" . addslashes($un->disponibilidad) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_nomoriginal)) . "'";
            $json .= ",'" . addslashes($un->fil_tamano) . "'";            
            $json .= ",'" . addslashes(utf8_decode($un->fil_obs)) . "'";
            
            $json .= "]}";
            $rc = true;
            $i++;$j++;
        }
      
        $json .= "]\n";
          
        $json .= "}";
      
        echo $json;

    }

    
    function buscar2($busquedaArray) {
  $valor="";$id_listar="";
  if(isset($_SESSION['id_lista'])){
    $id_listar=$_SESSION['id_lista'];
  }
        $page = $busquedaArray['page'];
        $rp = $busquedaArray['rp'];
        $sortname = $busquedaArray['sortname'];
        $sortorder = $busquedaArray['sortorder'];
        
        //
//        $fon_id = $busquedaArray['fon_id'];
     
           
      

     

        
        // Search
        $archivo = new archivo();
        $tarchivo = new tab_archivo ();
        $tarchivo->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'fil_id';
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
            if ($qtype == 'fil_id')
                $where = " WHERE $qtype = '$query' ";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * 
                    FROM tab_rol 
                    $where AND
                    rol_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * 
                    FROM tab_rol 
                    WHERE rol_estado = 1 $sort $limit ";
        }        
        
        $usu_id = $_SESSION['USU_ID'];
  
        $select = "SELECT
                tab_archivo.fil_id,
                (SELECT fon_codigo from tab_fondo WHERE fon_id=f.fon_par) AS fon_codigo,
                tab_unidad.uni_descripcion,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                f.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_id,
                tab_expediente.exp_codigo,
                tab_cuerpos.cue_codigo,
                tab_archivo.fil_codigo,
                tab_cuerpos.cue_descripcion,
                tab_archivo.fil_titulo,
                tab_archivo.fil_subtitulo,
                tab_archivo.fil_proc,
                tab_archivo.fil_firma,
                tab_archivo.fil_cargo,
                tab_archivo.fil_nrofoj,
                tab_archivo.fil_tomovol,
                tab_archivo.fil_nroejem,
                tab_archivo.fil_nrocaj,
                tab_archivo.fil_sala,
                tab_archivo.fil_estante,
                tab_archivo.fil_cuerpo,
                tab_archivo.fil_balda,
                tab_archivo.fil_tipoarch,
                tab_archivo.fil_mrb,
                tab_archivo.fil_ori,
                tab_archivo.fil_cop,
                tab_archivo.fil_fot,
                (CASE tab_exparchivo.exa_condicion 
                                    WHEN '1' THEN 'DISPONIBLE' 
                                    WHEN '2' THEN 'PRESTADO' END) AS disponibilidad,
                (SELECT fil_nomoriginal FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_nomoriginal,
                (SELECT fil_extension FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_extension,
                (SELECT fil_tamano/1048576 FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_tamano,
                (SELECT fil_nur FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_nur,                
                (SELECT fil_asunto FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_asunto,                
                tab_archivo.fil_obs";
        $from = "FROM
                tab_fondo as f
                INNER JOIN tab_unidad ON f.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_exparchivo.cue_id
                INNER JOIN tab_tramitecuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                WHERE
                f.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_archivo.fil_estado = 1 AND
                tab_exparchivo.exa_estado = 1 AND
                tab_expusuario.eus_estado = 1 AND
                tab_expusuario.usu_id='$usu_id'";
        
        $where = "";        
//        if (strlen($fon_id)> 0 && $fon_id!='null') {
//            $where .= " AND tab_fondo.fon_id='$fon_id' ";            
//        }
        
     
        
        // Search addwords
        if($id_listar<>""){
                  $explode=explode(",",$id_listar);
                $cantidad=  count($explode);	
                for($i=0;$i<$cantidad;$i++){
					$valor.="tab_archivo.fil_id=".$explode[$i];
					if($i<$cantidad-1){
					$valor.=" or ";
					}
                }
       $where .= " AND $valor ";            
        
        }
        
        $sql = "$select $from $where $sort $limit";
        $result = $tarchivo->dbSelectBySQL($sql); //print $sql;
        $sql_c = "SELECT COUNT(tab_archivo.fil_id) $from $where ";
        $total = $tarchivo->countBySQL($sql_c);
        
        $exp = new expediente ();        
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
        $i = 0;$j=1;
        foreach ($result as $un) {
            
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->fil_id . "',";
            //$json .= "cell:['" . $un->fil_id . "'";
            $json .= "cell:[";
            $json .= "'<input id=\"chkid_" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"fil_chk".$j."\" type=\"checkbox\" value=\"" . $un->fil_id . "\" checked=\"checked\" />'";
            
            if ($un->fil_confidencialidad == 3) {
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFileP icon\" />'";
            } else {
                //$json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/document-$un->fil_extension.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
                ///web/lib/32/document-". $una->fil_extension .".png'
            }

            if ($un->fil_confidencialidad == 3) {
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewP icon\" />'";
            } else {
                //$json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/32/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"view icon\" />'";
                ///web/lib/32/document-". $una->fil_extension .".png'
            }

            
            $json .= ",'" . $un->fil_id . "'";                        
            $json .= ",'" . addslashes($un->fon_codigo) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->uni_descripcion)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->ser_categoria)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->exp_titulo)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->cue_descripcion)) . "'";            
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo . DELIMITER . $un->exp_codigo . DELIMITER . $un->cue_codigo .  DELIMITER . $un->fil_codigo) . "'";            
            $json .= ",'" . addslashes(utf8_decode($un->fil_titulo)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_proc)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_firma)) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_cargo)) . "'";
            $json .= ",'" . addslashes($un->fil_nrofoj) . "'";
            $json .= ",'" . addslashes($un->fil_nrocaj) . "'";
            $json .= ",'" . addslashes($un->fil_sala) . "'";
            $json .= ",'" . addslashes($un->fil_estante) . "'";
            $json .= ",'" . addslashes($un->fil_cuerpo) . "'";
            $json .= ",'" . addslashes($un->fil_balda) . "'";
            $json .= ",'" . addslashes($un->fil_tipoarch) . "'";
            $json .= ",'" . addslashes($un->fil_mrb) . "'";
            $json .= ",'" . addslashes($un->fil_ori) . "'";
            $json .= ",'" . addslashes($un->fil_cop) . "'";
            $json .= ",'" . addslashes($un->fil_fot) . "'";
            
            $json .= ",'" . addslashes($un->fil_nur) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_asunto)) . "'";
            
            $json .= ",'" . addslashes($un->disponibilidad) . "'";
            $json .= ",'" . addslashes(utf8_decode($un->fil_nomoriginal)) . "'";
            $json .= ",'" . addslashes($un->fil_tamano) . "'";            
            $json .= ",'" . addslashes(utf8_decode($un->fil_obs)) . "'";
            
            $json .= "]}";
            $rc = true;
            $i++;$j++;
        }
      
        $json .= "]\n";
          
        $json .= "}";
      
        echo $json;

    }
    
    
//    function setRequestTrim($request) {
//        $object = array();
//        /* foreach ( $request as $field => $value ) {
//          $request[$field] = html_entity_decode(trim($request[$field], ENT_QUOTES) );
//          //print($field."<br>");
//          }
//          return $object; */
//        $result['page'] = $_REQUEST["page"];
//        $result['rp'] = $_REQUEST["rp"];
//        $result['sortname'] = $_REQUEST["sortname"];
//        $result['sortorder'] = $_REQUEST["sortorder"];
//        
//        if (isset($_REQUEST["ser_id"])) {
//            $result['ser_id'] = html_entity_decode(trim($_REQUEST["ser_id"]), ENT_QUOTES);
//        }
//        if (isset($_REQUEST["tra_id"])) {
//            $result['tra_id'] = html_entity_decode(trim($_REQUEST["tra_id"]), ENT_QUOTES);
//        }
//        if (isset($_REQUEST["cue_id"])) {
//            $result['cue_id'] = html_entity_decode(trim($_REQUEST["cue_id"]), ENT_QUOTES);
//        }
//        
//        if (isset($_REQUEST["uni_id"])) {
//            $result['uni_id'] = html_entity_decode(trim($_REQUEST["uni_id"]), ENT_QUOTES);
//        }        
//        
//        return $result;
//    }


    function loadConfidencialidad($default = null) {
        if ($default == 1)
            $selected1 = ' selected';
        else
            $selected1 = '';
        if ($default == 2)
            $selected2 = ' selected';
        else
            $selected2 = '';
        if ($default == 3)
            $selected3 = ' selected';
        else
            $selected3 = '';
        //$res = '<option value="1" '.$selected1.'>PUBLICO</option>
        //       <option value="2" '.$selected2.'>RESTRINGIDO</option>
        //       <option value="3" '.$selected3.'>PRIVADO</option>';
        $res = '<option value="1" ' . $selected1 . '>PUBLICO</option>';
        return $res;
    }    

}

?>