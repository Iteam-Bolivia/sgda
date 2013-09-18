<?php

/**
 * expediente.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expediente extends tab_expediente {

    function __construct() {
        $this->expediente = new tab_expediente ();
    }

    
    function obtenerCodigo($exp_id) {
        $codigo = '';
        $tab_expediente = new Tab_expediente();
        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo
                FROM
                tab_fondo
                INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
		WHERE tab_expediente.exp_estado = '1' 
                AND tab_expediente.exp_id ='" . $exp_id . "'  ";
        $expedientes = $tab_expediente->dbSelectBySQL($sql);        
        if (count($expedientes) > 0) {
            foreach ($expedientes as $expediente) {
                $codigo = $expediente->fon_cod . DELIMITER . $expediente->uni_cod . DELIMITER . $expediente->tco_codigo . DELIMITER . $expediente->ser_codigo . DELIMITER . $expediente->exp_codigo;
            }
        }
        return $codigo;
    }    
    function cantidadExpedientes($id){
    
        $sql="SELECT COUNT(tab_archivo.fil_titulo) as exp_cantidad
FROM
tab_expediente
INNER JOIN tab_exparchivo ON tab_exparchivo.exp_id = tab_expediente.exp_id
INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
WHERE
tab_expediente.exp_id  = $id";
      $result=$this->expediente->dbSelectBySQL($sql);
      $result=$result[0];
      return $result->exp_cantidad;
    }
    
    function obtenerSelectNivelDescripcion($default=null) {
        $option = "";
        if (!$default){
             $option ="<option value='EXPEDIENTE'>EXPEDIENTE</option>";
        }else{
            if ($default == 'EXPEDIENTE' ){
                $option ="<option value='EXPEDIENTE' selected>EXPEDIENTE</option>";                
            }
        }
        return $option;
    }
    
    // Nueva generación de codigo 
    function generaCodigo($ser_id) {
        $res = "";
        $this->expediente = new tab_expediente ();
        $sql = "SELECT 
                ser_contador
                FROM tab_series 
                WHERE ser_id = $ser_id
                ORDER BY 1 DESC 
                LIMIT 1 OFFSET 0";
        $result = $this->expediente->dbSelectBySQL($sql);
        if ($result != null) {
            foreach ($result as $row) {
                $res = $row->ser_contador + 1;
            }
        }        
        return $res;
    }
    
    function obtenerCustodios($exp_id) {
        $tusuario = new Tab_usuario();
        $sql = "SELECT
                tu.usu_id,
                tu.usu_nombres,
                tu.usu_apellidos
		FROM tab_usuario tu
		INNER JOIN tab_expusuario teu ON teu.usu_id=tu.usu_id
		WHERE teu.exp_id ='" . $exp_id . "' AND teu.eus_estado = '1' ";
        $users = $tusuario->dbSelectBySQL($sql);
        $nom = '';
        if (count($users) > 0) {
            foreach ($users as $user) {
                $nom .= $user->usu_nombres . " " . $user->usu_apellidos . ", ";
            }
        }
        $nom = substr($nom, 0, -2);
        return $nom;
    }

    function linkTreeReg($exp_id, $tra_id, $cue_id) {
        $expediente = new tab_expediente ();
        $tab_expediente = $expediente->dbselectById($exp_id);
        $serie = new series ();
        $tab_tramite = new Tab_tramite ();
        $tab_tramite = $tab_tramite->dbselectById($tra_id);
        $tab_cuerpo = new Tab_cuerpos ();
        $tab_cuerpo = $tab_cuerpo->dbselectById($cue_id);

        $flecha = "<img src='" . PATH_DOMAIN . "/web/img/arrow.png' width=\"12px\" height=\"12px\"/>";
        $serie_des = utf8_decode($serie->getTitle($tab_expediente->getSer_id()));
        $exp_des = utf8_decode($tab_expediente->getExp_nombre());
        $tramite = utf8_decode($tab_tramite->getTra_descripcion());
        $cuerpo = utf8_decode($tab_cuerpo->getCue_descripcion());

        return "<a href='" . PATH_DOMAIN . "/regularizar/'> $serie_des</a> $flecha
			<a href='" . PATH_DOMAIN . "/regularizar/viewTree/" . $exp_id . "/'> $exp_des</a> $flecha
			<a href='" . PATH_DOMAIN . "/regularizar/viewTree/" . $exp_id . "/'> $tramite </a> $flecha
                        <a href='" . PATH_DOMAIN . "/regularizar/viewTree/" . $exp_id . "/'> $tramite </a> $flecha
                        <a href='" . PATH_DOMAIN . "/regularizar/viewTree/" . $exp_id . "/'> $tramite </a> $flecha
			<a href='" . PATH_DOMAIN . "/regularizar/viewTree/$exp_id/'> $cuerpo </a> ";
    }

    function linkTree($exp_id, $tra_id, $cue_id) {
        $expediente = new tab_expediente ();
        $tab_expediente = $expediente->dbselectById($exp_id);
        
        $tab_expisadg = new tab_expisadg ();
        $expisadg = $tab_expisadg->dbselectById($exp_id);
        
        $serie = new series ();
        $tab_tramite = new Tab_tramite ();
        $tab_tramite = $tab_tramite->dbselectById($tra_id);
        $tab_cuerpo = new Tab_cuerpos ();
        $tab_cuerpo = $tab_cuerpo->dbselectById($cue_id);

        $flecha = "<img src='" . PATH_DOMAIN . "/web/img/arrow.png' width=\"12px\" height=\"12px\"/>";
        $serie_des = utf8_decode($serie->getTitle($tab_expediente->getSer_id()));
        $exp_des = utf8_decode($expisadg->getExp_titulo());
        $tramite = utf8_decode($tab_tramite->getTra_descripcion());
        $cuerpo = utf8_decode($tab_cuerpo->getCue_descripcion());

        return "<a href='" . PATH_DOMAIN . "/estrucDocumental/'> $serie_des</a> $flecha
                <a href='" . PATH_DOMAIN . "/estrucDocumental/viewTree/" . $exp_id . "/'> $exp_des</a> $flecha
                <a href='" . PATH_DOMAIN . "/estrucDocumental/viewTree/" . $exp_id . "/'> $tramite </a> $flecha
                <a href='" . PATH_DOMAIN . "/estrucDocumental/viewTree/$exp_id/'> $cuerpo </a> ";
    }

    function countField($value1) {
        $this->expediente = new tab_expediente ();
        if ($value1) {
            $sql = "SELECT
                    count(exp_id) as num
                    FROM tab_expediente
                    WHERE ser_id = '" . $value1 . "' and exp_estado = 1";
        } else {
            $sql = "SELECT
                    count(exp_id) as num
                    FROM tab_expediente
                    WHERE exp_estado = 1 ";
        }
        $num = $this->expediente->countBySQL($sql);
        return $num;
    }

    function countReg($where) {
        $this->expediente = new tab_expediente ();
        $num = 0;
        $sql = "SELECT COUNT(DISTINCT te.exp_id) as num
                from tab_expediente te
                INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
                INNER JOIN tab_expfondo ef ON te.exp_id=ef.exp_id
                INNER JOIN tab_expusuario eu ON eu.exp_id=te.exp_id
                INNER JOIN tab_transferencia tt ON tt.exp_id = te.exp_id
                INNER JOIN tab_usuario tu ON tu.usu_id=tt.trn_usuario_orig
                INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
                INNER JOIN tab_usu_serie us ON us.usu_id = tu.usu_id AND us.ser_id=ts.ser_id
                WHERE
                eu.usu_id = tt.trn_usuario_des AND
                eu.eus_estado =  '1' AND
                ef.exf_estado =  '1' AND
                te.exp_estado =  '1' AND
                us.use_estado =  '1' AND
                tt.trn_estado = '2' $where ";
        $num = $this->expediente->countBySQL($sql);
        return $num;
    }

    function countExp($where) {
        $this->expediente = new tab_expediente ();
        $num = 0;
        $sql = "SELECT count(tab_expediente.exp_id)
                FROM
                tab_usuario
                INNER JOIN tab_expusuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                INNER JOIN tab_expediente ON tab_expusuario.exp_id = tab_expediente.exp_id
                INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
                INNER JOIN tab_series ON tab_expediente.ser_id = tab_series.ser_id
                INNER JOIN tab_usu_serie ON tab_series.ser_id = tab_usu_serie.ser_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                WHERE tab_fondo.fon_estado = 1
                AND tab_unidad.uni_estado = 1
                AND tab_series.ser_estado = 1
                AND tab_tipocorr.tco_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_expisadg.exp_estado = 1
                AND tab_expfondo.exf_estado = 1
                AND tab_expusuario.eus_estado = 1
                $where ";
        $num = $this->expediente->countBySQL($sql);
        return $num;
    }

    
    function countExp2($where){
        $this->expediente = new tab_expediente ();
        $num = 0;        
        $sql = "SELECT COUNT(tab_fondo.fon_cod)
                FROM
                tab_unidad
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                WHERE
                tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . "
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_usuario.usu_estado = 1
                AND tab_expfondo.exf_estado = 1    
                $where ";
        $num = $this->expediente->countBySQL($sql);
        return $num;        
    }
    
    
    function countExp3($where){
        $this->expediente = new tab_expediente ();
        $num = 0;        
        $sql = "SELECT COUNT(tab_soltransferencia.str_id)
                FROM
                tab_soltransferencia
                WHERE 
                tab_soltransferencia.str_estado = 2 AND
                tab_soltransferencia.usud_id = " . $_SESSION['USU_ID'] . "  
                $where ";
        $num = $this->expediente->countBySQL($sql);
        return $num;        
    }
    
    function countExpAdm($where) {
        $this->expediente = new tab_expediente ();
        $num = 0;
        $sql = "SELECT count(DISTINCT te.exp_id) as num
                FROM tab_expediente te
                INNER JOIN tab_expfondo ef ON ef.exp_id=te.exp_id
                INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
                WHERE
                te.exp_estado =  '1' AND
                ef.exf_estado =  '1' $where ";
        $num = $this->expediente->countBySQL($sql);
        return $num;
    }

    function countPorFondo($where) {
        $this->expediente = new tab_expediente ();
        $num = 0;
        $sql = "SELECT COUNT(DISTINCT te.exp_id) as num
            FROM
            tab_expediente AS te
            Inner Join tab_expusuario AS eu ON eu.exp_id = te.exp_id
            Inner Join tab_series AS ts ON te.ser_id = ts.ser_id
            Inner Join tab_usuario AS tu ON eu.usu_id = tu.usu_id
            Inner Join tab_unidad AS un ON tu.uni_id = un.uni_id
            Inner Join tab_expfondo AS ef ON ef.exp_id = te.exp_id
            WHERE
            eu.eus_estado =  '1' AND
            te.exp_estado =  '1' AND
            ef.exf_estado =  '1' $where ";
        $num = $this->expediente->countBySQL($sql);
        return $num;
    }

    function countExpATransf($where, $fon_id) {
        $this->expediente = new tab_expediente ();
        $num = 0;
        $sql = "SELECT COUNT(DISTINCT te.exp_id) as num
                FROM tab_expediente te
                INNER JOIN tab_expfondo ef ON ef.exp_id=te.exp_id
                INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
                INNER JOIN tab_retdocumental ret ON ts.ser_id=ret.ser_id AND ret.fon_id='$fon_id'
                INNER JOIN tab_expusuario eu ON eu.exp_id=te.exp_id
                INNER JOIN tab_usuario tu ON tu.usu_id=eu.usu_id
                INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
                INNER JOIN tab_usu_serie us2 ON us2.ser_id=ts.ser_id
                WHERE
                eu.eus_estado =  '1' AND
                te.exp_estado =  '1' AND
                ef.exf_estado =  '1' AND
                us2.use_estado =  '1' $where";
        $num = $this->expediente->countBySQL($sql);
        return $num;
    }

    function countExpPrest($tipo, $value1, $adm) {
        $this->expediente = new tab_expediente ();
        $add = "";
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($tipo == 'exp_id')
                $where = " and te.exp_id = '$value1' ";
            elseif ($tipo == 'ser_categoria')
                $where = " and ts.ser_categoria LIKE '%$value1%' ";
            elseif ($tipo == 'exp_codigo')
                $where = " and te.exp_codigo LIKE '%$value1%' ";
            elseif ($tipo == 'exp_nombre')
                $where = " and te.exp_nombre LIKE '%$value1%' ";
            else
                $where = " and $tipo LIKE '%$value1%' ";
        }

        if ($adm) {
            $sql = "SELECT count(DISTINCT te.exp_id) as num
                    FROM tab_expediente te inner join tab_series ts on te.ser_id=ts.ser_id
                    WHERE te.exp_estado = '1' AND te.exp_id NOT IN(SELECT exp_id FROM tab_prestamos WHERE pre_estado='1') $where ";
        } else {
            $sql = "SELECT count(DISTINCT te.exp_id) as num
                    FROM tab_expediente te inner join tab_expusuario eu on eu.exp_id=te.exp_id
                    INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
                    WHERE eu.eus_estado='1' $where
                    and eu.usu_id='" . $_SESSION ['USU_ID'] . "'
                    AND exp_estado = '1'
                    AND te.exp_id NOT IN(SELECT exp_id FROM tab_prestamos WHERE pre_estado='1') ";
        }

        $num = $this->expediente->countBySQL($sql);
        return $num;
    }

    function searchTree($exp_id) {
        $tree = "";
        $this->usuario = new tab_usuario ();
        $this->tramite = new tab_tramite ();
        $this->expediente = new tab_expediente ();
        $this->cuerpos = new tab_cuerpos ();
        $row_usu = $this->usuario->dbselectByField("usu_id", $_SESSION ['USU_ID']);
        $this->usuario = $row_usu [0];
        $row = $this->expediente->dbselectByField("exp_id", $exp_id);
        if (is_null($row)) {
            $tree .= "<li><a href='#' onclick='return false;' class='suboptActx'>No existe tramites en esta SERIE</a></li>";
        } else {
            $row = $row [0];
            $ser_id = $row->ser_id;
            $rowt = $this->tramite->dbSelectBySQL("SELECT
                                                    tt.tra_id,
                                                    tt.tra_codigo,
                                                    tt.tra_descripcion,
                                                    st.ser_id
                                                    FROM tab_serietramite st
                                                    Inner Join tab_tramite tt ON st.tra_id = tt.tra_id
                                                    WHERE
                                                    st.ser_id =  '" . $ser_id . "' AND
                                                    st.sts_estado =  '1' AND
                                                    tt.tra_estado =  '1'
                                                    ORDER BY tt.tra_orden ASC");
            if (!is_null($rowt) && count($rowt)) {
                foreach ($rowt as $un) {
                    $rowc = $this->cuerpos->dbSelectBySQL("SELECT
                                                            tc.tra_id,
                                                            tc.trc_id,
                                                            cc.cue_id,
                                                            cc.cue_codigo,
                                                            cc.cue_descripcion
                                                            FROM
                                                            tab_tramitecuerpos tc
                                                            Inner Join tab_cuerpos cc ON tc.cue_id = cc.cue_id
                                                            WHERE
                                                            tc.trc_estado =  '1' AND
                                                            cc.cue_estado =  '1' AND
                                                            tc.tra_id =  '" . $un->tra_id . "'
                                                            ORDER BY cc.cue_orden ");

                    if (!is_null($rowc) && count($rowc)) {
                        $tree .= "<li><a href='#' onclick='return false;' di='" . $un->tra_id . "a' class='pagAct'>" . "&nbsp; " . $un->tra_descripcion . "</a> ";
                        $tree .= "<ul di='" . $un->tra_id . "aa'>";
                        foreach ($rowc as $unc) {
                            $tree .= "        <li>"
                                    . "<a href='#' onclick='return false;' id='" . $unc->cue_id . "-" . $un->tra_id . "' cue_id='" . $unc->cue_id . "' tra_id='" . $un->tra_id . "' >"
                                    . "<img src='" . PATH_DOMAIN . "/web/lib/32/document-add.png' tra='$un->tra_id' cue='$unc->cue_id' class='addFile icon' title='Adicionar documento'/>"
                                    . $unc->cue_descripcion . "</a>";
                            $tree .= "<ul id='" . $unc->cue_id . "-" . $un->tra_id . "x'>";
                            $sql = "SELECT
                            usu.uni_id,
                            usu.usu_id,
                            fil.fil_id,
                            fil.fil_titulo,
                            fil.fil_confidencialidad,
                            tab_archivo_digital.fil_nomoriginal,
                            tab_archivo_digital.fil_extension
                            FROM
                            tab_exparchivo AS exa
                            INNER JOIN tab_archivo AS fil ON exa.fil_id = fil.fil_id
                            INNER JOIN tab_expusuario AS eus ON exa.exp_id = eus.exp_id
                            INNER JOIN tab_usuario AS usu ON eus.usu_id = usu.usu_id
                            INNER JOIN tab_archivo_digital ON fil.fil_id = tab_archivo_digital.fil_id
                            WHERE exa.tra_id = '" . $un->tra_id . "' 
                            AND exa.cue_id = '" . $unc->cue_id . "' 
                            AND exa.exp_id = '" . VAR3 . "' 
                            AND eus.eus_estado = 1 
                            AND fil.fil_estado = 1 
                            AND usu.usu_estado = 1 
                            AND exa.exa_estado=1";

                            $rowa = $this->cuerpos->dbSelectBySQL($sql);
                            foreach ($rowa as $una) {
                                $verarch = "";
                                switch ($una->fil_confidencialidad) {
                                    case '1' :
                                        $verarch = '<li><a href="#" onclick="return false">';
                                        $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/document-add.png' tra='$un->tra_id' cue='$unc->cue_id' class='addFile icon' title='Adicionar documento'/>";
                                        if ($una->usu_id == $_SESSION ['USU_ID']) {
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/document-edit.png' file='$una->fil_id' class='updateFile icon' title='Editar Descripción del Documento'/>";
                                        }
                                        if ($una->usu_id == $_SESSION ['USU_ID']) {
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/document-delete.png' file='$una->fil_id' class='deleteFile icon' title='Borrar Documento'/>";
                                        }
                                        $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/b_view.png' file='$una->fil_id' restric='$una->fil_confidencialidad' class='view icon' title='Ver Datos Documento' />";
                                        $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/document-". $una->fil_extension .".png' file='$una->fil_id' restric='$una->fil_confidencialidad' class='viewFile icon' title='Ver Documento Digital'   />";                                        
                                        //$verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/document-view.png' file='$una->fil_id' class='viewFicha icon' title='Ver Ficha de Documento'/>";

                                        if ($una->usu_id == $_SESSION ['USU_ID']) {
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/print.png' file='$una->fil_id' class='printFile icon' title='Imprimir Marbete'/>";
                                        }                                        
                                        $verarch .= $una->fil_titulo . " (" . $una->fil_nomoriginal .")". '</a></li>';
                                        break;
                                    case '2' :
                                        if ($una->uni_id == $_SESSION ['UNI_ID']) {
                                            //$verarch = '<li><a class="suboptActBockA" href="#" onclick="return false">';
                                            $verarch = '<li><a href="#" onclick="return false">';
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/document-add.png' tra='$un->tra_id' cue='$unc->cue_id' class='addFile icon' title='Adicionar documento'/>";
                                            if ($una->usu_id == $_SESSION ['USU_ID']) {
                                                $verarch .="<img src='" . PATH_DOMAIN . "/web/lib/32/document-delete.png' file='$una->fil_id' class='deleteFile icon' />";
                                            }          
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/b_view.png' file='$una->fil_id' restric='$una->fil_confidencialidad' class='view icon' title='Ver Datos Documento'   />";
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/document-". $una->fil_extension .".png' file='$una->fil_id' restric='$una->fil_confidencialidad' class='viewFile icon' title='Ver Documento Digital'   />";                                        
                                            if ($una->usu_id == $_SESSION ['USU_ID']) {
                                                $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/print.png' file='$una->fil_id' class='printFile icon' title='Imprimir Marbete'/>";
                                            }
                                            $verarch .= $una->fil_titulo . " (" . $una->fil_nomoriginal .")". '</a></li>';
                                        } else {
                                            //$verarch = '<li><a class="suboptActBockA" href="#" onclick="return false">';
                                            $verarch = '<li><a href="#" onclick="return false">';
                                            $verarch .= $una->fil_titulo . " (" . $una->fil_nomoriginal .")". '</a></li>';
                                        }
                                        break;
                                    case '3' :
                                        if ($this->usuario->usu_leer_doc == '1' && $una->uni_id == $_SESSION ['UNI_ID']) {
                                            //$verarch = '<li><a class="suboptActBockB" class="linkPass" valueId="' . $una->fil_id . '" href="#" onclick="return false">' ;
                                            $verarch = '<li><a class="linkPass" valueId="' . $una->fil_id . '" href="#" onclick="return false">';
                                            if ($una->usu_id == $_SESSION ['USU_ID']) {
                                                $verarch .="<img src='" . PATH_DOMAIN . "/web/lib/32/delete-file-icon.png' file='$una->fil_id' class='deleteFile icon' />";
                                            }
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/b_view.png' file='$una->fil_id' restric='$una->fil_confidencialidad' class='view icon' title='Ver Datos Documento'   />";
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/document-". $una->fil_extension .".png' file='$una->fil_id' restric='$una->fil_confidencialidad' class='viewFile icon' title='Ver Documento'/>";
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/32/document-view.png' file='$una->fil_id' class='viewFicha icon' title='Ver Ficha del Documento'/>";
                                            $verarch .= $una->fil_titulo . " (" . $una->fil_nomoriginal .")". '</a></li>';
                                        } else {
                                            //$verarch = '<li><a class="suboptActBockA" href="#" onclick="return false">';
                                            $verarch = '<li><a href="#" onclick="return false">';
                                            if ($una->usu_id == $_SESSION ['USU_ID']) {
                                                $verarch .="<img src='" . PATH_DOMAIN . "/web/lib/32/delete-file-icon.png' file='$una->fil_id' class='deleteFile icon' />";
                                            }
                                            $verarch .= $una->fil_titulo . " (" . $una->fil_nomoriginal .")". '</a></li>';
                                        }
                                        break;
                                }
                                $tree .= $verarch;
                            }
                            $tree .= "</ul>";
                            $tree .= "</li>";
                        }
                        $tree .= "</ul>";
                        $tree .= "</li>";
                    }
                }
            } else {
                $tree .= "<li><a href='#' class='pagAct' onclick='return false'>No existe tramites en esta SERIE</a></li>";
            }
        }
        return $tree;
    }

    function searchTreeReg($exp_id) {
        $tree = "";
        $this->usuario = new tab_usuario ();
        $this->tramite = new tab_tramite ();
        $this->expediente = new tab_expediente ();
        $this->cuerpos = new tab_cuerpos ();
        $row_usu = $this->usuario->dbselectByField("usu_id", $_SESSION ['USU_ID']);
        $this->usuario = $row_usu [0];
        $row = $this->expediente->dbselectByField("exp_id", $exp_id);
        if (is_null($row)) {
            $tree .= "<li><a href='#' onclick='return false;' class='suboptActx'>No existe tramites en esta SERIE</a></li>";
        } else {
            $row = $row [0];
            $ser_id = $row->ser_id;
            $rowt = $this->tramite->dbSelectBySQL("SELECT 
                                                    tt.tra_id, 
                                                    tt.tra_codigo,
                                                    tt.tra_descripcion, 
                                                    st.ser_id
                                                    FROM tab_serietramite st
                                                    Inner Join tab_tramite tt ON st.tra_id = tt.tra_id
                                                    WHERE
                                                    st.ser_id =  '" . $ser_id . "' AND
                                                    st.sts_estado =  '1' AND
                                                    tt.tra_estado =  '1'
                                                    ORDER BY tt.tra_descripcion ASC");
            if (!is_null($rowt) && count($rowt)) {
                foreach ($rowt as $un) {
                    $rowc = $this->cuerpos->dbSelectBySQL("SELECT 
                                                            tc.tra_id, 
                                                            tc.trc_id, 
                                                            cc.cue_id, 
                                                            cc.cue_codigo, 
                                                            cc.cue_descripcion
                                                            FROM
                                                            tab_tramitecuerpos tc
                                                            Inner Join tab_cuerpos cc ON tc.cue_id = cc.cue_id
                                                            WHERE
                                                            tc.trc_estado =  '1' AND
                                                            cc.cue_estado =  '1' AND
                                                            tc.tra_id =  '" . $un->tra_id . "' ");

                    if (!is_null($rowc) && count($rowc)) {
                        $tree .= "<li><a href='#' onclick='return false;' di='" . $un->tra_id . "a' class='pagAct'>" . $un->tra_descripcion . "</a>";
                        $tree .= "<ul class='submenuarch " . $un->tra_id . "aa' di='" . $un->tra_id . "aa'>";
                        foreach ($rowc as $unc) {
                            $tree .= "        <li>"
                                    . "<a href='#' onclick='return false;' id='" . $unc->cue_id . "-" . $un->tra_id . "' cue_id='" . $unc->cue_id . "' tra_id='" . $un->tra_id . "' class='suboptAct'>"
                                    . "<img src='" . PATH_DOMAIN . "/web/lib/add-file-icon.png' tra='$un->tra_id' cue='$unc->cue_id' class='addFile icon' />"
                                    . $unc->cue_descripcion . "</a>";
                            $tree .= "<ul class='submenuarch' id='" . $unc->cue_id . "-" . $un->tra_id . "x'>";
                            $rowa = $this->cuerpos->dbSelectBySQL("SELECT
                                                                DISTINCT (tab_archivo.fil_id),
                                                                tab_archivo.fil_nomoriginal,
                                                                tab_archivo.fil_confidencialidad,
                                                                tab_exparchivo.uni_id
                                                                FROM
                                                                tab_exparchivo
                                                                Inner Join tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                                                                WHERE NOT(tab_archivo.fil_nomoriginal like '') 
                                                                AND tab_exparchivo.exp_id =  '" . VAR3 . "' 
                                                                AND tab_exparchivo.tra_id =  '" . $un->tra_id . "' 
                                                                AND tab_exparchivo.cue_id =  '" . $unc->cue_id . "' 
                                                                AND tab_exparchivo.uni_id IN (SELECT t.trn_uni_destino FROM tab_transferencia t WHERE t.exp_id = tab_exparchivo.exp_id AND t.trn_estado = '2')  
                                                                AND tab_exparchivo.exa_estado = '1' ");
                            foreach ($rowa as $una) {
                                $verarch = "";
                                switch ($una->fil_confidencialidad) {
                                    case '1' :
                                        $verarch = '<li><a class="suboptActBock" href="#" onclick="return false">';
                                        $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/b_view.png' file='$una->fil_id' restric='$una->fil_confidencialidad' class='viewFile icon' />";
                                        /* if ($una->usu_id == $_SESSION ['USU_ID']) {
                                          $verarch .= "<img src='".PATH_DOMAIN."/web/lib/delete-file-icon.png' file='$una->fil_id' class='deleteFile icon' />";
                                          } */
                                        $verarch .= $una->fil_nomoriginal . '</a></li>';
                                        break;
                                    case '2' :
                                        if ($una->uni_id == $_SESSION ['UNI_ID']) {
                                            $verarch = '<li><a class="suboptActBockA" href="#" onclick="return false">';
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/b_view.png' file='$una->fil_id' restric='$una->fil_confidencialidad' class='viewFile icon' />";
                                            /* if ($una->usu_id == $_SESSION ['USU_ID']) {
                                              $verarch .="<img src='".PATH_DOMAIN."/web/lib/delete-file-icon.png' file='$una->fil_id' class='deleteFile icon' />";
                                              } */
                                            $verarch .= $una->fil_nomoriginal . '</a></li>';
                                        } else {
                                            $verarch = '<li><a class="suboptActBockA" href="#" onclick="return false">';
                                            $verarch .= $una->fil_nomoriginal . '</a></li>';
                                        }
                                        break;
                                    case '3' :
                                        if ($this->usuario->usu_leer_doc == '1' && $una->uni_id == $_SESSION ['UNI_ID']) {
                                            $verarch = '<li><a class="suboptActBockB" class="linkPass" valueId="' . $una->fil_id . '" href="#" onclick="return false">';
                                            $verarch .= "<img src='" . PATH_DOMAIN . "/web/lib/b_view.png' file='$una->fil_id' restric='$una->fil_confidencialidad' class='viewFileP icon' />";
                                            /* if ($una->usu_id == $_SESSION ['USU_ID']) {
                                              $verarch .="<img src='".PATH_DOMAIN."/web/lib/delete-file-icon.png' file='$una->fil_id' class='deleteFile icon' />";
                                              } */
                                            $verarch .= $una->fil_nomoriginal . '</a></li>';
                                        } else {
                                            $verarch = '<li><a class="suboptActBockA" href="#" onclick="return false">';
                                            /* if ($una->usu_id == $_SESSION ['USU_ID']) {
                                              $verarch .="<img src='".PATH_DOMAIN."/web/lib/delete-file-icon.png' file='$una->fil_id' class='deleteFile icon' />";
                                              } */
                                            $verarch .= $una->fil_nomoriginal . '</a></li>';
                                        }
                                        break;
                                }
                                $tree .= $verarch;
                            }
                            $tree .= "</ul>";
                            $tree .= "</li>";
                        }
                        $tree .= "</ul>";
                        $tree .= "</li>";
                    }
                }
            } else {
                $tree .= "<li><a href='#' onclick='return false' class='pagAct'>No existe tramites en esta SERIE</a></li>";
            }
        }
        return $tree;
    }

    function searchcoTree($exp_id) {
        $exp = new expediente ();
        $tree = "";
        $this->series = new series ();
        $this->usuario = new tab_usuario ();
        $this->tramite = new tab_tramite ();
        $this->expediente = new tab_expediente ();
        $this->cuerpos = new tab_cuerpos ();
        $row_usu = $this->usuario->dbselectByField("usu_id", $_SESSION ['USU_ID']);
        $this->usuario = $row_usu [0];
        $row = $this->expediente->dbselectByField("exp_id", $exp_id);
        if (!is_null($row)) {
            $row = $row [0];
            $ser_id = $row->ser_id;
            //$tree .= "<li><a href='".PATH_DOMAIN."/".VAR1."/".VAR2."/".VAR3."/'  onclick='return false;' >".$this->series->getTitle($ser_id)." - ".$row->exp_nombre."</a>";
            $rowt = $this->tramite->dbSelectBySQL("SELECT 
                                                tt.tra_id, 
                                                tt.tra_codigo,
                                                tt.tra_descripcion, 
                                                st.ser_id
                                                FROM tab_serietramite st
                                                Inner Join tab_tramite tt ON st.tra_id = tt.tra_id
                                                WHERE
                                                st.ser_id =  '" . $ser_id . "' AND
                                                st.sts_estado =  '1' AND
                                                tt.tra_estado =  '1' AND
                                                tt.tra_id IN  (SELECT
                                                exa.tra_id
                                                FROM
                                                tab_exparchivo AS exa
                                                WHERE
                                                exa.exp_id =  '$exp_id' AND exa_estado = '1')
                                                ORDER BY tt.tra_descripcion ASC");
            foreach ($rowt as $un) {
                $sql = "SELECT
                        trc.tra_id,
                        trc.trc_estado,
                        trc.trc_id,
                        tc.cue_id,
                        tc.cue_codigo,
                        tc.cue_descripcion,
                        tc.cue_estado
                        FROM
                        tab_tramitecuerpos AS trc
                        Inner Join tab_cuerpos AS tc ON trc.cue_id = tc.cue_id
                        WHERE
                        trc.trc_estado =  '1' AND
                        tc.cue_estado =  '1' AND
                        trc.tra_id =  '$un->tra_id' AND
                        tc.cue_id IN (SELECT exa.cue_id FROM tab_exparchivo AS exa WHERE exa.tra_id = '$un->tra_id' AND exa.exp_id = '$exp_id' AND exa.exa_estado = 1)";

                $rowc = $this->cuerpos->dbSelectBySQL($sql);
                if (!is_null($rowc) && count($rowc)) {
                    $treeT = "<li><a href='#' di='" . $un->tra_id . "a' onclick='return false;' class='pagAct'>" . $un->tra_descripcion . "</a>";
                    $tree .= "<li><a href='#' di='" . $un->tra_id . "a' onclick='return false;' class='pagAct'>" . $un->tra_descripcion . "</a>";
                    $tree .= "<ul class='submenuarch " . $un->tra_id . "aa' style='display:none;' di='" . $un->tra_id . "aa'>";
                    $treeSW = false;
                    $treeCc = "";
                    foreach ($rowc as $unc) {
                        $treeCc .= "        <li><a href='#' onclick='return false;' id='" . $unc->cue_id . "' class='suboptAct'>" . $unc->cue_descripcion . "</a>";
                        $treeCc .= "        </li>";
                        $tree .= "<li><a href='#' onclick='return false;' id='" . $unc->cue_id . "' class='suboptAct'>" . $unc->cue_descripcion . "</a></li>";
                    }
                    $tree .= "</ul></li>";
                }
            }
        }
        return $tree;
    }

    function linkTreeUno($exp_id) {
        $exp = new expediente ();
        $tree = "";
        $this->series = new series ();
        $this->tramite = new tab_tramite ();
        $this->expediente = new tab_expediente ();
        $this->cuerpos = new tab_cuerpos ();
        $row = $this->expediente->dbselectByField("exp_id", $exp_id);
        if (is_null($row)) {
            return $tree;
        } else {
            $row = $row [0];
            $ser_id = $row->ser_id;

            // Expisag
            $tab_expisadg = new Tab_expisadg();
            $row2 = $tab_expisadg->dbselectByField("exp_id", $exp_id);
            $row2 = $row2 [0];
            
            $pathAnterior = PATH_DOMAIN . "/" . VAR1 . "/";
            $titulo = $this->series->getTitle($ser_id);
            $nuevoEnlace = $row2->exp_titulo;
            $pathActual = PATH_DOMAIN . "/" . VAR1 . "/" . VAR2 . "/" . VAR3;
            return array($pathAnterior, $titulo, $pathActual, $nuevoEnlace);
        }
    }

    function linkTreeDos($exp_id) {
        $exp = new expediente ();
        $tree = "";
        $this->series = new series ();
        $this->tramite = new tab_tramite ();
        $this->expediente = new tab_expediente ();
        $this->cuerpos = new tab_cuerpos ();
        $row = $this->expediente->dbselectByField("exp_id", $exp_id);
        if (is_null($row)) {
            return $tree;
        } else {
            $rowc = $this->cuerpos->dbSelectBySQL("SELECT *
                                                    FROM
                                                    tab_cuerpos
                                                    WHERE
                                                    tab_cuerpos.cue_estado =  '1' 
                                                    AND tab_cuerpos.cue_id =  '" . VAR5 . "'");
            if (!is_null($rowc) && count($rowc)) {
                $nuevoEnlace = $rowc [0]->cue_descripcion;
            }
            $rowt = $this->cuerpos->dbSelectBySQL("SELECT *
                                                    FROM
                                                    tab_tramite
                                                    WHERE
                                                    tra_estado =  '1' 
                                                    AND tra_id =  '" . VAR4 . "'");
            if (!is_null($rowt) && count($rowt)) {
                $tramite = $rowt [0]->tra_descripcion;
            }

            $row = $row [0];
            $ser_id = $row->ser_id;
            $pathAnteAnterior = PATH_DOMAIN . "/" . VAR1 . "/";
            $tituloAnterior = $this->series->getTitle($ser_id);
            $pathAnterior = PATH_DOMAIN . "/" . VAR1 . "/viewTree/" . VAR3 . "/";
            $titulo = $row->exp_nombre;
            $pathActual = PATH_DOMAIN . "/" . VAR1 . "/uploadField/" . VAR3 . "/" . VAR4 . "/" . VAR5 . "/";

            if (strlen($tramite) > 60) {
                $tramite = substr($tramite, 0, 70);
                $tramite = $tramite . "...";
            }
            if (strlen($nuevoEnlace) > 60) {
                $nuevoEnlace = substr($nuevoEnlace, 0, 70);
                $nuevoEnlace = $nuevoEnlace . "...";
            }

            return array($pathAnteAnterior, $tituloAnterior, $pathAnterior, $titulo, $pathActual, $tramite, $nuevoEnlace);
        }
    }

    function linkTreeTres($exp_id, $enlaceAnterior) {

        $exp = new expediente ();
        $tree = "";
        $this->series = new series ();
        $this->tramite = new tab_tramite ();
        $this->expediente = new tab_expediente ();
        $this->cuerpos = new tab_cuerpos ();
        $row = $this->expediente->dbselectByField("exp_id", $exp_id);
        if (is_null($row)) {
            return $tree;
        } else {
            $rowc = $this->cuerpos->dbSelectBySQL("SELECT *
                                                    FROM
                                                    tab_cuerpos
                                                    WHERE
                                                    tab_cuerpos.cue_estado =  '1' 
                                                    AND tab_cuerpos.cue_id =  '" . VAR5 . "'");
            if (!is_null($rowc) && count($rowc)) {
                $cuerpo = $rowc [0]->cue_descripcion;
            }
            $rowt = $this->tramite->dbSelectBySQL("SELECT *
                                                    FROM
                                                    tab_tramite
                                                    WHERE
                                                    tra_estado =  '1' 
                                                    AND tra_id =  '" . VAR4 . "'");
            if (!is_null($rowt) && count($rowt)) {
                $tramite = $rowt [0]->tra_descripcion;
            }
            if (VAR1 == "archivo") {
                $var1 = "estrucDocumental";
                $enlace = "Cargar Archivo";
            } else {
                $var1 = VAR1;
                $enlace = "Correspondencia";
            }
            $row = $row [0];
            $ser_id = $row->ser_id;
            $pathAnteAnterior = PATH_DOMAIN . "/" . $var1 . "/";
            $tituloAnterior = $this->series->getTitle($ser_id);
            $pathAnterior = PATH_DOMAIN . "/" . $var1 . "/viewTree/" . VAR3 . "/";
            $titulo = $row->exp_nombre;
            $pathActual = PATH_DOMAIN . "/" . $var1 . "/" . $enlaceAnterior . "/" . VAR3 . "/" . VAR4 . "/" . VAR5 . "/";
            $nuevoEnlace = $enlace;

            if (strlen($tramite) >= 30) {
                $tramite = substr($tramite, 0, 30);
                $tramite = $tramite . "...";
            }
            if (strlen($cuerpo) >= 60) {
                $cuerpo = substr($cuerpo, 0, 70);
                $cuerpo = $cuerpo . "...";
            }
            if (strlen($nuevoEnlace) > 60) {
                $nuevoEnlace = substr($nuevoEnlace, 0, 70);
                $nuevoEnlace = $nuevoEnlace . "...";
            }
            return array($pathAnteAnterior, $tituloAnterior, $pathAnterior, $titulo, $pathActual, $tramite, $cuerpo, $nuevoEnlace);
        }
    }

    function linkExp($exp_id) {

        $exp = new expediente ();
        $tree = "";
        $this->series = new tab_series ();
        $this->tramite = new tab_tramite ();
        $this->expediente = new tab_expediente ();
        $this->cuerpos = new tab_cuerpos ();
        $row = $this->expediente->dbselectByField("exp_id", $exp_id);
        if (is_null($row)) {
            return $tree;
        } else {
            $rowc = $this->cuerpos->dbSelectBySQL("SELECT DISTINCT
                                                    tab_cuerpos.cue_descripcion,
                                                    tab_tramite.tra_descripcion,
                                                    tab_series.ser_categoria,
                                                    tab_expediente.exp_nombre
                                                    FROM
                                                    tab_cuerpos Inner Join tab_exparchivo on
                                                    tab_cuerpos.cue_id=tab_exparchivo.cue_id
                                                    Inner Join tab_tramite on
                                                    tab_tramite.tra_id=tab_exparchivo.tra_id
                                                    Inner Join tab_series on
                                                    tab_series.ser_id=tab_exparchivo.ser_id
                                                    Inner Join tab_expediente on
                                                    tab_expediente.exp_id=tab_exparchivo.exp_id
                                                    WHERE tab_cuerpos.cue_estado =  '1' 
                                                    AND tab_tramite.tra_estado =  '1' 
                                                    AND tab_series.ser_estado =  '1' 
                                                    AND tab_exparchivo.exa_estado =  '1' 
                                                    AND tab_expediente.exp_estado =  '1' 
                                                    AND tab_exparchivo.exp_id =  '" . $exp_id . "'");
            if (!is_null($rowc) && count($rowc)) {
                $cuerpo = $rowc [0]->cue_descripcion;
                $tramite = $rowc [0]->tra_descripcion;
                $serie = $rowc [0]->ser_categoria;
                $titulo = $rowc [0]->exp_nombre;
            }

            if (strlen($serie) >= 50) {
                $serie = substr($serie, 0, 50);
                $serie = $serie . "...";
            }
            if (strlen($tramite) >= 30) {
                $tramite = substr($tramite, 0, 30);
                $tramite = $tramite . "...";
            }
            if (strlen($cuerpo) >= 60) {
                $cuerpo = substr($cuerpo, 0, 70);
                $cuerpo = $cuerpo . "...";
            }
            if (strlen($titulo) > 60) {
                $titulo = substr($titulo, 0, 70);
                $titulo = $titulo . "...";
            }
            return array($serie, $titulo, $tramite, $cuerpo);
        }
    }

    function obtenerSelectExp($default = null) {
        $this->expediente = new tab_expediente();
        $exp = "";
        $rows = $this->expediente->dbSelectBySQL("SELECT *
                                                  FROM tab_expediente
                                                  ORDER BY exp_descripcion ASC");
        foreach ($rows as $m) {
            if ($default == $m->exp_id)
                $selected = "selected";
            else
                $selected = "";
            $exp .="<option value='" . $m->exp_id . "' " . $selected . " >" . $m->exp_nombre . "</option>";
        }
        return $exp;
    }

    function dameDatosExp($exp_id) {
        $this->expediente = new tab_expediente();
        $rows = $this->expediente->dbSelectBySQL("SELECT *
                                                  FROM tab_expediente
                                                  WHERE exp_id='" . $exp_id . "' ");
        return $rows;
    }

    function countSinInv($where) {
        $this->expediente = new Tab_expediente();
        $sql = "SELECT COUNT(DISTINCT E.exp_id) as num
                FROM tab_expediente E
                INNER JOIN tab_expfondo ef ON ef.exp_id = E.exp_id
                INNER JOIN tab_expusuario eu ON eu.exp_id = E.exp_id
                INNER JOIN tab_series s ON s.ser_id = E.ser_id
                WHERE E.exp_estado='1' 
                AND ef.exf_estado = '1' 
                AND E.exp_id NOT IN(SELECT i.exp_id FROM tab_inventario i WHERE i.inv_estado ='1' AND i.exp_id=E.exp_id ) 
                AND eu.eus_estado = '1' $where ";
        $num = 0;
        $num = $this->expediente->countBySQL($sql);
        return $num;
    }

    function getConvenios($codigo, $tipo) {
        $sisfin = new dim_sisfin();
        $sql = " ";
        if ($tipo == 'SISIN')
            $sql = "SELECT DISTINCT *
                    FROM dim_sisfin f
                    WHERE f.numconv IN(SELECT num_conv FROM dim_sisfin_sisin WHERE codigo_sisin='$codigo')
                    OR f.numconv IN(SELECT num_conv FROM dim_cif_sisfin_sisin WHERE codigo_sisin='$codigo')";
        elseif ($tipo == 'CIF')
            $sql = "SELECT *
                    FROM dim_sisfin f
                    WHERE f.numconv IN(SELECT num_conv FROM dim_cif_sisfin_sisin WHERE codigo_cif='$codigo') ";
        //print($sql);
        $rows = $sisfin->dbSelectBySQL($sql);
        $detalle = "";
        foreach ($rows as $sisfin) {
            $detalle .= '<tr><td><a href="' . PATH_DOMAIN . '/' . VAR1 . '/">' . $sisfin->numconv . '</a></td><td>' . $sisfin->codage . '</td><td>' . $sisfin->nomconv;
            $detalle .= '</td><td>' . $sisfin->fechcont . '</td><td>' . $sisfin->numcont . '</td></tr>';
        }
        if ($detalle == '')
            $detalle = '<tr><td colspan="5">No existen Convenios para este Expediente </td><tr>';
        return $detalle;
    }

    function getUbicacion($exp_id) {
        $expediente = new tab_expediente();
        $sql = "SELECT 
                exc.exp_id,
                con.con_codigo,
                suc.suc_codigo,
                ctp.ctp_codigo
                FROM tab_expcontenedor AS exc 
                INNER JOIN tab_subcontenedor AS suc ON exc.suc_id = suc.suc_id
                INNER JOIN tab_contenedor AS con ON suc.con_id = con.con_id 
                INNER JOIN tab_tipocontenedor AS ctp ON con.ctp_id = ctp.ctp_id
                WHERE exc.exp_id = '$exp_id' 
                AND exc.exc_estado = 1 ";
        $rows = $expediente->dbSelectBySQL($sql);
        $detalle = "";
        foreach ($rows as $exp) {
            $detalle .= $exp->ctp_codigo . ' - ' . $exp->con_codigo;
            $detalle .= ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $detalle .= '<strong> Sub Contendedor: </strong>';
            $detalle .= $exp->suc_codigo;
        }
        return $detalle;
    }

    function getDetalles($id) {
        $expediente = new expediente();
        $det = "";
        $tab_expediente = new Tab_expediente();
        $rows = $tab_expediente->dbselectByField("exp_id", $id);
        if (count($rows) == 1) {
            $tab_expediente = $rows[0];
            
            // Expediente ISAD-G
            $tab_expisadg = new Tab_expisadg();
            $rows2 = $tab_expisadg->dbselectByField("exp_id", $id);
            $tab_expisadg = $rows2[0];            
            
            // Campos especiales
            // Include dynamic fields
            $expcampo = new expcampo();        
            $expadicional = $expcampo->obtenerSelectCamposMostrar($tab_expediente->ser_id, $tab_expediente->exp_id);            
            
            $det.= '<tr><td><strong>C&oacute;digo:</strong></td><td colspan="3">' . $expediente->obtenerCodigo($id) . '</td></tr>'
                    . '<tr><td><strong>Fecha Inicial:</strong></td><td colspan="3">' . $tab_expisadg->exp_fecha_exi . '</td></tr>'
                    . '<tr><td><strong>Fecha Final:</strong></td><td colspan="3">' . $tab_expisadg->exp_fecha_exf . '</td></tr>'
                    . '<tr><td>Datos adicionales:</td><td colspan="3"></td></tr>'
                    . $expadicional 
                    . '<tr><td>Unidad de instalaci&oacute;n:</td><td colspan="3"></td></tr>'
                    . '<tr><td><strong>Sala:</strong></td><td colspan="3">' . $tab_expediente->exp_sala . '</td></tr>'
                    . '<tr><td><strong>Estante:</strong></td><td colspan="3">' . $tab_expediente->exp_estante . '</td></tr>'
                    . '<tr><td><strong>Cuerpo:</strong></td><td colspan="3">' . $tab_expediente->exp_cuerpo . '</td></tr>'
                    . '<tr><td><strong>Balda:</strong></td><td colspan="3">' . $tab_expediente->exp_balda . '</td></tr>';
        }
        return $det;
    }

    function obtenerDatos($exp_id, $usu_id = null) {
        $this->expediente = new tab_expediente();
        $where = "";
        if ($usu_id != null) {
            $where .= " AND eu.usu_id = '$usu_id'";
        }
        $sql = "SELECT DISTINCT
                ee.exp_id,
                ee.ser_id,
                ee.exp_nombre,
                ee.exp_descripcion,
                ee.exp_codigo,
                uu.usu_nombres,
                uu.usu_apellidos,
                uu.usu_id,
                unn.uni_codigo,
                unn.uni_id
                FROM
                tab_expediente AS ee
                Inner Join tab_expusuario AS eu ON eu.exp_id = ee.exp_id
                Inner Join tab_usuario AS uu ON uu.usu_id = eu.usu_id
                Inner Join tab_unidad AS unn ON unn.uni_id = uu.uni_id
                WHERE
                eu.eus_estado =  '1' 
                AND ee.exp_estado = '1' 
                AND ee.exp_id = '$exp_id' $where ";
        $rows = $this->expediente->dbSelectBySQL($sql);
        if (count($rows)) {
            if (count($rows) > 1) {
                $rows[0]->usu_nombres = "VARIOS";
                $rows[0]->usu_apellidos = "";
                $rows[0]->uni_codigo = "VARIOS";
            }
        }
        return $rows[0];
    }

    function getProductor($exp_id) {
        $this->expediente = new tab_expediente();
        $sql = "SELECT DISTINCT
                ee.exp_id,
                ee.ser_id,
                ee.exp_nombre,
                ee.exp_descripcion,
                ee.exp_codigo,
                uu.usu_nombres,
                uu.usu_apellidos,
                uu.usu_id,
                unn.uni_codigo,
                unn.uni_id
                FROM
                tab_expediente AS ee
                Inner Join tab_expusuario AS eu ON eu.exp_id = ee.exp_id
                Inner Join tab_usuario AS uu ON uu.usu_id = eu.usu_id
                Inner Join tab_expunidad AS exu ON exu.exp_id = ee.exp_id
                Inner Join tab_unidad AS unn ON unn.uni_id = exu.uni_id
                WHERE
                eu.eus_estado = '2' 
                AND uu.rol_id='2' 
                AND ee.exp_id = '$exp_id'
                ORDER BY eu.eus_fecha_crea DESC";
        $rows = $this->expediente->dbSelectBySQL($sql);
        if (count($rows) > 0)
            return $rows[0];
        else
            return null;
    }

    function existeCodigo($exp_cod, $ser_id) {
        $this->expediente = new tab_expediente();
        $sql = "SELECT DISTINCT
                ee.exp_codigo
                FROM
                tab_expediente AS ee
                WHERE
                ee.exp_codigo = '$exp_cod' 
                AND ee.ser_id='$ser_id' "; 
        $rows = $this->expediente->dbSelectBySQL($sql);
        if (count($rows) > 0)
            return true;
        else
            return false;
    }

    function listExpediente($exp_id, $default = null) {
        $add = "";
        if ($exp_id != '0') {
            $add = " AND exp_id='$exp_id' ";
        }
        $row = $this->expediente->dbselectBySQL("SELECT *
                                                FROM tab_expediente
                                                WHERE exp_estado = 1 $add
                                                ORDER BY exp_nombre");
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->exp_id)
                $selected = "selected";
            else
                $selected = " ";
            $option .="<option value='" . $val->exp_id . "' $selected>" . $val->exp_nombre . "</option>";
        }
        return $option;
    }

    
    
    function obtenerExpUsuarioId($exp_id) {
        $expusuario = new Tab_expusuario();
        $sql = "SELECT
                eus_id
		FROM tab_expusuario
		WHERE tab_expusuario.exp_id ='" . $exp_id . "' AND tab_expusuario.eus_estado = '1' ";
        $expusu = $expusuario->dbSelectBySQL($sql);
        $eus_id = 0;
        if (count($expusu) > 0) {
            foreach ($expusu as $expusu2) {
                $eus_id = $expusu2->eus_id;
            }
        }
        return $eus_id;
    }

    function obtenerExpUsuarioIdConfirmacion($exp_id) {
        $expusuario = new Tab_expusuario();
        $sql = "SELECT
                eus_id
		FROM tab_expusuario
		WHERE tab_expusuario.exp_id ='" . $exp_id . "' AND tab_expusuario.eus_estado = '3' ";
        $expusu = $expusuario->dbSelectBySQL($sql);
        $eus_id = 0;
        if (count($expusu) > 0) {
            foreach ($expusu as $expusu2) {
                $eus_id = $expusu2->eus_id;
            }
        }
        return $eus_id;
    }    
    
    
    function obtenerExpFondoId($exp_id) {
        $expfondo = new Tab_expfondo();
        $sql = "SELECT
                exf_id
		FROM tab_expfondo
		WHERE tab_expfondo.exp_id ='" . $exp_id . "' AND tab_expfondo.exf_estado = '1' ";
        $expfon = $expfondo->dbSelectBySQL($sql);
        $exf_id = 0;
        if (count($expfon) > 0) {
            foreach ($expfon as $expfon2) {
                $eus_id = $expfon2->eus_id;
            }
        }
        return $exf_id;
    }
    
    function obtenerSucId($exp_id) {
        $tab_expediente = new Tab_expediente();
        $sql = "select suc_id from tab_expcontenedor where exp_id=$exp_id AND exc_estado = 1 ";
        $expfon = $tab_expediente->dbSelectBySQL($sql);
        $suc_id = 0;
        if (count($expfon) > 0) {
            foreach ($expfon as $expfon2) {
                $suc_id = $expfon2->suc_id;
            }
        }
        return $suc_id;
    }
    
    
    function obtenerSelectMes($default=null) {
        $meses = "ENE,FEB,MAR,ABR,MAY,JUN,JUL,AGO,SEP,OCT,NOV,DIC";
        $mes = explode(",",$meses);
        $option = "";
       for($i=0;$i<count($mes);$i++){
           if ($default == $mes[$i] ){
                $option .="<option value='" . $mes[$i] . "' selected>" . $mes[$i] . "</option>";
           }else{
               $option .="<option value='" . $mes[$i] . "'>" . $mes[$i] . "</option>";
           }
        }                
        return $option;
    }   
    
    
    function obtenerSelectAnio($default=null) {
        $anios = "";
        for($i=1950;$i<2050;$i++){
            $anios .= $i . ",";
        }        
        $anios = substr($anios, 0, -1);        
        $anio = explode(",",$anios);
        $option = "";
       for($i=0;$i<count($anio);$i++){
           if ($default == $anio[$i] ){
                $option .="<option value='" . $anio[$i] . "' selected>" . $anio[$i] . "</option>";
           }else{
               $option .="<option value='" . $anio[$i] . "'>" . $anio[$i] . "</option>";
           }
        }                
        return $option;
    }    
 
    
    
    function obtenerSelectEstado($default = null) {
        $fondos = "<option value='BUENO'>BUENO</option><option value='MALO'>MALO</option><option value='REGULAR'>REGULAR</option>";
        if ($default == "BUENO") {
            $fondos = "<option value='BUENO' selected>BUENO</option><option value='MALO'>MALO</option><option value='REGULAR'>REGULAR</option>";
        } else if ($default == "MALO") {
            $fondos = "<option value='BUENO'>BUENO</option><option value='MALO' selected>MALO</option><option value='REGULAR'>REGULAR</option>";
        } else if ($default == "REGULAR"){
            $fondos = "<option value='BUENO'>BUENO</option><option value='MALO'>MALO</option><option value='REGULAR' selected>REGULAR</option>";
        }
        return $fondos;
    }    
    
    function obtenerSelectProductor($default = null) {
        $select = "<option value='ABC' selected>ABC</option><option value='SNC'>SNC</option>";
        if ($default == "ABC") {
            $select = "<option value='ABC' selected>ABC</option><option value='SNC'>SNC</option>";
        } else if ($default == "SNC") {
            $select = "<option value='ABC'>ABC</option><option value='SNC' selected>SNC</option>";
        }
        return $select;
    }      
    
    
}

?>
