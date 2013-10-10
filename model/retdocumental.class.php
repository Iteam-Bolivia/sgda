<?php

/**
 * retdocumental.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class retdocumental extends tab_retdocumental {

    function __construct() {
        $this->retdoc = new Tab_retdocumental();
    }

    function obtenerFechaExtFinal($exp_id, $fon_id, $mes, $dia, $anio) {
        $sql = "SELECT
            tr.ret_id,
            tr.ret_anios
            FROM
            tab_retdocumental AS tr
            Inner Join tab_expediente AS te ON te.ser_id = tr.ser_id
            WHERE
            te.exp_id =  '$exp_id' AND
            tr.fon_id =  '$fon_id' ";
        $rows = $this->retdoc->dbSelectBySQL($sql);
        $anios = $rows[0]->ret_anios;
        $fecha_final = date("Y-m-d", mktime(0, 0, 0, $mes, $dia, $anio + $anios));
        return $fecha_final;
    }

    function deleteXSerie($ser_id) {
        $del = "UPDATE tab_retdocumental SET ret_estado = '2', ret_fecha_mod = '" . date("Y-m-d") . "', use_usuario_mod='" . $_SESSION['USU_ID'] . "' WHERE ser_id = '$ser_id' AND ret_estado = '1' ";
        $this->retdoc->dbBySQL($del);
    }

}

?>
