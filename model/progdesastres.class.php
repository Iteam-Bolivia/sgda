<?php

/**
 * progdesastres.class.php Model
 * 
 * @package   
 * @author lic. castellon
 * @copyright ITEAM 
 * @version $Id$ 2012
 * @access public
 */
class progdesastres extends tab_progdesastres {

    function __construct() {
        
    }

    function count2($query, $qtype) {
        $this->progdesastres = new Tab_progdesastres();
        $where = "";
        if ($query) {
            if ($qtype == 'des_id')
                $where = " AND $qtype = '$query' ";
            elseif ($qtype == 'dpr_id')
                $where = " AND $qtype IN (SELECT dpr_id FROM tab_docprevencion WHERE dpr_tipo LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $sql = "SELECT
                COUNT(tab_progdesastres.des_id) as num
                FROM
                tab_docprevencion
                Inner Join tab_progdesastres ON tab_progdesastres.dpr_id = tab_docprevencion.dpr_id
                WHERE
                tab_progdesastres.des_estado =  '1'
                AND
                tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "'
                AND
                tab_docprevencion.dpr_tipo =  'progdesastres' $where ";
        $num = $this->progdesastres->countBySQL($sql);
        return $num;
    }

}

?>
