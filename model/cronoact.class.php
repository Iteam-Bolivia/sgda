<?php

/**
 * cronoact.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class cronoact extends tab_cronoact {

    function __construct() {

    }

    function count2($query, $qtype, $cronog_id) {

        $this->cronoact = new Tab_cronoact();
        if ($query)
            $whereQuery = " $qtype LIKE '%$query%' AND ";
        else
            $whereQuery = "";
        $row = $this->cronoact->dbSelectBySQL("SELECT
			COUNT(tab_cronoact.cro_id) as num
			FROM
			tab_cronoact
			Inner Join tab_plandesastre ON tab_plandesastre.pla_id = tab_cronoact.pla_id
			WHERE $whereQuery
			tab_cronoact.cro_estado =  '1' AND
			tab_cronoact.pla_id =  '" . $cronog_id . "' ");
        return $row[0]->num;
    }

}

?>
