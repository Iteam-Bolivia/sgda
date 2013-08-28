<?php

/**
 * solicitud_prestamo.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class solicitud_prestamo extends tab_solicitud_prestamo {

    function __construct() {
        //parent::__construct();
        $this->solicitud_prestamo = new tab_solicitud_prestamo();
    }

    function obtenerSelect($default) {
        if ($default) {
            $sql = "SELECT *
                FROM tab_solicitud_prestamo
                WHERE spr_estado = 1
                AND spr_id = '$default'
                ORDER BY spr_id ASC";
        } else {
            $sql = "SELECT *
                FROM tab_solicitud_prestamo
                WHERE spr_estado = 1
                ORDER BY spr_id ASC";
        }
        $rows = $this->solicitud_prestamo->dbselectBySQL($sql);
        $option = '';
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                $option .="<option value='" . $val->spr_id . "'>" . $val->spr_solicitante . "</option>";
            }
        }
        return $option;
    }

    function count($default) {
        $uni_id = $_SESSION['UNI_ID'];
        $serie = new Tab_solicitud_prestamo();
        $num = 0;
        if ($default) {
            $sql = "SELECT count(spr_id)
                    FROM tab_solicitud_prestamo
                    WHERE spr_estado = 1
                    AND spr_id = '$default'
                    ORDER BY spr_id ASC";
        } else {
            $sql = "SELECT COUNT (spr_id)
                    FROM tab_solicitud_prestamo
                    WHERE spr_estado = 1
                    AND uni_id = '$uni_id' ";
        }
        $num = $serie->countBySQL($sql);
        return $num;
    }

}

?>
