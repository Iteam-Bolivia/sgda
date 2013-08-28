<?php

/**
 * expproyecto.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expproyecto extends tab_expproyecto {

    function __construct() {
        //parent::__construct();
        $this->expproyecto = new Tab_expproyecto();
    }

    function existe($proyecto, $exp_id) {
        $rows = $this->expproyecto->dbselectBy2Field("pry_id", $proyecto, "exp_id", $exp_id);
        if (count($rows) > 0) {
            return $rows[0]->epp_id;
        } else {
            return false;
        }
    }

    function delete($exp_id) {
        $del = "UPDATE tab_expproyecto SET epp_estado = '2' WHERE exp_id = '$exp_id' AND epp_estado = '1' ";
        $this->expproyecto->dbBySQL($del);
    }

    function deleteXproyecto($pry_id) {
        $del = "UPDATE tab_expproyecto SET epp_estado = '2' WHERE pry_id = '$pry_id' AND epp_estado = '1' ";
        $this->expproyecto->dbBySQL($del);
    }

//    function tieneSeries($usu_id) {
//        $sql = "SELECT COUNT(DISTINCT us.use_id)
//            FROM
//            tab_expproyecto AS us
//            Inner Join tab_series AS s ON s.ser_id = us.ser_id
//            WHERE
//            us.use_estado =  '1' AND
//            us.usu_id =  '$usu_id' AND
//            (s.ser_tipo IS NULL  OR s.ser_tipo = '') ";
//        $num = $this->expproyecto->countBySQL($sql);
//        if ($num > 0) {
//            return 'OK';
//        } else {
//            return false;
//        }
//    }
}

?>