<?php

/**
 * archivados.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class archivados extends tab_archivados {

    function __construct() {
        $this->archivados = new Tab_archivados ();
    }
    
    function count($where) {
        $archivados = new Tab_archivados ();
        $num = 0;
        $sql = "select count(id_archivados) as num
		from tab_archivados
		WHERE $where ";
        $num = $archivados->countBySQL($sql);

        return $num;
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT * 
                FROM tab_archivados "; 
        $rows = $this->archivados->dbSelectBySQL($sql);
        $option = "";
        if (count($rows)) {
            foreach ($rows as $val) {
                if ($default == $val->id_archivados)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->id_archivados    . "' " . $selected . ">" . $val->codigo . "</option>";
            }
        }
        return $option;
    }

}

?>
