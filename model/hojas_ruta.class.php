<?php

/**
 * hojas_ruta.class.php Model
 * SIACO
 * 
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class hojas_ruta extends tab_hojas_ruta {

    function __construct() {
        $this->hojas_ruta = new Tab_hojas_ruta ();
    }
    
    function count($nur, $value1) {
        $hojas_ruta = new Tab_hojas_ruta ();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($nur == 'nur')
                $where = " $nur = '$value1' ";
            else
                $where = " $nur LIKE '%$value1%' ";
        }
        $sql = "select count(nur) as num
		from tab_hojas_ruta
		WHERE $where ";
        $num = $hojas_ruta->countBySQL($sql);

        return $num;
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT * 
                FROM hojas_ruta"; 
        $rows = $this->hojas_ruta->dbSelectBySQL($sql);
        $option = "";
        if (count($rows)) {
            foreach ($rows as $val) {
                if ($default == $val->codigo)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->codigo . "' " . $selected . ">" . $val->codigo . "</option>";
            }
        }
        return $option;
    }

}

?>
