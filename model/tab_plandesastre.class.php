<?php

/**
 * tab_plandesastre.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_plandesastre extends db {

    var $pla_id;
    var $dpr_id;
    var $pla_titulo;
    var $pla_gestion;
    var $pla_mes_inicial;
    var $pla_usu_reg;
    var $pla_usu_mod;
    var $pla_fecha_reg;
    var $pla_fecha_mod;
    var $pla_estado;

    function __construct() {
        parent::__construct();
    }

    function getPla_id() {
        return $this->pla_id;
    }

    function setPla_id($pla_id) {
        $this->pla_id = $pla_id;
    }

    function getDpr_id() {
        return $this->dpr_id;
    }

    function setDpr_id($dpr_id) {
        $this->dpr_id = $dpr_id;
    }

    function getPla_titulo() {
        return $this->pla_titulo;
    }

    function setPla_titulo($pla_titulo) {
        $this->pla_titulo = $pla_titulo;
    }

    function getPla_gestion() {
        return $this->pla_gestion;
    }

    function setPla_gestion($pla_gestion) {
        $this->pla_gestion = $pla_gestion;
    }

    function getPla_mes_inicial() {
        return $this->pla_mes_inicial;
    }

    function setPla_mes_inicial($pla_mes_inicial) {
        $this->pla_mes_inicial = $pla_mes_inicial;
    }

    function getPla_usu_reg() {
        return $this->pla_usu_reg;
    }

    function setPla_usu_reg($pla_usu_reg) {
        $this->pla_usu_reg = $pla_usu_reg;
    }

    function getPla_usu_mod() {
        return $this->pla_usu_mod;
    }

    function setPla_usu_mod($pla_usu_mod) {
        $this->pla_usu_mod = $pla_usu_mod;
    }

    function getPla_fecha_reg() {
        return $this->pla_fecha_reg;
    }

    function setPla_fecha_reg($pla_fecha_reg) {
        $this->pla_fecha_reg = $pla_fecha_reg;
    }

    function getPla_fecha_mod() {
        return $this->pla_fecha_mod;
    }

    function setPla_fecha_mod($pla_fecha_mod) {
        $this->pla_fecha_mod = $pla_fecha_mod;
    }

    function getPla_estado() {
        return $this->pla_estado;
    }

    function setPla_estado($pla_estado) {
        $this->pla_estado = $pla_estado;
    }

}

?>