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
class expcampolista extends tab_expcampolista {

    function __construct() {
        //parent::__construct();
        $this->expcampolista = new tab_expcampolista();
    }


    function obtenerSelect($default = null) {
        $sql = "SELECT *
                FROM tab_expcampolista
                WHERE tab_expcampolista.ecl_estado = 1
                ORDER BY ecl_id ASC ";
        $row = $this->expcampolista->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->ecl_id)
                $option .="<option value='" . $val->ecl_id . "' selected>" . $val->ecl_tipdat . "</option>";
            else
                $option .="<option value='" . $val->ecl_id . "'>" . $val->ecl_tipdat . "</option>";
        }
        return $option;
    }
     
    function count($where) {
        $expcampolista = new Tab_expcampolista ();
        $sql = "SELECT count(ecl_id)
                FROM
                tab_expcampolista
                WHERE
                ecl_estado =  1 $where ";
        $num = $expcampolista->countBySQL($sql);
        return $num;
    }

    
    function count2($where, $ser_id) {
        $expcampolista = new tab_expcampolista ();       
        $sql = "SELECT count(tab_expcampolista.ecp_id)
                FROM
                tab_expcampo
                INNER JOIN tab_expcampolista ON tab_expcampo.ecp_id = tab_expcampolista.ecp_id
                WHERE tab_expcampolista.ecp_id = " . VAR3 . " AND tab_expcampolista.ecl_estado = 1 
                $where ";                
        $num = $expcampolista->countBySQL($sql);
        return $num;
    }    
    
}

?>