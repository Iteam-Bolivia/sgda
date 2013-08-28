<?php

/**
 * locales.class.php Model
 * 
 * @package   
 * @author lic. castellon
 * @copyright ITEAM 
 * @version $Id$ 2012
 * @access public
 */
class locales extends tab_locales {

    function __construct() {
        $this->locales = new tab_locales();
    }

    function obtenerSelectLocal($default = null) {
        $locales = "";
        $rows = $this->locales->dbSelectBySQL("SELECT * FROM tab_locales ORDER BY loc_descripcion ASC");
        foreach ($rows as $m) {
            if ($default == $m->loc_id)
                $selected = "selected";
            else
                $selected = "";
            $locales .="<option value='" . $m->loc_id . "' " . $selected . " >" . $m->loc_descripcion . "</option>";
        }
        return $locales;
    }

}

?>
