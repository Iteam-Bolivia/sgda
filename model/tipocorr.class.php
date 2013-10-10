<?php

/**
 * tipocorr.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class tipocorr extends tab_tipocorr {

    function __construct() {
        //parent::__construct();
        $this->tipocorr = new Tab_tipocorr();
    }


    function count($where) {
        $tipocorr = new tab_tipocorr ();
        $sql = "select count(tco_id) as num
		from tab_tipocorr
		WHERE tco_estado = '1' $where ";
        $num = $tipocorr->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $rows = $this->tipocorr->dbSelectBySQL("SELECT
			tab_tipocorr.tco_id,
			tab_tipocorr.tco_codigo,
			tab_tipocorr.tco_nombre
			FROM
			tab_tipocorr
			WHERE
			tab_tipocorr.tco_estado =  '1'
                        ORDER BY tco_id ASC ");
        $option = "";
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->tco_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->tco_id . "' " . $selected . ">" . $val->tco_nombre . "</option>";
            }
        }
        return $option;
    }

    
    function getCodigoById($tco_id) {
        $tipocorr = new tab_tipocorr();
        $sql = "SELECT
                tab_tipocorr.tco_codigo
                FROM
                tab_tipocorr
                WHERE tab_tipocorr.tco_estado = 1 AND tab_tipocorr.tco_id = $tco_id ";
        $result = $tipocorr->dbSelectBySQL($sql);
        $tco_codigo = "";
        foreach ($result as $tipo) {
            $tco_codigo = $tipo->tco_codigo;
        }
        return $tco_codigo;
    }    

}

?>
