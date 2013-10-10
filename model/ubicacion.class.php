<?php

/**
 * ubicacion.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class ubicacion extends tab_ubicacion {

    function __construct() {
        parent::__construct();
    }

    function dameDatosUbicacion($id) {
        if ($id != "") {
            $row = $this->dbselectBySQL("select * from tab_ubicacion WHERE ubi_id ='" . $id . "'");
            //$row= $row[0];
            //echo $row[0]->ubi_codigo;
            return $row[0];
        }
        else
            return "";
    }

    function dameIdPadre($id) {
        $row = $this->dbselectBySQL("SELECT
		*
		FROM
		tab_ubicacion
		WHERE
		ubi_id='" . $id . "'
		AND
		tab_ubicacion.ubi_par IN (SELECT ubi_id FROM tab_ubicacion WHERE ubi_par=0 )");

        if (is_object($row) || $row != null)
            return $row[0];
        else
            return "";
    }

    function esPadre($id) {
        if ($id != "") {
            $row = $this->dbselectBySQL("select * from tab_ubicacion WHERE ubi_id ='" . $id . "' AND ubi_par='0'");
            if (is_object($row) || $row != null)
                return true;
            else
                return false;
        }
        else
            return false;
    }

    function obtenerSelect($par, $default = null) {
        $this->ubicacion = new Tab_ubicacion();
        $rows = $this->ubicacion->dbSelectBySQL("SELECT
			tab_ubicacion.ubi_id,
			tab_ubicacion.ubi_codigo
			FROM
			tab_ubicacion
			WHERE
			tab_ubicacion.ubi_estado =  '1' AND
			tab_ubicacion.ubi_par =  '$par'");
        $option = "";
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->ubi_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->ubi_id . "' " . $selected . ">" . $val->ubi_codigo . "</option>";
            }
        }
        return $option;
    }

    function count2($query, $qtype) {
        $this->ubicacion = new Tab_ubicacion();
        $where = '';
        $num = 0;
        if ($query) {
            if ($qtype == 'ubi_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $num = $this->ubicacion->countBySQL("SELECT count(ubi_id) as num FROM tab_ubicacion WHERE ubi_par='0' AND ubi_estado = '1' $where");
        return $num;
    }

    function countPiso($query, $qtype, $ubi_par) {

        $this->ubicacion = new Tab_ubicacion();
        $where = '';
        $num = 0;
        if ($query) {
            if ($qtype == 'ubi_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $num = $this->ubicacion->countBySQL("SELECT COUNT(ubi_id) as num FROM tab_ubicacion WHERE ubi_par = " . $ubi_par . " AND ubi_estado = '1' $where ");
        return $num;
    }

    
    
    function existeCodigo($ubi_codigo, $ubi_id = null) {
         $this->ubicacion = new Tab_ubicacion();
        $row = array();
        if ($ubi_id == null) {
            $sql = "select * from tab_ubicacion where tab_ubicacion.ubi_codigo = '$ubi_codigo' AND ubi_estado='1'";
            $row = $this->ubicacion->dbselectBySQL($sql);
        } else {
            $sql = "select * from tab_ubicacion where tab_ubicacion.ubi_codigo = '$ubi_codigo' AND ubi_id<>'$ubi_id' AND ubi_estado='1' ";
            $row = $this->ubicacion->dbselectBySQL($sql);
        }
        if (count($row) > 0) {
            return true;
        }
        return false;
    }  
}

?>