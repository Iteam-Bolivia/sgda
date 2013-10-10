<?php

/**
 * agrupacion.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class agrupacion extends tab_agrupacion {

    function __construct() {
        $this->agrupacion = new Tab_agrupacion ();
    }
    
    function count($id_agru, $value1) {
        $agrupacion = new Tab_agrupacion ();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($id_agru == 'id_agru')
                $where = " $id_agru = '$value1' ";
            else
                $where = " $id_agru LIKE '%$value1%' ";
        }
        $sql = "select count(id_agru) as num
		from tab_agrupacion
		WHERE $where ";
        $num = $agrupacion->countBySQL($sql);

        return $num;
    }

    function obtenerSelect($default = null) {
        if($default){
        $sql = "SELECT * 
                FROM agrupacion 
                WHERE id_agru = '$default' ";             
        }else{
        $sql = "SELECT * 
                FROM agrupacion"; 
        }
        $rows = $this->agrupacion->dbSelectBySQL($sql);
        $option = "";
        if (count($rows)) {
            foreach ($rows as $val) {
                if ($default == $val->id_agru)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->id_agru . "' " . $selected . ">" . $val->nur_s . "</option>";
            }
        }
        return $option;
    }

}

?>
