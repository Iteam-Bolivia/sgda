<?php

/**
 * tab_expusuario.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_expusuario extends db {

    var $eus_id;
    var $usu_id;
    var $exp_id;
    var $eus_fecha_crea;
    var $eus_estado;

    function __construct() {
        parent::__construct();
    }

    function getEus_id() {
        return $this->eus_id;
    }

    function setEus_id($eus_id) {
        $this->eus_id = $eus_id;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getEus_fecha_crea() {
        return $this->eus_fecha_crea;
    }

    function setEus_fecha_crea($eus_fecha_crea) {
        $this->eus_fecha_crea = $eus_fecha_crea;
    }

    function getEus_estado() {
        return $this->eus_estado;
    }

    function setEus_estado($eus_estado) {
        $this->eus_estado = $eus_estado;
    }


}

?>