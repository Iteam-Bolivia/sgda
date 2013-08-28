<?php

/**
 * tipocontenedor.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tipocontenedor extends tab_tipocontenedor {

    function __construct() {
        //parent::__construct();
        $this->tipocontenedor = new Tab_tipocontenedor();
    }

    function count($where) {
        $tipocontenedor = new Tab_tipocontenedor ();
        $sql = "SELECT count(ctp_id)
                FROM
                tab_tipocontenedor
                WHERE
                ctp_estado = 1 $where ";
        $num = $tipocontenedor->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $rows = $this->tipocontenedor->dbSelectBySQL("SELECT
			tab_tipocontenedor.ctp_id,
			tab_tipocontenedor.ctp_codigo,
			tab_tipocontenedor.ctp_descripcion
			FROM
			tab_tipocontenedor
			WHERE
			tab_tipocontenedor.ctp_estado =  '1'
                        ORDER BY ctp_id ASC ");
        $option = "";
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->ctp_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->ctp_id . "' " . $selected . ">" . $val->ctp_descripcion . "</option>";
            }
        }
        return $option;
    }




//    function existeCodigo($codigo, $ctp_id = null) {
//        $row = array();
//        if ($ctp_id == null) {
//            $sql = "select * from tab_tipocontenedor where ctp_codigo like '$codigo' ";
//            $row = $this->tipocontenedor->dbselectBySQL($sql);
//        } else {
//            $sql = "select * from tab_tipocontenedor where ctp_codigo like '$codigo' AND ctp_id<>'$ctp_id' ";
//            $row = $this->tipocontenedor->dbselectBySQL($sql);
//        }
//        if (count($row) > 0) {
//            return true;
//        }
//        return false;
//    }
    

}

?>
