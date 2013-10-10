<?php

/**
 * transferencia.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class transferencia extends tab_transferencia {

    function __construct() {
        $this->transferencia = new tab_transferencia ();
    }

    function count($where) {
        $num = 0;
        $sql = "SELECT count( DISTINCT tab_transferencia.trn_id) as num
            FROM
                tab_transferencia
                Inner Join tab_expediente te ON tab_transferencia.exp_id = te.exp_id
                Inner Join tab_series ON te.ser_id = tab_series.ser_id
                Inner Join tab_expfondo ef ON te.exp_id = ef.exp_id
                INNER JOIN tab_expusuario eu ON eu.exp_id=te.exp_id
                INNER JOIN tab_usuario u ON u.usu_id=eu.usu_id
                INNER JOIN tab_unidad un ON un.uni_id=u.uni_id
                INNER JOIN tab_usu_serie us2 ON us2.ser_id=tab_series.ser_id
                WHERE trn_estado = 1 AND
                tab_transferencia.trn_usuario_orig=u.usu_id AND
                eu.eus_estado =  '1' AND
                te.exp_estado =  '1' AND
                ef.exf_estado =  '1' AND
                    us2.use_estado =  '1' $where ";
        //print_r($sql);
        $num = $this->transferencia->countBySQL($sql);
        return $num;
    }

    
    function countTra($where) {
        $num = 0;
        $sql = "SELECT count( DISTINCT tab_transferencia.trn_id) as num
                FROM
                tab_usuario
                INNER JOIN tab_usu_serie ON tab_usuario.usu_id = tab_usu_serie.usu_id
                INNER JOIN tab_series ON tab_series.ser_id = tab_usu_serie.ser_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_expfondo.fon_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_transferencia ON tab_expediente.exp_id = tab_transferencia.exp_id
                WHERE
                tab_usuario.usu_id = " . $_SESSION['USU_ID'] . " 
                AND tab_usuario.usu_estado = 1
                AND tab_usu_serie.use_estado = 1
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_expfondo.exf_estado = 1
                AND tab_fondo.fon_estado = 1
                AND tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . " 
                AND tab_expusuario.eus_estado = 1
                $where ";
        $num = $this->transferencia->countBySQL($sql);
        return $num;
    }
    
    
    function countCo($where) {
        $num = 0;
        $sql = "SELECT count(tab_soltransferencia.str_id) as num
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
                INNER JOIN tab_exptransferencia ON tab_expediente.exp_id = tab_exptransferencia.exp_id
                INNER JOIN tab_soltransferencia ON tab_soltransferencia.str_id = tab_exptransferencia.str_id
                WHERE
                tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . "
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_usuario.usu_estado = 1
                AND tab_expfondo.exf_estado = 1                
                AND tab_expusuario.eus_estado = 2
                $where ";
        $num = $this->transferencia->countBySQL($sql);
        return $num;
    }

    function countFondo($where) {
        $num = 0;
        $sql = "SELECT COUNT(DISTINCT tt.trn_id) as num
                FROM
                tab_transferencia tt
                Inner Join tab_expediente te ON tt.exp_id = te.exp_id
                INNER JOIN tab_expfondo ef ON ef.exp_id=te.exp_id
                INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
                INNER JOIN tab_usuario tu ON tu.usu_id=tt.trn_usuario_des
                INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
                WHERE tt.trn_estado = 1 AND
                te.exp_estado =  '1' AND
                ef.exf_estado =  '1' $where
                GROUP BY
                tt.trn_usuario_orig,
                tt.trn_uni_origen,
                tt.trn_fecha_crea,
                tt.trn_confirmado ";
        //print_r($sql);
        $num = $this->transferencia->countBySQL($sql);
        return $num;
    }

    function countArchivo($where) {
        $num = 0;
        $sql = "SELECT count(DISTINCT tt.trn_id)
FROM tab_transferencia tt
Inner Join tab_expediente te ON tt.exp_id = te.exp_id
INNER JOIN tab_expfondo ef ON ef.exp_id=te.exp_id
INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
INNER JOIN tab_usuario tu ON tu.usu_id=tt.trn_usuario_orig
INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
INNER JOIN tab_fondo tf ON tf.fon_id = un.fon_id
                WHERE tt.trn_estado = 1 AND
                te.exp_estado =  '1' AND
                ef.exf_estado =  '1' $where
                GROUP BY
                tt.trn_fecha_crea,
                tt.trn_confirmado ";
        //print_r($sql);
        $num = $this->transferencia->countBySQL($sql);
        return $num;
    }

    function listaExpConfirmar($trn_confirmado, $trn_uni_origen, $trn_usuario_orig, $trn_fecha_crea) {
        $sql = "SELECT DISTINCT
            ee.exp_id,
            ee.ser_id,
            ee.exp_nombre,
            ee.exp_codigo,
            ee.exp_estado,
            ts.ser_categoria,
            ttu.usu_nombres,
            ttu.usu_apellidos,
            tr.trn_id,
            tun.uni_codigo,
            tun.uni_descripcion,
            tr.trn_usuario_des
            FROM
            tab_expediente AS ee
            Inner Join tab_transferencia AS tr ON ee.exp_id = tr.exp_id
            Inner Join tab_series AS ts ON ee.ser_id = ts.ser_id
            Inner Join tab_usuario AS ttu ON tr.trn_usuario_orig = ttu.usu_id
            Inner Join tab_unidad AS tun ON ttu.uni_id = tun.uni_id
            WHERE
            tr.trn_confirmado =  '$trn_confirmado' AND
            tr.trn_uni_origen =  '$trn_uni_origen' AND
            tr.trn_usuario_orig =  '$trn_usuario_orig' AND
            tr.trn_fecha_crea =  '$trn_fecha_crea' AND tr.trn_estado = '1'
            ORDER BY ee.exp_nombre ASC "; //print($sql);
        $tree = "";
        $expediente = new tab_expediente ();
        $rowExp = $expediente->dbSelectBySQL($sql);
        $trn_usuario_des = null;
        $i = 0;
        if (count($rowExp) == 0) {
            $tree .= "<tr><td colspan='3'>No existen expedientes en esta transferencia.</td></tr>";
        } else {
            foreach ($rowExp as $exp) {
                $tree .= "<tr><td><input type='checkbox' name='expedientes[$i]' id='chk-$exp->exp_id' value='$exp->exp_id' /></td>";
                $tree .= "<td><a href='#' class='expd' exp_id='$exp->exp_id' >$exp->exp_nombre</a></td>";
                $tree .= "<td>$exp->exp_codigo</td><td>$exp->ser_categoria</td>";
                $tree .= "</tr>";
                if ($trn_usuario_des != null) {
                    if ($trn_usuario_des != $exp->trn_usuario_des) {
                        $trn_usuario_des = '-1';
                    }
                }
                $trn_usuario_des = $exp->trn_usuario_des;
                $i++;
            }
        }
        $res[0] = count($rowExp);
        $res[1] = $tree;
        $res[2] = $trn_usuario_des;
        return $res;
    }

    function listaExpConfirmarPorFondo($trn_confirmado, $trn_fecha_crea) {
        $sql = "SELECT DISTINCT
            ee.exp_id,
            ee.ser_id,
            ee.exp_nombre,
            ee.exp_codigo,
            ee.exp_estado,
            ts.ser_categoria,
            tr.trn_usuario_orig,
            ttu.usu_nombres,
            ttu.usu_apellidos,
            tr.trn_id,
            ttu.uni_id,
            tun.uni_codigo,
            tun.uni_descripcion,
            tr.trn_usuario_des
            FROM
            tab_expediente AS ee
            Inner Join tab_transferencia AS tr ON ee.exp_id = tr.exp_id
            Inner Join tab_series AS ts ON ee.ser_id = ts.ser_id
            Inner Join tab_usuario AS ttu ON tr.trn_usuario_orig = ttu.usu_id
            Inner Join tab_unidad AS tun ON ttu.uni_id = tun.uni_id
            WHERE
            tr.trn_confirmado =  '$trn_confirmado' AND
            tr.trn_fecha_crea =  '$trn_fecha_crea' AND tr.trn_estado = '1'
            ORDER BY ee.exp_nombre ASC "; //print($sql);
        $tree = "";
        $expediente = new tab_expediente ();
        $rowExp = $expediente->dbSelectBySQL($sql);
        $trn_usuario_des = null;
        $i = 0;
        if (count($rowExp) == 0) {
            $tree .= "<tr><td colspan='3'>No existen expedientes en esta transferencia.</td></tr>";
        } else {
            foreach ($rowExp as $exp) {
                $tree .= "<tr><td><input type='checkbox' name='expedientes[$i]' id='chk-$exp->exp_id' value='$exp->exp_id' /></td>";
                $tree .= "<td><a href='#' class='expd' exp_id='$exp->exp_id' >$exp->exp_nombre</a></td>";
                $tree .= "<td>$exp->exp_codigo</td><td>$exp->ser_categoria</td>";
                $tree .= "</tr>";
                if ($trn_usuario_des != null) {
                    if ($trn_usuario_des != $exp->trn_usuario_des) {
                        $trn_usuario_des = '-1';
                    }
                }
                $trn_usuario_des = $exp->trn_usuario_des;
                $i++;
            }
        }
        $res[0] = count($rowExp);
        $res[1] = $tree;
        $res[2] = $trn_usuario_des;
        return $res;
    }

    function CantidadExpConfirmar($trn) {
        $sql = "SELECT
            ee.exp_id,
            ee.ser_id,
            ee.exp_nombre,
            ee.exp_codigo,
            ee.exp_estado,
            ts.ser_categoria,
            ttu.usu_nombres,
            ttu.usu_apellidos,
            tr.trn_id,
            tun.uni_codigo,
            tun.uni_descripcion
            FROM
            tab_expediente AS ee
            Inner Join tab_transferencia AS tr ON ee.exp_id = tr.exp_id
            Inner Join tab_series AS ts ON ee.ser_id = ts.ser_id
            Inner Join tab_usuario AS ttu ON tr.trn_usuario_orig = ttu.usu_id
            Inner Join tab_unidad AS tun ON ttu.uni_id = tun.uni_id
            WHERE
            tr.trn_id =  '$trn->trn_confirmado' AND
            tr.trn_uni_origen =  '$trn->trn_uni_origen' AND
            tr.trn_usuario_orig =  '$trn->trn_usuario_orig' AND
            tr.trn_fecha_crea =  '$trn->trn_fecha_crea' AND tr.trn_estado = '1' ";
        $tree = "";
        $expediente = new tab_expediente ();
        $rowExp = $expediente->dbSelectBySQL($sql);
        if (count($rowExp) == 0) {
            $tree .= "<tr><td colspan='3'><a href='#' class='suboptActx'>No existen expedientes en esta transferencia.</a></td></tr>";
        } else {
            foreach ($rowExp as $exp) {
                $tree .= "<tr><td><a href='#' class='suboptActx' exp_id='$exp->exp_id' >$exp->exp_nombre</a></td>";
                $tree .= "<td>$exp->exp_codigo</td><td>$exp->ser_categoria</td><td>$exp->uni_codigo</td>";
                $tree .= "</tr>";
            }
        }
        return $tree;
    }

}

?>