<?php

/**
 * correspondencia.class.php Model
 * SIACO
 * 
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class correspondencia extends tab_correspondencia {

    function __construct() {
        $this->correspondencia = new Tab_correspondencia ();
    }
    
    function count($cor_id, $value1) {
        $correspondencia = new Tab_correspondencia ();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($cor_id == 'cor_id')
                $where = " $cor_id = '$value1' ";
            else
                $where = " $cor_id LIKE '%$value1%' ";
        }
        $sql = "select count(cor_id) as num
		from tab_correspondencia
		WHERE $where ";
        $num = $correspondencia->countBySQL($sql);

        return $num;
    }

    function obtenerSelect($default = null) {
        if($default){
        $sql = "SELECT * 
                FROM correspondencia 
                WHERE cor_id = '$default' ";             
        }else{
        $sql = "SELECT * 
                FROM correspondencia"; 
        }
        $rows = $this->correspondencia->dbSelectBySQL($sql);
        $option = "";
        if (count($rows)) {
            foreach ($rows as $val) {
                if ($default == $val->cor_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->cor_id . "' " . $selected . ">" . $val->cor_referencia . "</option>";
            }
        }
        return $option;
    }

}

?>
