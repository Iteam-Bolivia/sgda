<?php

/**
 * tab_idenpeligros.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_idenpeligros extends db {

    var $ide_id;
    var $dpr_id;
    var $loc_id;
    var $ide_ele_ex;
    var $ide_peligros;
    var $ide_oficina;
    var $ide_observaciones;
    var $ide_usu_reg;
    var $ide_fecha_reg;
    var $ide_usu_mod;
    var $ide_fecha_mod;
    var $ide_estado;

    function __construct() {
        parent::__construct();
    }

    function getIde_id() {
        return $this->ide_id;
    }

    function setIde_id($ide_id) {
        $this->ide_id = $ide_id;
    }

    function getDpr_id() {
        return $this->dpr_id;
    }

    function setDpr_id($dpr_id) {
        $this->dpr_id = $dpr_id;
    }

    function getLoc_id() {
        return $this->loc_id;
    }

    function setLoc_id($loc_id) {
        $this->loc_id = $loc_id;
    }

    function getIde_ele_ex() {
        return $this->ide_ele_ex;
    }

    function setIde_ele_ex($ide_ele_ex) {
        $this->ide_ele_ex = $ide_ele_ex;
    }

    function getIde_peligros() {
        return $this->ide_peligros;
    }

    function setIde_peligros($ide_peligros) {
        $this->ide_peligros = $ide_peligros;
    }

    function getIde_oficina() {
        return $this->ide_oficina;
    }

    function setIde_oficina($ide_oficina) {
        $this->ide_oficina = $ide_oficina;
    }

    function getIde_observaciones() {
        return $this->ide_observaciones;
    }

    function setIde_observaciones($ide_observaciones) {
        $this->ide_observaciones = $ide_observaciones;
    }

    function getIde_usu_reg() {
        return $this->ide_usu_reg;
    }

    function setIde_usu_reg($ide_usu_reg) {
        $this->ide_usu_reg = $ide_usu_reg;
    }

    function getIde_fecha_reg() {
        return $this->ide_fecha_reg;
    }

    function setIde_fecha_reg($ide_fecha_reg) {
        $this->ide_fecha_reg = $ide_fecha_reg;
    }

    function getIde_usu_mod() {
        return $this->ide_usu_mod;
    }

    function setIde_usu_mod($ide_usu_mod) {
        $this->ide_usu_mod = $ide_usu_mod;
    }

    function getIde_fecha_mod() {
        return $this->ide_fecha_mod;
    }

    function setIde_fecha_mod($ide_fecha_mod) {
        $this->ide_fecha_mod = $ide_fecha_mod;
    }

    function getIde_estado() {
        return $this->ide_estado;
    }

    function setIde_estado($ide_estado) {
        $this->ide_estado = $ide_estado;
    }

}

?>