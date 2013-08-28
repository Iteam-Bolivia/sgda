<?php

/**
 * tab_evalriesgos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_eval_intensidad extends db {

    var $evi_id;
    var $int_id;
    var $evi_usu_reg;
    var $evi_fecha_reg;
    var $evi_usu_mod;
    var $evi_fecha_mod;
    var $evi_estado;

    function __construct() {
        parent::__construct();
    }

    function getEvi_id() {
        return $this->evi_id;
    }

    function setEvi_id($evi_id) {
        $this->evi_id = $evi_id;
    }

    function getInt_id() {
        return $this->int_id;
    }

    function setInt_id($int_id) {
        $this->int_id = $int_id;
    }

    function getEvi_usu_reg() {
        return $this->evi_usu_reg;
    }

    function setEvi_usu_reg($evi_usu_reg) {
        $this->evi_usu_reg = $evi_usu_reg;
    }

    function getEvi_fecha_reg() {
        return $this->evi_fecha_reg;
    }

    function setEvi_fecha_reg($evi_fecha_reg) {
        $this->evi_fecha_reg = $evi_fecha_reg;
    }

    function getEvi_usu_mod() {
        return $this->evi_usu_mod;
    }

    function setEvi_usu_mod($evi_usu_mod) {
        $this->evi_usu_mod = $evi_usu_mod;
    }

    function getEvi_fecha_mod() {
        return $this->evi_fecha_mod;
    }

    function setEvi_fecha_mod($evi_fecha_mod) {
        $this->evi_fecha_mod = $evi_fecha_mod;
    }

    function getEvi_estado() {
        return $this->evi_estado;
    }

    function setEvi_estado($evi_estado) {
        $this->evi_estado = $evi_estado;
    }

}

?>