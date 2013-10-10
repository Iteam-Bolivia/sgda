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
class sistema extends tab_sistema {

    function __construct() {
        //parent::__construct();
        $this->sistema = new tab_sistema();
    }

    function count($where) {
        $sistema = new Tab_sistema ();
        $sql = "SELECT count(sis_id)
                    FROM
                    tab_sistema AS u
                    WHERE
                    u.sis_estado =  1 $where ";
        $num = $sistema->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $option = "";
        if ($default == '1')
            $option .="<option value='1' selected>BD</option><option value='2'>SERVIDOR</option>";
        else
            $option .="<option value='1'>BD</option><option value='2' selected>SERVIDOR</option>";

        return $option;
    }

    function existeCodigo($sis_codigo) {
        $row = array();
        if ($sis_codigo != null) {
            $sql = "select * 
                    from tab_sistema 
                    where tab_sistema.sis_codigo = '$sis_codigo' ";
            $row = $this->sistema->dbselectBySQL($sql);
        }else{
            return false;
        }
        if (count($row) > 0) {
            return true;
        } else return false;
    }  
}

?>