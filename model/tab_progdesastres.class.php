<?php

/**
 * tab_progdesastres.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_progdesastres extends db {

    var $des_id;
    var $dpr_id;
    var $des_resumen;
    var $des_indicador;
    var $des_fuentes;
    var $des_riesgo;
    var $des_usu_reg;
    var $des_fecha_reg;
    var $des_usu_mod;
    var $des_fecha_mod;
    var $des_estado;

    function __construct() {
        parent::__construct();
    }

    function getDes_id() {
        return $this->des_id;
    }

    function setDes_id($des_id) {
        $this->des_id = $des_id;
    }

    function getDpr_id() {
        return $this->dpr_id;
    }

    function setDpr_id($dpr_id) {
        $this->dpr_id = $dpr_id;
    }

    function getDes_resumen() {
        return $this->des_resumen;
    }

    function setDes_resumen($des_resumen) {
        $this->des_resumen = $des_resumen;
    }

    function getDes_indicador() {
        return $this->des_indicador;
    }

    function setDes_indicador($des_indicador) {
        $this->des_indicador = $des_indicador;
    }

    function getDes_fuentes() {
        return $this->des_fuentes;
    }

    function setDes_fuentes($des_fuentes) {
        $this->des_fuentes = $des_fuentes;
    }

    function getDes_riesgo() {
        return $this->des_riesgo;
    }

    function setDes_riesgo($des_riesgo) {
        $this->des_riesgo = $des_riesgo;
    }

    function getDes_usu_reg() {
        return $this->des_usu_reg;
    }

    function setDes_usu_reg($des_usu_reg) {
        $this->des_usu_reg = $des_usu_reg;
    }

    function getDes_fecha_reg() {
        return $this->des_fecha_reg;
    }

    function setDes_fecha_reg($des_fecha_reg) {
        $this->des_fecha_reg = $des_fecha_reg;
    }

    function getDes_usu_mod() {
        return $this->des_usu_mod;
    }

    function setDes_usu_mod($des_usu_mod) {
        $this->des_usu_mod = $des_usu_mod;
    }

    function getDes_fecha_mod() {
        return $this->des_fecha_mod;
    }

    function setDes_fecha_mod($des_fecha_mod) {
        $this->des_fecha_mod = $des_fecha_mod;
    }

    function getDes_estado() {
        return $this->des_estado;
    }

    function setDes_estado($des_estado) {
        $this->des_estado = $des_estado;
    }

}

?>