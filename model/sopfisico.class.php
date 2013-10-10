<?php

/**
 * archivoModel
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class sopfisico extends tab_sopfisico {

    function __construct() {
        //parent::__construct();
        $this->sopfisico = new tab_sopfisico();
    }

    function count($where) {
        $sopfisico = new Tab_sopfisico ();
        $sql = "SELECT count(sof_id)
                    FROM
                    tab_sopfisico AS u
                    WHERE
                    u.sof_estado =  1 $where ";
        $num = $sopfisico->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT * 
                FROM tab_sopfisico 
                WHERE tab_sopfisico.sof_estado = 1 
                ORDER BY sof_id ASC ";
        $row = $this->sopfisico->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->sof_id)
                $option .="<option value='" . $val->sof_id . "' selected>" . $val->sof_nombre . "</option>";
            else
                $option .="<option value='" . $val->sof_id . "'>" . $val->sof_nombre . "</option>";
        }
        return $option;
    }
    function existeCodigo($sof_codigo) {
        $row = array();
        if ($sof_codigo != null) {
            $sql = "select sof_id 
                    from tab_sopfisico
                    where tab_sopfisico.sof_codigo = '$sof_codigo' ";
            $row = $this->rol->dbselectBySQL($sql);
        } else {
            return false;
        }
        if (count($row) > 0) {
            return true;
        } else
            return false;
    }

}

?>