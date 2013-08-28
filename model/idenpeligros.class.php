<?php

/**
 * idenpeligros.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class idenpeligros extends tab_idenpeligros {

    function __construct() {
        
    }

    function count2($query, $qtype) {
        $this->idenpeligros = new Tab_idenpeligros();
        $where = "";
        if ($query) {
            if ($qtype == 'ide_id')
                $where = " AND $qtype = '$query' ";
            elseif ($qtype == 'loc_id')
                $where = " AND loc_id IN (SELECT loc_id FROM tab_locales WHERE loc_descripcion LIKE '%$query%') ";
            elseif ($qtype == 'dpr_id')
                $where = " AND $qtype IN (SELECT dpr_id FROM tab_docprevencion WHERE dpr_tipo LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $num = $this->idenpeligros->countBySQL("SELECT
			COUNT(tab_idenpeligros.ide_id) as num
			FROM
			tab_docprevencion
			Inner Join tab_idenpeligros ON tab_idenpeligros.dpr_id = tab_docprevencion.dpr_id
			WHERE 
			tab_idenpeligros.ide_estado =  '1'
			AND
			tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "'
			AND
			tab_docprevencion.dpr_tipo =  'idenpeligros' $where");
        return $num;
    }

}

?>
