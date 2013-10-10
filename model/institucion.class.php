<?php

/**
 * institucionModel
 *
 * @package
 * @author Dev. a.
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class institucion extends Tab_institucion {

    function __construct() {
        //parent::__construct();
        $this->institucion = new Tab_institucion();
    }

    function count($where) {

        $sql = "SELECT COUNT(I.int_id) as num
            FROM tab_institucion AS I
            WHERE I.int_estado =  '1' $where ";
        $num = $this->institucion->countBySQL($sql);
        return $num;
    }

    function obtenerInstitucion($usu_id) {
        $sql = "SELECT DISTINCT
            I.ins_id,
            I.ins_nombre FROM tab_institucion AS I
            Inner Join tab_unidad AS U ON I.ins_id = U.ins_id
            Inner Join tab_usuario AS US ON US.uni_id = U.uni_id
            WHERE US.usu_id = '$usu_id' AND I.ins_estado =  '1' ";
        //print $sql;die;
        $rows = $this->institucion->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            return $rows[0];
        }
        return 0;
    }

    function obtenerIns_id($usu_id) {
        $sql = "45";
        $rows = $this->institucion->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            return $rows[0]->ins_id;
        }
        return 0;
    }

    function getFondoUsu($usu_id) {
        $usu = new usuario();
        $tipo = $usu->getTipo($usu_id);
        $where = "";
        if ($tipo == 'SUBF') {
            $where = " AND tf.fon_id = '2' ";
        } elseif ($tipo == 'ACEN') {
            $where = " AND tf.fon_id = '3' ";
        } else {
            $where = " AND tf.fon_id = '1'";
        }

        // REVISED: CASTELLON
        $sql = "SELECT DISTINCT ti.ins_id, ti.ins_nombre, tf.fon_descripcion, tf.fon_orden, tf.fon_id, ttif.inl_id, ti.ins_id
        FROM tab_inst_fondo AS ttif Inner Join tab_institucion AS ti ON ttif.ins_id = ti.ins_id Inner Join tab_fondo AS tf ON ttif.fon_id = tf.fon_id Inner Join tab_unidad AS tu ON tu.ins_id = ttif.ins_id Inner Join tab_usuario AS tus ON tus.uni_id = tu.uni_id
        WHERE tus.usu_id = '$usu_id' AND ttif.inl_estado = '1' $where ";
        $rows = $this->institucion->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            return $rows[0];
        } else {
            return null;
        }
    }

    function getFondo($fon_id) {
        $sql = "SELECT fon.fon_id,fon.fon_descripcion,fon.fon_orden,
uni.uni_id,uni.uni_codigo,uni.uni_descripcion
FROM tab_unidad AS uni
INNER JOIN tab_fondo AS fon ON uni.fon_id = fon.fon_id
WHERE uni.fon_id = '$fon_id' AND uni.uni_estado = 1 AND fon.fon_estado = 1";
        $rows = $this->institucion->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            return $rows[0];
        } else {
            return null;
        }
    }

    function obtenerFondo($usu_id, $fon_orden) {
        $sql = "SELECT fon.fon_id,fon.fon_descripcion,fon.fon_orden,
uni.uni_id,uni.uni_codigo,uni.uni_descripcion
FROM tab_usuario AS usu
INNER JOIN tab_unidad AS uni ON usu.uni_id = uni.uni_id
INNER JOIN tab_fondo AS fon ON uni.fon_id = fon.fon_id
WHERE usu.usu_id = '$usu_id' AND fon.fon_orden = $fon_orden AND
usu.usu_estado = 1 AND uni.uni_estado = 1 AND fon.fon_estado = 1"; ///print_r($sql);die;

        $rows = $this->institucion->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            return $rows[0];
        }
        return null;
    }

    function obtenerSinUSR($fon_orden) {

        $sql = "SELECT f.* FROM tab_fondo f
            WHERE f.fon_orden = '$fon_orden' AND f.fon_estado = '1' "; ///print $sql;die;
        $rows = $this->institucion->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            return $rows[0];
        }
        return null;
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT DISTINCT
            I.int_id,
            I.int_descripcion FROM tab_institucion AS I
            WHERE I.int_estado =  '1'
            ORDER BY I.int_descripcion ASC ";
        $rows = $this->institucion->dbSelectBySQL($sql);
        $option = '';
        foreach ($rows as $inst) {
            if ($default == $inst->int_id) {
                $option.='<option value="' . $inst->int_id . '" selected>' . $inst->int_descripcion . '</option>';
            } else {
                $option.='<option value="' . $inst->int_id . '">' . $inst->int_descripcion . '</option>';
            }
        }
        return $option;
    }

}

?>
