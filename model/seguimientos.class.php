<?php

/**
 * seguimientos.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class seguimientos extends tab_seguimientos {

    function __construct() {
        $this->seguimientos = new Tab_seguimientos ();
    }
    
    function count($id_seguimiento, $value1) {
        $seguimientos = new Tab_seguimientos ();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($id_seguimiento == 'id_seguimiento')
                $where = " $id_seguimiento = '$value1' ";
            else
                $where = " $id_seguimiento LIKE '%$value1%' ";
        }
        $sql = "select count(id_seguimiento) as num
		from tab_seguimientos
		WHERE $where ";
        $num = $seguimientos->countBySQL($sql);

        return $num;
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT
                agrupacion.nur_s
                FROM
                seguimientos
                INNER JOIN agrupacion ON seguimientos.id_seguimiento = agrupacion.id_seguimiento
                WHERE seguimientos.padre = 1"; 
        $rows = $this->seguimientos->dbSelectBySQL($sql);
        $option = "";
        if (count($rows)) {
            foreach ($rows as $val) {
                if ($default == $val->nur_s)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->nur_s . "' " . $selected . ">" . $val->nur_s . "</option>";
            }
        }
        return $option;
    }

}

?>
