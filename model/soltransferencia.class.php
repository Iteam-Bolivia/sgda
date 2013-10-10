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
class soltransferencia extends tab_soltransferencia {

    function __construct() {
        //parent::__construct();
        $this->soltransferencia = new tab_soltransferencia();
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select *
			from tab_soltransferencia
			where tab_soltransferencia.str_estado = 1
			ORDER BY str_id ASC ";
        $row = $this->soltransferencia->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->str_id)
                $option .="<option value='" . $val->str_id . "' selected>" . $val->str_nrocajas . "</option>";
            else
                $option .="<option value='" . $val->str_id . "'>" . $val->str_nrocajas . "</option>";
        }
        return $option;
    }

    function count($where) {
        $soltransferencia = new Tab_soltransferencia ();
        $sql = "SELECT count(tab_soltransferencia.str_id)
                FROM
                tab_unidad
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                INNER JOIN tab_exptransferencia ON tab_expediente.exp_id = tab_exptransferencia.exp_id
                INNER JOIN tab_soltransferencia ON tab_soltransferencia.str_id = tab_exptransferencia.str_id
                WHERE
                tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . "
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_usuario.usu_estado = 1
                AND tab_expusuario.eus_estado = 3
                $where ";
        //echo($sql);die;
        $num = $soltransferencia->countBySQL($sql);
        return $num;
    }

    function countExp2($where){
            $this->expediente = new tab_expediente ();
            $num = 0;        
            $sql = "SELECT COUNT(tab_soltransferencia.str_id)
                    FROM
                    tab_soltransferencia
                    WHERE 
                    tab_soltransferencia.str_estado = 1 AND
                    tab_soltransferencia.usu_id = " . $_SESSION['USU_ID'] . "  
                    $where ";
            $num = $this->expediente->countBySQL($sql);
            return $num;        
    }   
    
    function obtenerMaximo($field){
      $maximo=new tab_soltransferencia();
    $max=$maximo->dbSelectBySQL("SELECT* from tab_soltransferencia
   where $field = (select max($field) from tab_soltransferencia)");
   $mx=$max[0];
    $id=$mx->str_id;
    return $id;
    }

}

?>