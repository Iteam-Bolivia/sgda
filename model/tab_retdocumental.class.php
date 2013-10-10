<?php

/**
 * tab_ret.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_retdocumental extends db {

    var $ret_id;
    var $ser_id;
    var $fon_id;
    var $ret_anios;
    var $ret_usuario_crea;
    var $ret_fecha_crea;
    var $ret_fecha_mod;
    var $ret_usu_mod;
    var $ret_estado;

    function __construct() {
        parent::__construct();
    }

    function getRet_id() {
        return $this->ret_id;
    }

    function setRet_id($ret_id) {
        $this->ret_id = $ret_id;
    }

    function getSer_id() {
        return $this->ser_id;
    }

    function setSer_id($ser_id) {
        $this->ser_id = $ser_id;
    }

    function getFon_id() {
        return $this->fon_id;
    }

    function setFon_id($fon_id) {
        $this->fon_id = $fon_id;
    }

    function getRet_anios() {
        return $this->ret_anios;
    }

    function setRet_anios($ret_anios) {
        $this->ret_anios = $ret_anios;
    }

    function getRet_fecha_crea() {
        return $this->ret_fecha_crea;
    }

    function setRet_fecha_crea($ret_fecha_crea) {
        $this->ret_fecha_crea = $ret_fecha_crea;
    }

    function getRet_fecha_mod() {
        return $this->ret_fecha_mod;
    }

    function setRet_fecha_mod($ret_fecha_mod) {
        $this->ret_fecha_mod = $ret_fecha_mod;
    }

    function getRet_usuario_crea() {
        return $this->ret_usuario_crea;
    }

    function setRet_usuario_crea($ret_usuario_crea) {
        $this->ret_usuario_crea = $ret_usuario_crea;
    }

    function getRet_usu_mod() {
        return $this->ret_usu_mod;
    }

    function setRet_usu_mod($ret_usu_mod) {
        $this->ret_usu_mod = $ret_usu_mod;
    }

    function getRet_estado() {
        return $this->ret_estado;
    }

    function setRet_estado($ret_estado) {
        $this->ret_estado = $ret_estado;
    }

}

?>