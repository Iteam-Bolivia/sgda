<?php

/**
 * usu_uni.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class usu_uni extends Tab_usu_uni {

    function __construct() {
        $this->usu_uni = new Tab_usu_uni();
    }

    function obtAnteriorUnidad($usu_id, $ver_id) {
        $usu_uni = new Tab_usu_uni();
        $rows = $this->usu_uni->dbselectBy3Field("usu_id", $usu_id, "ver_id", $ver_id, "usn_estado", 1);
        if (count($rows) > 0)
            $usu_uni = $rows[0];
        return $usu_uni;
    }

    function deleteXUsuario($usu_id) {
        $del = "UPDATE tab_usu_uni SET usn_estado = '2', usn_fecha_mod = '" . date("Y-m-d") . "', usn_usuario_mod='" . $_SESSION['USU_ID'] . "' WHERE usu_id = '$usu_id' AND usn_estado = '1' ";
        $this->usu_serie->dbBySQL($del);
    }

}

?>
