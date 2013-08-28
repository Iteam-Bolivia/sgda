<?php

/**
 * inventario.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class inventario extends tab_inventario {

    function __construct() {
        $this->inventario = new Tab_inventario();
    }

    function count($where) {
        $sql = "SELECT COUNT(tab_expediente.exp_id) as num
                FROM
                tab_expediente
                INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                INNER JOIN tab_series ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                WHERE tab_expediente.exp_estado = '1' 
                AND tab_expusuario.eus_estado = '1'                 
                AND tab_expfondo.exf_estado = '1' 
                AND tab_usuario.usu_id = $_SESSION ['USU_ID']' 
                $where ";            
                    
//        $sql = "SELECT
//                    COUNT(DISTINCT i.inv_id) as num
//                    FROM
//                    tab_inventario AS i
//                    Inner Join tab_expediente AS e ON i.exp_id = e.exp_id
//                    Inner Join tab_unidad AS u2 ON u2.uni_id = i.uni_id
//                    Inner Join tab_series AS s ON s.ser_id = e.ser_id
//					Inner Join tab_expfondo AS ef ON ef.exp_id = e.exp_id
//                    WHERE inv_estado = 1 AND ef.exf_estado = '1' $where ";

        $num = $this->inventario->countBySQL($sql);
        return $num;
    }
}

?>
