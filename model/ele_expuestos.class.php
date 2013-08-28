<?php

/**
 * riesgos.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class ele_expuestos extends par_ele_expuestos {

    function __construct() {
        $this->ele_expuestos = new par_ele_expuestos();
    }

    function obtenerSelect($default = null) {
        $opt = "";

        $rows = $this->ele_expuestos->dbSelectBySQL("SELECT * FROM par_ele_expuestos ORDER BY ele_descripcion ASC");
        foreach ($rows as $m) {
            if ($default == $m->ele_id)
                $selected = "selected";
            else
                $selected = "";
            $opt .="<option value='" . $m->ele_id . "' " . $selected . " >" . $m->ele_descripcion . "</option>";
        }
        return $opt;
    }

}

?>
