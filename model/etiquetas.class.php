<?php

/**
 * etiquetas.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class etiquetas extends tab_etiquetas {

    function __construct() {
        $this->etiquetas = new tab_etiquetas();
    }

    //ERROR EN ETIQUETAS
    function loadFolder() {
        $usu_id = $_SESSION['USU_ID'];
        if ($_SESSION['ROL_COD'] == 'ACEN')
            $fondo = '3';
        elseif ($_SESSION['ROL_COD'] == 'SUBF')
            $fondo = '2';
        else
            $fondo = '1';

        // Se reemplazo ttun.uni_codigo por  ttun.uni_codigo

        $sql = "
SELECT DISTINCT
        tun.uni_par,
	    (SELECT ttun.uni_id FROM tab_unidad AS ttun WHERE ttun.uni_id =  tun.uni_par) as direccion,
            tun.uni_id,tun.uni_codigo,ts.ser_id,ts.ser_categoria,ete.ete_id,te.exp_nombre,
            te.exp_id,ete.suc_id,te.exp_codigo,tef.fon_id,tef.exf_fecha_exi,
            tef.exf_fecha_exf,
            (SELECT DISTINCT exc.suc_id FROM tab_expcontenedor AS exc
            WHERE exc.exc_estado =  '1' and exc.exp_id =  te.exp_id 
            ) as suc_id
            FROM
            tab_etiquetas AS ete
            Inner Join tab_expediente AS te ON te.exp_id = ete.exp_id
            Inner Join tab_expfondo AS tef ON ete.exp_id = tef.exp_id
            Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
            Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
            Inner Join tab_usuario AS tu ON tu.usu_id = teu.usu_id
            Inner Join tab_unidad AS tun ON tun.uni_id = tu.uni_id
            
            WHERE
            ete.usu_id =  '" . $usu_id . "' AND
            ete.ete_estado =  '1' AND
            te.exp_estado =  '1' AND
            tef.exf_estado =  '1' AND
            tef.fon_id = '$fondo'
            ORDER BY
            tun.uni_par,
            ts.ser_id

 ";
        //        tu.uni_id,

        $result = $this->etiquetas->dbSelectBySQL($sql);
        return $result;
    }

    function loadEtiquetas($usu_id, $rol) {
        if ($rol == 'ACEN')
            $fondo = '3';
        elseif ($rol == 'SUBF')
            $fondo = '2';
        else
            $fondo = '1';
        //se obtienen las etiquetas para carpetas
        $sql = "
SELECT DISTINCT
        tun.uni_par,
        (SELECT ttun.uni_codigo FROM tab_unidad AS ttun WHERE ttun.uni_id =  tun.uni_par) as direccion,
        tun.uni_id,tun.uni_codigo,ts.ser_id,ts.ser_categoria,MIN(tef.exf_fecha_exi) as exf_min,
            MAX(tef.exf_fecha_exf) as exf_max,
            (SELECT (ctc.ctp_codigo || ' ' || cc.con_codigo) FROM tab_tipocontenedor AS ctc
            Inner Join tab_contenedor AS cc ON ctc.ctp_id = cc.ctp_id
            Inner Join tab_subcontenedor AS sc ON cc.con_id = sc.con_id
            Inner Join tab_expcontenedor AS cec ON sc.suc_id = cec.suc_id
            WHERE cec.exc_estado =  '1' and cec.exp_id =  te.exp_id
            ) as contenedor,
            (SELECT DISTINCT cc.con_id FROM  tab_tipocontenedor AS ctc
            Inner Join tab_contenedor AS cc ON ctc.ctp_id = cc.ctp_id
            Inner Join tab_subcontenedor AS sc ON cc.con_id = sc.con_id
            Inner Join tab_expcontenedor AS cec ON sc.suc_id = cec.suc_id
            WHERE cec.exc_estado =  '1' and cec.exp_id =  te.exp_id
            ) as con_id
            FROM
            tab_etiquetas AS ete
            Inner Join tab_expediente AS te ON te.exp_id = ete.exp_id
            Inner Join tab_expfondo AS tef ON ete.exp_id = tef.exp_id
            Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
            Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
            Inner Join tab_usuario AS tu ON tu.usu_id = teu.usu_id
            Inner Join tab_unidad AS tun ON tun.uni_id = tu.uni_id
            WHERE
            ete.usu_id =  '".$usu_id."' AND
            ete.ete_estado =  '1' AND
            te.exp_estado =  '1' AND
            tef.exf_estado =  '1' AND
            tef.fon_id = '$fondo'
            GROUP BY
            te.exp_id,
            tun.uni_id,
            ts.ser_id";
        $uni = new tab_unidad();
        $result = $uni->dbSelectBySQL($sql);
        return $result;
    }

    function loadExpedientes($usu_id, $rol, $uni_id, $ser_id) {
        if ($rol == 'ACEN')
            $fondo = '3';
        elseif ($rol == 'SUBF')
            $fondo = '2';
        else
            $fondo = '1';
        $sql = "SELECT DISTINCT
        ete.ete_id,
        ete.suc_id,
        te.exp_nombre,
        te.exp_id,
        te.exp_codigo,
        tef.fon_id,
        tef.exf_fecha_exi,
        tef.exf_fecha_exf
        FROM
        tab_etiquetas AS ete
        Inner Join tab_expediente AS te ON te.exp_id = ete.exp_id
        Inner Join tab_expfondo AS tef ON ete.exp_id = tef.exp_id
        Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
        Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
        Inner Join tab_usuario AS tu ON tu.usu_id = teu.usu_id
        WHERE
        ete.usu_id =  '" . $usu_id . "' AND
        ete.ete_estado =  '1' AND
        te.exp_estado =  '1' AND
        tef.exf_estado =  '1' AND
        tef.fon_id = '$fondo' AND
        tu.uni_id = '$uni_id' AND
        ts.ser_id = '$ser_id'
        ORDER BY
        te.exp_nombre ASC ";
        $result = $this->etiquetas->dbSelectBySQL($sql);
        return $result;
    }

    function getNroMax($tipo, $usu_id, $anio) {

//        $sql_nro = "SELECT
//        Max(tsc.suc_nro) as num
//        FROM
//        tab_subcontenedor AS tsc
//        Inner Join tab_tipocontenedor AS ttc ON ttc.ctp_id = tsc.ctp_id
//        WHERE
//        tsc.suc_estado =  '1' AND
//        ttc.ctp_codigo =  '$tipo' AND
//        tsc.usu_id =  '$usu_id' AND
//        tsc.suc_id NOT IN (SELECT DISTINCT e.suc_id FROM tab_etiquetas e) ";
//        tsc.suc_gestion =  '$anio' AND

        $sql_nro = "SELECT suc.suc_nro_balda
                    FROM tab_subcontenedor AS suc
                    INNER JOIN tab_contenedor AS con ON suc.con_id = con.con_id
                    INNER JOIN tab_tipocontenedor AS ctp ON con.ctp_id = ctp.ctp_id
                    WHERE ctp.ctp_codigo = '$tipo' AND con.usu_id = '$usu_id' AND
                    suc.suc_id NOT IN (SELECT DISTINCT suc_id FROM tab_etiquetas)";
        $num_ant = $this->etiquetas->countBySQL($sql_nro);
        if ($num_ant == '')
            $num_ant = 0;
        return $num_ant;
    }

}

?>
