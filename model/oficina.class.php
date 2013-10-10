<?php

/**
 * oficina.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class oficina extends tab_oficina {

    function __construct() {
        //parent::__construct();
        $this->oficina = new Tab_oficina();
    }


    function count($tipo, $value1) {
        $oficina = new tab_oficina ();
        $row = array();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($tipo == 'ofi_id')
                $where = " AND $tipo = '$value1' ";
            else
                $where = " AND $tipo LIKE '%$value1%' ";
        }
        $sql = "select count(ofi_id) as num
		from tab_oficina
		WHERE ofi_estado = '1' $where ";
        $num = $oficina->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $rows = $this->oficina->dbSelectBySQL("SELECT
			tab_oficina.ofi_id,
			tab_oficina.ofi_codigo,
			tab_oficina.ofi_nombre
			FROM
			tab_oficina
			WHERE
			tab_oficina.ofi_estado =  '1'
                        ORDER BY ofi_id ASC ");
        $option = "";
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->ofi_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->ofi_id . "' " . $selected . ">" . $val->ofi_nombre . "</option>";
            }
        }
        return $option;
    }


}

?>
