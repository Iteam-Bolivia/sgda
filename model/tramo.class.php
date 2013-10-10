<?php

/**
 * archivoModel
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tramo extends tab_tramo {

    function __construct() {
        //parent::__construct();
        $this->tramo = new tab_tramo();
    }

    function count($where) {
        $tramo = new Tab_tramo ();
        $sql = "SELECT count(trm_id)
                    FROM
                    tab_tramo AS u
                    WHERE
                    u.trm_estado =  1 $where ";
        $num = $tramo->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT *
                FROM tab_tramo
                WHERE tab_tramo.trm_estado = 1
                ORDER BY trm_id ASC ";
        $row = $this->tramo->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->trm_id)
                $option .="<option value='" . $val->trm_id . "' selected>" . $val->trm_nombre . "</option>";
            else
                $option .="<option value='" . $val->trm_id . "'>" . $val->trm_nombre . "</option>";
        }
        return $option;
    }

    function obtenerCheck($exp_id = null) {
        $check = '';
        $add = "";

        if ($exp_id != null) {
            $add = " (SELECT
            us.trm_id
            FROM
            tab_exptramo AS us
            WHERE
            us.trm_id =  s.trm_id AND us.ext_estado = '1' AND us.exp_id='$exp_id') as seleccionado ";
        } else {
            $add = " NULL as seleccionado ";
        }

        $sql = "SELECT
            s.trm_id,
            s.trm_codigo,
            s.trm_nombre,
            s.trm_estado,
            $add
            FROM
            tab_tramo AS s
            WHERE
            s.trm_estado =  '1'
            ORDER BY s.trm_codigo ASC  ";

        $rows = $this->tramo->dbSelectBySQL($sql);
        $i = 0;
        foreach ($rows as $tramo) {
            $ck = '';
            if ($tramo->seleccionado != null)
                $ck = ' checked="checked" ';

            $check.='<tr><td><input type="checkbox" name="lista_tramo[' . $i . ']" ' . $ck . ' id="serie-' . $tramo->trm_id . '" value="' . $tramo->trm_id . '" /></td> <td>' . $tramo->trm_codigo . '</td> <td>' . $tramo->trm_nombre . '</td> </tr>';
            $i++;
        }
        return $check;
    }

}

?>