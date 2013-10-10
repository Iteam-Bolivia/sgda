<?php

/**
 * exp_prestamo.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class exp_prestamo extends tab_exp_prestamo {

    function __construct() {
        //parent::__construct();
        $this->exp_prestamo = new tab_exp_prestamo();
    }

    function obtenerSelect($default) {
        if ($default) {
            $sql = "SELECT *
                FROM tab_exp_prestamo
                WHERE epr_estado = 1
                AND epr_id = '$default'
                ORDER BY epr_id ASC";
        } else {
            $sql = "SELECT *
                FROM tab_exp_prestamo
                WHERE epr_estado = 1
                ORDER BY epr_id ASC";
        }
        $rows = $this->exp_prestamo->dbselectBySQL($sql);
        $option = '';
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                $option .="<option value='" . $val->epr_id . "'>" . $val->exp_id . "</option>";
            }
        }
        return $option;
    }

    function count($epr_id) {
        $serie = new Tab_exp_prestamo();
        $num = 0;
        if ($default) {
            $sql = "SELECT count(epr_id)
                    FROM tab_exp_prestamo
                    WHERE epr_estado = 1
                    AND epr_id = '$default'
                    ORDER BY epr_id ASC";
        } else {
            $sql = "SELECT count(epr_id)
                    FROM tab_exp_prestamo
                    WHERE epr_estado = 1
                    ORDER BY epr_id ASC";
        }
        $num = $serie->countBySQL($sql);
        return $num;
    }

}
?>

