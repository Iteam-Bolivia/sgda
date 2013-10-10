<?php

/**
 * contenedor.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */

class contenedor extends tab_contenedor {

    function __construct() {
        $this->contenedor = new tab_contenedor();
    }

    function count($where) {
        $sql = "SELECT 
                COUNT(c.con_id) as num
                FROM tab_contenedor AS c 
                Inner Join tab_tipocontenedor AS tc ON tc.ctp_id = c.ctp_id 
                Inner Join tab_usuario AS u ON c.usu_id = u.usu_id
                WHERE c.con_estado =  '1' 
                $where ";
        $num = $this->contenedor->countBySQL($sql);
        return $num;
    }

    function countUsu($qtype, $query, $usu_id) {
        $row = array();
        $num = 0;
        $where = "";
        if ($query) {
            if ($qtype == 'con_id')
                $where = " AND c.$qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT 
                COUNT(DISTINCT c.con_id) as num
                FROM
                tab_contenedor AS c
                Inner Join tab_tipocontenedor AS tc ON tc.ctp_id = c.ctp_id
                Inner Join tab_usuario AS u ON c.usu_id = u.usu_id
                WHERE c.con_estado =  '1' 
                AND c.usu_id =  '" . $usu_id . "' 
                $where ";
        $num = $this->contenedor->countBySQL($sql);
        return $num;
    }

    function obtenerDescripcion($exp_id) {
        $sql = "SELECT DISTINCT 
                exc.exp_id,
                con.con_id,
                con.con_codigo,
                suc.suc_id,
                suc.suc_codigo,
                ctp.ctp_codigo
                FROM tab_expcontenedor AS exc 
                INNER JOIN tab_subcontenedor AS suc ON exc.suc_id = suc.suc_id
                INNER JOIN tab_contenedor AS con ON suc.con_id = con.con_id 
                INNER JOIN tab_tipocontenedor AS ctp ON con.ctp_id = ctp.ctp_id
                WHERE exc.exp_id = '$exp_id' 
                AND exc.exc_estado = 1";
        $rows = $this->contenedor->dbSelectBySQL($sql);
        $res = array();
        $res['con_id'] = '';
        $res['con_codigo'] = '';
        $res['suc_id'] = '';
        $res['suc_codigo'] = '';
        $res['ctp_codigo'] = '';
        if (count($rows) > 0) {
            $res['con_id'] = $rows[0]->con_id;
            $res['con_codigo'] = $rows[0]->con_codigo;
            $res['suc_id'] = $rows[0]->suc_id;
            $res['suc_codigo'] = $rows[0]->suc_codigo;
            $res['ctp_codigo'] = $rows[0]->ctp_codigo;
        }
        return $res;
        //print_r($res);die();
    }

    function loadSelect($usu, $cont_seleccionado = null) {
        $cadena = "";
        $sql = "SELECT DISTINCT
		  c.con_id,
		  t.ctp_codigo,
		  c.con_codigo
		  FROM
		  tab_contenedor c 
                  INNER JOIN tab_tipocontenedor t ON t.ctp_id=c.ctp_id
		  WHERE
		  c.con_estado =  '1' 
                  AND c.usu_id =  '" . $usu . "' 
                  ORDER BY t.ctp_codigo ASC, 
                  c.con_codigo ASC ";

        $result = $this->contenedor->dbSelectBySQL($sql);

        if ($result) {
            foreach ($result as $row) {

                if (!empty($cont_seleccionado) && $cont_seleccionado == $row->con_id) {
                    $cadena.="<option value='$row->con_id' selected>$row->ctp_codigo - $row->con_codigo</option>";
                } else {
                    $cadena.="<option value='$row->con_id'>$row->ctp_codigo - $row->con_codigo</option>";
                }
            }
        }

        return $cadena;
    }

    function loadSelectInstFondo($fon_orden, $usu_id,$cont_seleccionado = null) {
        $cadena = "";
        $sql = "SELECT con.con_id,con.con_codigo,ctp.ctp_codigo
FROM tab_fondo AS fon
INNER JOIN tab_unidad AS uni ON fon.fon_id = uni.fon_id
INNER JOIN tab_usuario AS usu ON uni.uni_id = usu.uni_id
INNER JOIN tab_contenedor AS con ON usu.usu_id = con.usu_id
INNER JOIN tab_tipocontenedor AS ctp ON con.ctp_id = ctp.ctp_id
WHERE fon.fon_orden = $fon_orden AND usu.usu_id = $usu_id AND  usu.usu_estado = 1 AND con.con_estado = 1
                ORDER BY ctp.ctp_codigo ASC,con.con_codigo ASC ";
        //print $sql;die;
        $result = $this->contenedor->dbSelectBySQL($sql);
        if ($result)
            foreach ($result as $row) {
                if (!empty($cont_seleccionado) && $cont_seleccionado == $row->con_id) {
                    $cadena.="<option value='$row->con_id' selected>$row->ctp_codigo - $row->con_codigo</option>";
                } else {
                    $cadena.="<option value='$row->con_id'>$row->ctp_codigo - $row->con_codigo</option>";
                }
            }
        return $cadena;
    }

    function listaContenedorUsuario($usu_id) {
        $tabla = "<ol type='1'>";
        $result = $this->contenedor->dbSelectBySQL("SELECT DISTINCT 
                                                    t.ctp_codigo, 
                                                    c.con_codigo
                                                    FROM tab_contenedor c 
                                                    INNER JOIN tab_tipocontenedor t ON t.ctp_id=c.ctp_id
                                                    WHERE c.con_estado =  '1' 
                                                    AND c.usu_id =  '$usu_id'
                                                    ORDER BY t.ctp_codigo ASC, c.con_codigo ASC ");
        foreach ($result as $titulo) {
            $tabla .="<li>" . $titulo->ctp_codigo . " - " . $titulo->con_codigo . "</li>";
        }
        $tabla .="</ol>";
        return $tabla;
    }

    function obtenerTiposContenedor($default) {
        $tipocon = new Tab_tipocontenedor();
        $result = $tipocon->dbSelectBySQL("SELECT
                                        ctp_id, 
                                        ctp_descripcion
                                        FROM tab_tipocontenedor 
                                        WHERE ctp_estado =  '1' 
                                        AND ctp_nivel = '1'
                                        ORDER BY ctp_id ASC ");
        $option = "";
        foreach ($result as $tipo) {
            if ($tipo->ctp_id == $default)
                $option .="<option value='$tipo->ctp_id' selected>$tipo->ctp_descripcion</option>";
            else
                $option .="<option value='$tipo->ctp_id'>$tipo->ctp_descripcion</option>";
        }
        return $option;
    }

    function updateContenedor($exp_id, $con_id) {

        $texpArch = new tab_exparchivo();
        $rows_a = $texpArch->dbSelectBySQL("SELECT * 
                                            FROM tab_exparchivo 
                                            WHERE exp_id ='" . $exp_id . "' 
                                            AND exa_estado = '1' ");

        foreach ($rows_a as $exa) {
            $exa->con_id = $con_id;
            $exa->setExa_fecha_mod(date("Y-m-d"));
            $exa->setExa_usuario_mod($_SESSION['USU_ID']);
            $exa->update();
            $texpArch->updateValueOne("con_id", $con_id, "exa_id", $exa->exa_id);
        }
        $tcont = new tab_expcontenedor();
        $rows_c = $tcont->dbSelectBySQL("SELECT * 
                                        FROM tab_expcontenedor 
                                        WHERE exp_id ='" . $exp_id . "' 
                                        AND exc_estado = '1' ");

        if (count($rows_c) > 0) {
            $rows_c[0]->setCon_id($con_id);
            $rows_c[0]->setExc_usu_reg($_SESSION['USU_ID']);
            $rows_c[0]->setExc_fecha_reg(date("Y-m-d"));
            $rows_c[0]->update();
            $tcont->updateValueOne("con_id", $con_id, "exc_id", $rows_c[0]->exc_id);
        } else {
            $teuv = new Tab_expunidad();
            $row_u = $teuv->dbselectBy2Field("exp_id", $exp_id, "euv_estado", "1");
            $tcont->euv_id = $row_u[0]->euv_id;
            $tcont->exp_id = $exp_id;
            $tcont->con_id = $con_id;
            $tcont->exc_fecha_reg(date("Y-m-d"));
            $tcont->exc_usu_reg($_SESSION['USU_ID']);
            $tcont->exc_estado(1);
            $tcont->insert();
        }
    }

    function selectCon($con_id, $usu_id = NULL) {
        $tab_contenedor = new tab_contenedor();

        if ($usu_id == NULL) {
            $sql = "SELECT 
                    usu_id 
                    FROM tab_contenedor 
                    WHERE con_estado=1 
                    AND con_id=$con_id";
            $res = $tab_contenedor->dbSelectBySQL($sql);
            $usu_id = $res[0]->usu_id;
        }
        $sql = "SELECT 
                con_id, 
                con_codigo 
                FROM tab_contenedor 
                WHERE con_estado=1 
                AND usu_id=$usu_id";
        $res = $tab_contenedor->dbSelectBySQL($sql);
        $option = "";
        $option .="<option value=''>(Seleccionar)</option>";
        foreach ($res as $value) {
            if ($value->con_id == $con_id)
                $option .="<option value='" . $value->con_id . "' selected>" . $value->con_codigo . "</option>";
            else
                $option .="<option value='" . $value->con_id . "' >" . $value->con_codigo . "</option>";
        }
        return $option;
    }

}

?>
