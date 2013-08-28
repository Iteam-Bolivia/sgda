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
class proyecto extends tab_proyecto {

    function __construct() {
        //parent::__construct();
        $this->proyecto = new tab_proyecto();
    }

    function count($where) {
        $proyecto = new Tab_proyecto ();
        $sql = "SELECT count(pry_id)
                    FROM
                    tab_proyecto AS u
                    WHERE
                    u.pry_estado =  1 $where ";
        $num = $proyecto->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT *
                FROM tab_proyecto
                WHERE tab_proyecto.pry_estado = 1
                ORDER BY pry_nombre ASC ";
        $row = $this->proyecto->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->pry_id)
                $option .="<option value='" . $val->pry_id . "' selected>" . $val->pry_nombre . "</option>";
            else
                $option .="<option value='" . $val->pry_id . "'>" . $val->pry_nombre . "</option>";
        }
        return $option;
    }

    function obtenerCheck($exp_id = null) {
        $check = '';
        $add = "";

        if ($exp_id != null) {
            $add = " (SELECT
            us.pry_id
            FROM
            tab_expproyecto AS us
            WHERE
            us.pry_id =  s.pry_id AND us.epp_estado = '1' AND us.exp_id='$exp_id') as seleccionado ";
        } else {
            $add = " NULL as seleccionado ";
        }

        $sql = "SELECT
            s.pry_id,
            s.pry_codigo,
            s.pry_nombre,
            s.pry_grod,
            s.pry_imp,
            s.pry_estado,
            $add
            FROM
            tab_proyecto AS s
            WHERE
            s.pry_estado =  '1'
            ORDER BY s.pry_codigo ASC  ";

        $rows = $this->proyecto->dbSelectBySQL($sql);
        $i = 0;
        foreach ($rows as $proyecto) {
            $ck = '';
            if ($proyecto->seleccionado != null)
                $ck = ' checked="checked" ';

            $check.='<tr><td><input type="checkbox" name="lista_tramo[' . $i . ']" ' . $ck . ' id="serie-' . $proyecto->pry_id . '" value="' . $proyecto->pry_id . '" /></td> <td>' . $proyecto->pry_codigo . '</td> <td>' . $proyecto->pry_nombre . '</td> </tr>';
            $i++;
        }
        return $check;
    }
    function existeCodigo($pry_codigo) {
        $row = array();
        if ($pry_codigo != null) {
            $sql = "select * 
                    from tab_proyecto 
                    where tab_proyecto.pry_codigo = '$pry_codigo' ";
            $row = $this->proyecto->dbselectBySQL($sql);
        }else{
            return false;
        }
        if (count($row) > 0) {
            return true;
        } else return false;
    }  
}

?>