<?php

/**
 * archivados_digitales.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class archivados_digitales extends tab_archivados_digitales {

    function __construct() {
        $this->archivados_digitales = new Tab_archivados_digitales ();
    }
    
    function count($where) {
        $archivados_digitales = new Tab_archivados_digitales ();
        $num = 0;
        $sql = "select count(id_archivados_digitales) as num
		from tab_archivados_digitales
		WHERE $where ";
        $num = $archivados_digitales->countBySQL($sql);

        return $num;
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT * 
                FROM tab_archivados_digitales "; 
        $rows = $this->archivados_digitales->dbSelectBySQL($sql);
        $option = "";
        if (count($rows)) {
            foreach ($rows as $val) {
                if ($default == $val->id_archivados_digitales)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->id_archivados_digitales    . "' " . $selected . ">" . $val->codigo . "</option>";
            }
        }
        return $option;
    }

}

?>
