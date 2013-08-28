<?php

/**
 * tab_expunidad.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_expunidad extends db {

    var $euv_id;
    var $exp_id;
    var $uni_id;
    var $ver_id;
    var $euv_fecha_crea;
    var $euv_estado;

    function __construct() {
        parent::__construct();
    }

    function getEuv_id() {
        return $this->euv_id;
    }

    function setEuv_id($euv_id) {
        $this->euv_id = $euv_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getVer_id() {
        return $this->ver_id;
    }

    function setVer_id($ver_id) {
        $this->ver_id = $ver_id;
    }

    function getEuv_fecha_crea() {
        return $this->euv_fecha_crea;
    }

    function setEuv_fecha_crea($euv_fecha_crea) {
        $this->euv_fecha_crea = $euv_fecha_crea;
    }

    function getEuv_estado() {
        return $this->euv_estado;
    }

    function setEuv_estado($euv_estado) {
        $this->euv_estado = $euv_estado;
    }

}

?>