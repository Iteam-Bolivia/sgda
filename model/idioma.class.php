<?php

/**
 * archivoModel
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class idioma extends tab_idioma {

    function __construct() {
        //parent::__construct();
        $this->idioma = new tab_idioma();
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select *
                from tab_idioma
                where tab_idioma.idi_estado = 1
                ORDER BY idi_id ASC ";
        $row = $this->idioma->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->idi_id)
                $option .="<option value='" . $val->idi_id . "' selected>" . $val->idi_nombre . "</option>";
            else
                $option .="<option value='" . $val->idi_id . "'>" . $val->idi_nombre . "</option>";
        }
        return $option;
    }

    function count($where) {
        $num = 0;
        $idioma = new Tab_idioma ();
        $sql = "SELECT count(idi_id)
                    FROM
                    tab_idioma
                    WHERE
                    idi_estado =  1 $where ";
        $num = $idioma->countBySQL($sql);
        return $num;
    }
    
    


}

?>