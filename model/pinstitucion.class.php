<?php

/**
 * institucionModel
 *
 * @package
 * @author Dev. a.
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class pinstitucion extends Par_institucion {

    function __construct() {
        //parent::__construct();
        $this->pinstitucion = new Par_institucion();
    }

    function obtenerSelect($default = null) {
        $rows = $this->pinstitucion->dbSelectBySQL("SELECT
                    pit.int_id,
                    pit.int_descripcion
                    FROM
                    par_institucion AS pit
                    WHERE
                    pit.int_estado =  '1'
                    ORDER BY
                    pit.int_descripcion ASC ");
        $option = "";
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->int_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->int_id . "' " . $selected . ">" . $val->int_descripcion . "</option>";
            }
        }
        return $option;
    }

}

?>
