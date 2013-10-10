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
class tipoctt extends tab_tipoctt {

    function __construct() {
        //parent::__construct();
        $this->tipoctt = new tab_tipoctt();
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select *
			from tab_tipoctt
			where tab_tipoctt.tct_estado = 1
			ORDER BY tct_id ASC ";
        $row = $this->tipoctt->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->tct_id)
                $option .="<option value='" . $val->tct_id . "' selected>" . $val->tct_nombre . "</option>";
            else
                $option .="<option value='" . $val->tct_id . "'>" . $val->tct_nombre . "</option>";
        }
        return $option;
    }

    function count($where) {
        $tipoctt = new Tab_tipoctt ();
        $sql = "SELECT count(tct_id)
                    FROM
                    tab_tipoctt
                    WHERE
                    tct_estado =  1 $where ";
        //echo($sql);die;
        $num = $tipoctt->countBySQL($sql);
        return $num;
    }

    function existeCodigo($uni_codigo) {
        $row = array();
        if ($uni_codigo != null) {
            $sql = "select * 
                    from tab_tipoctt 
                    where tab_tipoctt.tct_codigo = '$tct_codigo' ";
            $row = $this->tipoctt->dbselectBySQL($sql);
        } else {
            return false;
        }
        if (count($row) > 0) {
            return true;
        } else
            return false;
    }
    
    
    function obtenerIdDeptoCodigoSerie($ser_codigo) {
        $delimiter = DELIMITER;
        $tipoctt = new Tab_tipoctt();
        $codigo=explode($delimiter, $ser_codigo);
        $tct_codigo = $codigo[0];        
        $tct_id = 0;
        $rows = "";
        $sql = "SELECT 
                tct_id
		FROM tab_tipoctt
		WHERE 
                tct_estado = '1' 
                AND tct_codigo = '$tct_codigo' ";
        $rows = $tipoctt->dbselectBySQL($sql);
        foreach ($rows as $val) {
            $tct_id = $val->tct_id;
        }
        return $tct_id;
    }    

}

?>