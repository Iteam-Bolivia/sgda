<?php

/**
 * archivoModel
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class seccion extends tab_seccion {

    function __construct() {
        //parent::__construct();
        $this->seccion = new tab_seccion();
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select *
			from tab_seccion
			where tab_seccion.sec_estado = 1
			ORDER BY sec_id ASC ";
        $row = $this->seccion->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->sec_id)
                $option .="<option value='" . $val->sec_id . "' selected>" . $val->sec_nombre . "</option>";
            else
                $option .="<option value='" . $val->sec_id . "'>" . $val->sec_nombre . "</option>";
        }
        return $option;
    }

    function selectSeccion($usu_id, $uni_id, $sec_id = null) {

        $sql = "SELECT sec.sec_id,sec.sec_codigo,sec.sec_nombre
FROM tab_usu_sec AS use INNER JOIN tab_seccion AS sec ON use.sec_id = sec.sec_id
WHERE use.usu_id = $usu_id AND use.use_estado = 1 AND sec.sec_estado = 1 AND sec.uni_id = '$uni_id'";
        $row = $this->seccion->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($sec_id == $val->sec_id)
                $option .="<option value='" . $val->sec_id . "' selected>" . $val->sec_nombre . "</option>";
            else
                $option .="<option value='" . $val->sec_id . "'>" . $val->sec_nombre . "</option>";
        }
        return $option;
    }

    function count($where) {
        $seccion = new Tab_seccion ();
        $sql = "SELECT count(sec.sec_id)
FROM tab_seccion AS sec
INNER JOIN tab_unidad AS uni ON sec.uni_id = uni.uni_id
WHERE sec.sec_estado = 1 AND uni.uni_estado = 1 $where ";
        //echo($sql);die;
        $num = $seccion->countBySQL($sql);
        return $num;
    }

}

?>