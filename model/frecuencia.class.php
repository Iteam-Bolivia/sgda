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
class frecuencia extends par_frecuencia {

    function __construct() {
        $this->frecuencia = new par_frecuencia();
    }

    function obtenerSelect($default = null) {
        $frec = "";
        $rows = $this->frecuencia->dbSelectBySQL("SELECT * FROM par_frecuencia ORDER BY fre_descripcion ASC");
        foreach ($rows as $m) {
            if ($default == $m->fre_id)
                $selected = "selected";
            else
                $selected = "";

            $frec .="<option value='" . $m->fre_id . "' " . $selected . " >" . $m->fre_descripcion . "</option>";
        }
        return $frec;
    }

    function obtenerCheck($default = null) {
        $add = "";
        $frec = "";
        if ($default != null) {
            $add = "
            IF((SELECT  COUNT(tev.eva_id) From tab_evalriesgos tev
                WHERE tev.fre_id=f.fre_id AND tev.eva_id='" . $default . "')>0,' checked ','') as checked";
        } else {
            $add = "' ' as checked";
        }
        $sql = "SELECT
            f.fre_id,
            f.fre_codigo,
            f.fre_descripcion,
            " . $add . "
            FROM
            par_frecuencia AS f
            WHERE f.fre_estado = '1'
            ORDER BY f.fre_descripcion ASC";
        $rows = $this->frecuencia->dbSelectBySQL($sql);
        $i = 0;
        foreach ($rows as $m) {
            if ($default == $m->fre_id)
                $selected = "selected";
            else
                $selected = "";

            $frec .= "<tr><td width='20'><input type='checkbox' name='frecuencia[$i]' value='" . $m->fre_id . "' $m->checked></td><td>" . $m->fre_descripcion . "</td></tr>\n";
            $i++;
        }
        return $frec;
    }

    function obtenerDescripcion($eva_id) {
        $sql = "SELECT
            pf.fre_codigo,
            pf.fre_descripcion
            FROM
            par_frecuencia AS pf
            Inner Join tab_eval_frecuencia AS evf ON evf.fre_id = pf.fre_id
            WHERE
            evf.eva_id =  '2'
            ORDER BY
            pf.fre_descripcion ASC";
        $frec = "";
        $rows = $this->frecuencia->dbSelectBySQL($sql);
        $i = 0;
        foreach ($rows as $m) {
            $i++;
            $frec .=$m->fre_codigo . ", ";
        }
        if ($i > 0) {
            $frec = substr($frec, 0, -2);
        }
        return $frec;
    }

}

?>
