<?php

/**
 * expunidad.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expunidad extends tab_expunidad {

    function __construct() {

    }

    function saveUniVer($exp_id, $uni_id, $ver_id) {
        $this->expunidad = new Tab_expunidad();
        $this->expunidad->euv_id = '';
        $this->expunidad->exp_id = $exp_id;
        $this->expunidad->uni_id = $uni_id;
        $this->expunidad->ver_id = $ver_id;
        $this->expunidad->euv_fecha_crea = date("Y-m-d");
        $this->expunidad->euv_estado = '1';
        return $this->expunidad->insert();
    }

}

?>
