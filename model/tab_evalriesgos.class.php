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
class Tab_evalriesgos extends db {

    var $eva_id;
    var $dpr_id;
    var $rie_id;
    var $eva_frecuencia;
    var $eva_intensidad;
    var $eva_oficina;
    var $eva_usu_reg;
    var $eva_fecha_reg;
    var $eva_usu_mod;
    var $eva_fecha_mod;
    var $eva_estado;

    function __construct() {
        parent::__construct();
    }

    function getEva_id() {
        return $this->eva_id;
    }

    function setEva_id($eva_id) {
        $this->eva_id = $eva_id;
    }

    function getDpr_id() {
        return $this->dpr_id;
    }

    function setDpr_id($dpr_id) {
        $this->dpr_id = $dpr_id;
    }

    function getRie_id() {
        return $this->rie_id;
    }

    function setRie_id($rie_id) {
        $this->rie_id = $rie_id;
    }

    function getEva_frecuencia() {
        return $this->eva_frecuencia;
    }

    function setEva_frecuencia($eva_frecuencia) {
        $this->eva_frecuencia = $eva_frecuencia;
    }

    function getEva_intensidad() {
        return $this->eva_intensidad;
    }

    function setEva_intensidad($eva_intensidad) {
        $this->eva_intensidad = $eva_intensidad;
    }

    function getEva_oficina() {
        return $this->eva_oficina;
    }

    function setEva_oficina($eva_oficina) {
        $this->eva_oficina = $eva_oficina;
    }

    function getEva_usu_reg() {
        return $this->eva_usu_reg;
    }

    function setEva_usu_reg($eva_usu_reg) {
        $this->eva_usu_reg = $eva_usu_reg;
    }

    function getEva_fecha_reg() {
        return $this->eva_fecha_reg;
    }

    function setEva_fecha_reg($eva_fecha_reg) {
        $this->eva_fecha_reg = $eva_fecha_reg;
    }

    function getEva_usu_mod() {
        return $this->eva_usu_mod;
    }

    function setEva_usu_mod($eva_usu_mod) {
        $this->eva_usu_mod = $eva_usu_mod;
    }

    function getEva_fecha_mod() {
        return $this->eva_fecha_mod;
    }

    function setEva_fecha_mod($eva_fecha_mod) {
        $this->eva_fecha_mod = $eva_fecha_mod;
    }

    function getEva_estado() {
        return $this->eva_estado;
    }

    function setEva_estado($eva_estado) {
        $this->eva_estado = $eva_estado;
    }

}

?>