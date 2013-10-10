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
class expcampovalor extends tab_expcampovalor {

    function __construct() {
        //parent::__construct();
        $this->expcampovalor = new tab_expcampovalor();
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT *
                FROM tab_expcampovalor
                WHERE tab_expcampovalor.ecv_estado = 1
                ORDER BY ecv_id ASC ";
        $row = $this->expcampovalor->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->ecv_id)
                $option .="<option value='" . $val->ecv_id . "' selected>" . $val->ecv_valor . "</option>";
            else
                $option .="<option value='" . $val->ecv_id . "'>" . $val->ecv_valor . "</option>";
        }
        return $option;
    }


    function count($where) {
        $expcampovalor = new Tab_expcampovalor ();
        $sql = "SELECT count(ecv_id)
                FROM
                tab_expcampovalor
                WHERE
                ecv_estado =  1 $where ";
        $num = $expcampovalor->countBySQL($sql);
        return $num;
    }

    function obtenerIdCampoValor($ecp_id, $ecl_valor) {
            $row = "";
            $this->expcampovalor = new tab_expcampovalor();
            $row = $this->expcampovalor->dbselectBySQL("SELECT
                    ecl_id
                    FROM
                    tab_tab_expcampovalor
                    WHERE
                    ecp_estado = 1 
                    AND ecp_id = '$ecp_id' 
                    AND ecl_valor = '$ecl_valor' ");
            if (count($row) > 0)
            return $row[0]->ecl_id;
            else
            return 0;
    }    
    
    function obtenerIdCampoValorporExpediente($ecp_id, $exp_id) {
            $row = "";
            $this->expcampovalor = new tab_expcampovalor();
            $row = $this->expcampovalor->dbselectBySQL("SELECT
                    ecv_id
                    FROM
                    tab_expcampovalor
                    WHERE
                    ecv_estado = 1 
                    AND ecp_id = '$ecp_id' 
                    AND exp_id = '$exp_id' ");
            if (count($row) > 0)
            return $row[0]->ecv_id;
            else
            return 0;
    }    
    
    
}

?>