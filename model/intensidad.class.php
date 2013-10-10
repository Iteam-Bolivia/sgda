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
class intensidad extends par_intensidad {

    function __construct() {
        $this->intensidad = new par_intensidad();
    }

    function obtenerSelect($default = null) {
        $inten = "";

        $rows = $this->intensidad->dbSelectBySQL("SELECT * FROM par_intensidad ORDER BY int_descripcion ASC");
        foreach ($rows as $m) {
            if ($default == $m->int_id)
                $selected = "selected";
            else
                $selected = "";
            $inten .="<option value='" . $m->int_id . "' " . $selected . " >" . $m->int_descripcion . "</option>";
        }
        return $inten;
    }

    function obtenerCheck($default = null) {
        $add = "";
        $ck = "";
        if ($default != null) {
            $add = "
            IF((SELECT  COUNT(tev.eva_id) From tab_evalriesgos tev
                WHERE tev.int_id=f.int_id AND tev.eva_id='" . $default . "')>0,' checked ','') as checked";
        } else {
            $add = "' ' as checked";
        }
        $sql = "SELECT
            f.int_id,
            f.int_codigo,
            f.int_descripcion,
            " . $add . "
            FROM
            par_intensidad AS f
            WHERE f.int_estado = '1'
            ORDER BY f.int_descripcion ASC";
        $rows = $this->intensidad->dbSelectBySQL($sql);
        $i = 0;
        foreach ($rows as $m) {
            if ($default == $m->int_id)
                $selected = "selected";
            else
                $selected = "";

            $ck .= "<tr><td width='20'><input type='checkbox' name='frecuencia[$i]' value='" . $m->int_id . "' $m->checked></td><td>" . $m->int_descripcion . "</td></tr>\n";
            $i++;
        }
        return $ck;
    }

    function obtenerDescripcion($eva_id) {
        $sql = "SELECT
            pi.int_codigo,
            pi.int_descripcion
            FROM
            par_intensidad AS pi
            Inner Join tab_eval_intensidad AS evi ON evi.int_id = pi.int_id
            WHERE
            evi.eva_id =  '2'
            ORDER BY
            pi.int_descripcion ASC";
        $des = "";
        $rows = $this->intensidad->dbSelectBySQL($sql);
        $i = 0;
        foreach ($rows as $m) {
            $i++;
            $des .=$m->int_codigo . ", ";
        }
        if ($i > 0) {
            $des = substr($des, 0, -2);
        }
        return $des;
    }

}

?>
