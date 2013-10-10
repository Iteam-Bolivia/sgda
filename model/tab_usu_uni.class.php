<?php

/**
 * Tab_usu_uni.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_usu_uni extends db {

    var $usn_id;
    var $usu_id;
    var $uni_id;
    var $usn_fecha_crea;
    var $usn_fecha_mod;
    var $usn_usuario_crea;
    var $usn_usuario_mod;
    var $usn_estado;
    var $ver_id;

    function __construct() {
        parent::__construct();
    }

    function getUsn_id() {
        return $this->usn_id;
    }

    function setUsn_id($usn_id) {
        $this->usn_id = $usn_id;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getVer_id() {
        return $this->ver_id;
    }

    function setVer_id($ver_id) {
        $this->ver_id = $ver_id;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getUsn_fecha_crea() {
        return $this->usn_fecha_crea;
    }

    function setUsn_fecha_crea($usn_fecha_crea) {
        $this->usn_fecha_crea = $usn_fecha_crea;
    }

    function getUsn_fecha_mod() {
        return $this->usn_fecha_mod;
    }

    function setUsn_fecha_mod($usn_fecha_mod) {
        $this->usn_fecha_mod = $usn_fecha_mod;
    }

    function getUsn_usuario_crea() {
        return $this->usn_usuario_crea;
    }

    function setUsn_usuario_crea($usn_usuario_crea) {
        $this->usn_usuario_crea = $usn_usuario_crea;
    }

    function getUsn_usuario_mod() {
        return $this->usn_usuario_mod;
    }

    function setUsn_usuario_mod($usn_usuario_mod) {
        $this->usn_usuario_mod = $usn_usuario_mod;
    }

    function getUsn_estado() {
        return $this->usn_estado;
    }

    function setUsn_estado($usn_estado) {
        $this->usn_estado = $usn_estado;
    }

}

?>