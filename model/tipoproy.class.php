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
class tipoproy extends tab_tipoproy {

    function __construct() {
        //parent::__construct();
        $this->tipoproy = new tab_tipoproy();
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select *
			from tab_tipoproy
			where tab_tipoproy.tpy_estado = 1
			ORDER BY tpy_id ASC ";
        $row = $this->tipoproy->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->tpy_id)
                $option .="<option value='" . $val->tpy_id . "' selected>" . $val->tpy_nombre . "</option>";
            else
                $option .="<option value='" . $val->tpy_id . "'>" . $val->tpy_nombre . "</option>";
        }
        return $option;
    }

    function count($where) {
        $tipoproy = new Tab_tipoproy ();
        $sql = "SELECT count(tpy_id)
                    FROM
                    tab_tipoproy
                    WHERE
                    tpy_estado =  1 $where ";
        //echo($sql);die;
        $num = $tipoproy->countBySQL($sql);
        return $num;
    }

    function existeCodigo($uni_codigo) {
        $row = array();
        if ($uni_codigo != null) {
            $sql = "select * 
                    from tab_tipoproy 
                    where tab_tipoproy.tpy_codigo = '$tpy_codigo' ";
            $row = $this->tipoproy->dbselectBySQL($sql);
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
        $tipoproy = new Tab_tipoproy();
        $codigo=explode($delimiter, $ser_codigo);
        $tpy_codigo = $codigo[0];        
        $tpy_id = 0;
        $rows = "";
        $sql = "SELECT 
                tpy_id
		FROM tab_tipoproy
		WHERE 
                tpy_estado = '1' 
                AND tpy_codigo = '$tpy_codigo' ";
        $rows = $tipoproy->dbselectBySQL($sql);
        foreach ($rows as $val) {
            $tpy_id = $val->tpy_id;
        }
        return $tpy_id;
    }    

}

?>