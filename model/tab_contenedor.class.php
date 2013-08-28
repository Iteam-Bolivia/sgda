<?php

/**
 * tab_contenedor.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_contenedor extends db {

    var $con_id;
    var $ctp_id;
    var $con_codigo;
    var $con_codbs;
    var $con_usu_reg;
    var $con_fecha_reg;
    var $con_usu_mod;
    var $con_fecha_mod;
    var $con_estado;
    var $usu_id;

    function __construct() {
        parent::__construct();
    }

    function getCon_id() {
        return $this->con_id;
    }

    function setCon_id($con_id) {
        $this->con_id = $con_id;
    }

    function getCtp_id() {
        return $this->ctp_id;
    }

    function setCtp_id($ctp_id) {
        $this->ctp_id = $ctp_id;
    }

    function getCon_codigo() {
        return $this->con_codigo;
    }

    function setCon_codigo($con_codigo) {
        $this->con_codigo = $con_codigo;
    }

    function getCon_usu_reg() {
        return $this->con_usu_reg;
    }

    function setCon_usu_reg($con_usu_reg) {
        $this->con_usu_reg = $con_usu_reg;
    }

    function getCon_fecha_reg() {
        return $this->con_fecha_reg;
    }

    function setCon_fecha_reg($con_fecha_reg) {
        $this->con_fecha_reg = $con_fecha_reg;
    }

    function getCon_usu_mod() {
        return $this->con_usu_mod;
    }

    function setCon_usu_mod($con_usu_mod) {
        $this->con_usu_mod = $con_usu_mod;
    }

    function getCon_fecha_mod() {
        return $this->con_fecha_mod;
    }

    function setCon_fecha_mod($con_fecha_mod) {
        $this->con_fecha_mod = $con_fecha_mod;
    }

    function getCon_estado() {
        return $this->con_estado;
    }

    function setCon_estado($con_estado) {
        $this->con_estado = $con_estado;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getCon_codbs() {
        return $this->con_codbs;
    }

    function setCon_codbs($con_codbs) {
        $this->con_codbs = $con_codbs;
    }
}

?>