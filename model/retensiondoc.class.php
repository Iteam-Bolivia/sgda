<?php

/**
 * retensiondoc.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class retensiondoc extends tab_retensiondoc {

    function __construct() {
        //parent::__construct();
        $this->retensiondoc = new Tab_retensiondoc();
    }


    function count($where) {
        $retensiondoc = new tab_retensiondoc ();
        $sql = "select count(red_id) as num
		from tab_retensiondoc
		WHERE red_estado = '1' $where ";
        $num = $retensiondoc->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $rows = $this->retensiondoc->dbSelectBySQL("SELECT
			tab_retensiondoc.red_id,
			tab_retensiondoc.red_codigo,
			tab_retensiondoc.red_series
			FROM
			tab_retensiondoc
			WHERE
			tab_retensiondoc.red_estado =  '1'
                        ORDER BY red_id ASC ");
        $option = "";
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->red_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->red_id . "' " . $selected . ">" . $val->red_series . "</option>";
            }
        }
        return $option;
    }


}

?>
