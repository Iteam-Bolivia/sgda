<?php

/**
 * tab_soltransferencia.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_soltransferencia extends db {

    var $str_id;
    var $str_fecha;    
    var $uni_id;
    var $unid_id;
    var $usu_id;
    var $usud_id;    
    var $str_nrocajas;    
    var $str_totpzas;
    var $str_totml;
    var $str_nroreg;
    var $str_fecini;
    var $str_fecfin;
    var $str_estado;

    function __construct() {
        parent::__construct();
    }

    function getStr_id() {
        return $this->str_id;
    }

    function setStr_id($str_id) {
        $this->str_id = $str_id;
    }

    function getStr_fecha() {
        return $this->str_fecha;
    }

    function setStr_fecha($str_fecha) {
        $this->str_fecha = $str_fecha;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getUnid_id() {
        return $this->unid_id;
    }

    function setUnid_id($unid_id) {
        $this->unid_id = $unid_id;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }    
    
    function getUsud_id() {
        return $this->usud_id;
    }

    function setUsud_id($usud_id) {
        $this->usud_id = $usud_id;
    } 
    
    function getStr_nrocajas() {
        return $this->str_nrocajas;
    }

    function setStr_nrocajas($str_nrocajas) {
        $this->str_nrocajas = $str_nrocajas;
    }    
    
    function getStr_totpzas() {
        return $this->str_totpzas;
    }

    function setStr_totpzas($str_totpzas) {
        $this->str_totpzas = $str_totpzas;
    }    
    
    function getStr_totml() {
        return $this->str_totml;
    }

    function setStr_totml($str_totml) {
        $this->str_totml = $str_totml;
    } 
    
    function getStr_nroreg() {
        return $this->str_nroreg;
    }

    function setStr_nroreg($str_nroreg) {
        $this->str_nroreg = $str_nroreg;
    }
    
    function getStr_fecini() {
        return $this->str_fecini;
    }

    function setStr_fecini($str_fecini) {
        $this->str_fecini = $str_fecini;
    }
    
    function getStr_fecfin() {
        return $this->str_fecfin;
    }

    function setStr_fecfin($str_fecfin) {
        $this->str_fecfin = $str_fecfin;
    }    
    
    function getStr_estado() {
        return $this->str_estado;
    }

    function setStr_estado($str_estado) {
        $this->str_estado = $str_estado;
    }

}

?>