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
class docprevencion extends tab_docprevencion {

    function __construct() {

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

}

?>
