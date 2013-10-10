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
class riesgos extends tab_riesgos {

    function __construct() {
        $this->riesgos = new tab_riesgos();
    }

    function obtenerSelectRiesgos($default = null) {
        $riesgos = "";
        $rows = $this->riesgos->dbSelectBySQL("SELECT * FROM tab_riesgos ORDER BY rie_descripcion ASC");
        foreach ($rows as $m) {
            if ($default == $m->rie_id)
                $selected = "selected";
            else
                $selected = "";
            $riesgos .="<option value='" . $m->rie_id . "' " . $selected . " >" . $m->rie_descripcion . "</option>";
        }
        return $riesgos;
    }

}

?>
