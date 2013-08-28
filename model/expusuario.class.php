<?php

/**
 * expusuario.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expusuario extends tab_expusuario {

    function __construct() {

    }

    function saveExp($exp_id, $usu_id) {

        $this->expusuario = new Tab_expusuario();
        $this->expusuario->eus_id = '';
        $this->expusuario->exp_id = $exp_id;
        $this->expusuario->usu_id = $usu_id;
        $this->expusuario->eus_fecha_crea = date("Y-m-d");
        $this->expusuario->eus_estado = '1';
        return $this->expusuario->insert();
    }

}

?>
