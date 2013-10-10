<?php

/**
 * tab_contratos.class.php Class
 *
 * @package
 * @author Lic. Arsenio Castell�n
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class Tab_contratos extends db {

    var $ctt_id;
    var $ctt_codigo;
    var $ctt_detalle;
    var $ctt_descripcion;
    var $ctt_proveedor;
    var $ctt_gestion;
    var $ctt_cite;
    var $ctt_precbasrefunit;
    var $ctt_fecha;
    var $uni_id;
    var $sol_id;
    var $mod_id;
    var $ff_id;
    var $exp_id;
    var $ctt_fecha_crea;
    var $ctt_usuario_crea;
    var $ctt_fecha_mod;
    var $ctt_usuario_mod;
    var $ctt_estado;

    function __construct() {
        parent::__construct();
    }

    function getCtt_id() {
        return $this->ctt_id;
    }

    function setCtt_id($ctt_id) {
        $this->ctt_id = $ctt_id;
    }

    function getCtt_codigo() {
        return $this->ctt_codigo;
    }

    function setCtt_codigo($ctt_codigo) {
        $this->ctt_codigo = $ctt_codigo;
    }

    function getCtt_detalle() {
        return $this->ctt_detalle;
    }

    function setCtt_detalle($ctt_detalle) {
        $this->ctt_detalle = $ctt_detalle;
    }

    function getCtt_descripcion() {
        return $this->ctt_descripcion;
    }

    function setCtt_descripcion($ctt_descripcion) {
        $this->ctt_descripcion = $ctt_descripcion;
    }

    function getCtt_proveedor() {
        return $this->ctt_proveedor;
    }

    function setCtt_proveedor($ctt_proveedor) {
        $this->ctt_proveedor = $ctt_proveedor;
    }

    function getCtt_gestion() {
        return $this->ctt_gestion;
    }

    function setCtt_gestion($ctt_gestion) {
        $this->ctt_gestion = $ctt_gestion;
    }

    function getCtt_cite() {
        return $this->ctt_cite;
    }

    function setCtt_cite($ctt_cite) {
        $this->ctt_cite = $ctt_cite;
    }

    function getCtt_precbasrefunit() {
        return $this->ctt_precbasrefunit;
    }

    function setCtt_precbasrefunit($ctt_precbasrefunit) {
        $this->ctt_precbasrefunit = $ctt_precbasrefunit;
    }

    function getCtt_fecha() {
        return $this->ctt_fecha;
    }

    function setCtt_fecha($ctt_fecha) {
        $this->ctt_fecha = $ctt_fecha;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getSol_id() {
        return $this->sol_id;
    }

    function setSol_id($sol_id) {
        $this->sol_id = $sol_id;
    }

    function getMod_id() {
        return $this->mod_id;
    }

    function setMod_id($mod_id) {
        $this->mod_id = $mod_id;
    }

    function getFF_id() {
        return $this->ff_id;
    }

    function setFF_id($ff_id) {
        $this->ff_id = $ff_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getCtt_fecha_crea() {
        return $this->ctt_fecha_crea;
    }

    function setCtt_fecha_crea($ctt_fecha_crea) {
        $this->ctt_fecha_crea = $ctt_fecha_crea;
    }

    function getCtt_usuario_crea() {
        return $this->ctt_usuario_crea;
    }

    function setCtt_usuario_crea($ctt_usuario_crea) {
        $this->ctt_usuario_crea = $ctt_usuario_crea;
    }

    function getCtt_fecha_mod() {
        return $this->ctt_fecha_mod;
    }

    function setCtt_fecha_mod($ctt_fecha_mod) {
        $this->ctt_fecha_mod = $ctt_fecha_mod;
    }

    function getCtt_usuario_mod() {
        return $this->ctt_usuario_mod;
    }

    function setCtt_usuario_mod($ctt_usuario_mod) {
        $this->ctt_usuario_mod = $ctt_usuario_mod;
    }

    function getCtt_estado() {
        return $this->ctt_estado;
    }

    function setCtt_estado($ctt_estado) {
        $this->ctt_estado = $ctt_estado;
    }

}

?>