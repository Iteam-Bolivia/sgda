<?php

/**
 * prestamos.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class prestamos extends tab_prestamos {

    function __construct() {
        $this->prestamo = new Tab_prestamos();
    }

    function count($where) {
        $num = 0;
        $sql = "SELECT COUNT (DISTINCT p.pre_id) as num
FROM tab_prestamos AS p
            Inner Join tab_expediente AS e ON e.exp_id = p.exp_id
            Inner Join tab_series AS s ON s.ser_id = e.ser_id
            Inner Join tab_expusuario AS u ON u.exp_id = e.exp_id
            Inner Join tab_usuario AS us ON u.usu_id = us.usu_id
            Inner Join tab_unidad AS un ON us.uni_id = un.uni_id
            Inner Join tab_expfondo AS ef ON e.exp_id = ef.exp_id
            WHERE
            p.pre_estado =  '1' AND
            u.eus_estado =  '1' AND
            ef.exf_estado =  '1'$where ";
        $num = $this->prestamo->countBySQL($sql);
        return $num;
    }

}

?>
