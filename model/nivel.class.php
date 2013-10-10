<?php

/**
 * nivel.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class nivel extends tab_nivel {

    function __construct() {
        //parent::__construct();
        $this->nivel = new Tab_nivel();
    }

    function loadMenu() {
        $row = $this->nivel->dbselectBySQL("select * from tab_nivel where niv_estado = 1 ORDER BY niv_codigo ASC");
        $search = "";
        foreach ($row as $val) {
            $search .= ",{separator: true},{name: '" . $val->niv_abrev . "', bclass: 'nivel', onpress : test}";
        }
        return $search;
    }

    function count($tipo, $value1) {
        $nivel = new tab_nivel ();
        $row = array();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($tipo == 'niv_id')
                $where = " AND $tipo = '$value1' ";
            else
                $where = " AND $tipo LIKE '%$value1%' ";
        }
        $sql = "select count(niv_id) as num
		from tab_nivel
		WHERE niv_estado = '1' $where ";
        $num = $nivel->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $rows = $this->nivel->dbSelectBySQL("SELECT
			tab_nivel.niv_id,
			tab_nivel.niv_codigo,
			tab_nivel.niv_descripcion
			FROM
			tab_nivel
			WHERE
			tab_nivel.niv_estado =  '1'
                        ORDER BY niv_id ASC ");
        $option = "";
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->niv_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->niv_id . "' " . $selected . ">" . $val->niv_descripcion . "</option>";
            }
        }
        return $option;
    }

    function existeCodigo($codigo, $niv_id = null) {
        $row = array();
        if ($niv_id == null) {
            $sql = "select * from tab_nivel where niv_codigo like '$codigo' ";
            $row = $this->nivel->dbselectBySQL($sql);
        } else {
            $sql = "select * from tab_nivel where niv_codigo like '$codigo' AND niv_id<>'$niv_id' ";
            $row = $this->nivel->dbselectBySQL($sql);
        }
        if (count($row) > 0) {
            return true;
        }
        return false;
    }

}

?>
