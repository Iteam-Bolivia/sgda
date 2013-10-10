<?php

/**
 * Tab_usu_serie.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_usu_apoyo extends db {

    var $use_id;
    var $usu_id;
    var $ser_id;
    var $use_fecha_crea;
    var $use_fecha_mod;
    var $use_usuario_crea;
    var $use_usuario_mod;
    var $use_estado;

    function __construct() {
        parent::__construct();
    }

    function getUse_id() {
        return $this->use_id;
    }

    function setUse_id($use_id) {
        $this->use_id = $use_id;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getSer_id() {
        return $this->ser_id;
    }

    function setSer_id($ser_id) {
        $this->ser_id = $ser_id;
    }

    function getUse_fecha_crea() {
        return $this->use_fecha_crea;
    }

    function setUse_fecha_crea($use_fecha_crea) {
        $this->use_fecha_crea = $use_fecha_crea;
    }

    function getUse_fecha_mod() {
        return $this->use_fecha_mod;
    }

    function setUse_fecha_mod($use_fecha_mod) {
        $this->use_fecha_mod = $use_fecha_mod;
    }

    function getUse_usuario_crea() {
        return $this->use_usuario_crea;
    }

    function setUse_usuario_crea($use_usuario_crea) {
        $this->use_usuario_crea = $use_usuario_crea;
    }

    function getUse_usuario_mod() {
        return $this->use_usuario_mod;
    }

    function setUse_usuario_mod($use_usuario_mod) {
        $this->use_usuario_mod = $use_usuario_mod;
    }

    function getUse_estado() {
        return $this->use_estado;
    }

    function setUse_estado($use_estado) {
        $this->use_estado = $use_estado;
    }

}

?>