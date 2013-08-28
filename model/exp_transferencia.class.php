<?php

/**
 * archivoModel
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2010
 * @access public
 */
class exp_transferencia extends tab_exp_transferencia {

    function __conetruct() {
        //parent::__conetruct();
        $this->exp_transferencia = new tab_exp_transferencia();
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select *
			from tab_exp_transferencia
			where tab_exp_transferencia.etr_estado = 1
			ORDER BY etr_id ASC ";
        $row = $this->exp_transferencia->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->etr_id)
                $option .="<option value='" . $val->etr_id . "' selected>" . $val->etr_nrocajas . "</option>";
            else
                $option .="<option value='" . $val->etr_id . "'>" . $val->etr_nrocajas . "</option>";
        }
        return $option;
    }

    function count($where) {
        $exp_transferencia = new Tab_exp_transferencia ();
        $sql = "SELECT count(etr_id)
                    FROM
                    tab_exp_transferencia
                    WHERE
                    etr_estado =  1 $where ";
        //echo($sql);die;
        $num = $exp_transferencia->countBySQL($sql);
        return $num;
    }

}

?>