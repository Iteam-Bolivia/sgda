<?php

/**
 * docprevencion.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class docprestamo extends tab_docprestamo {

   function __construct() {
        $this->docprestamo = new Tab_docprestamo();
    }

    function count2($query, $qtype, $admin) {
        $num = 0;
        $whereQuery = "";
        $this->docprevencion = new Tab_docprevencion();
        if ($query) {
            if ($qtype == 'dpr_id')
                $whereQuery = " AND $qtype = '$query' ";
            elseif ($qtype == 'unidad')
                $whereQuery = " AND uni_id IN (SELECT uni_id FROM tab_unidad WHERE uni_codigo LIKE '%$query%') ";
            else
                $whereQuery = " AND $qtype LIKE '%$query%' ";
        }
        if ($admin) {
            $num = $this->docprevencion->countBySQL("SELECT COUNT(tab_docprevencion.dpr_id) as num FROM tab_docprevencion WHERE dpr_estado = '1' $whereQuery ");
        } else {
            $num = $this->docprevencion->countBySQL("SELECT
				COUNT(tab_docprevencion.dpr_id) as num
				FROM
				tab_docprevencion
				WHERE
				tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "' AND
				tab_docprevencion.dpr_estado =  '1' $whereQuery ");
        }
        return $num;
    }
    function obtenerMaximo($field){
      $maximo=new Tab_docprestamo();
    $max=$maximo->dbSelectBySQL("SELECT* from tab_docprestamo
   where $field = (select max($field) from tab_docprestamo)");
   $mx=$max[0];
    $incre=$mx->dpr_orden+1;
    return $incre;
    }

}

?>
