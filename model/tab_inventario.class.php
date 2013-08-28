<?php

/**
 * tab_inventario.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_inventario extends db {

    var $inv_id;
    var $exp_id;
    var $inv_orden;
    var $inv_unidad;
    var $inv_pieza;
    var $inv_ml;
    var $inv_titulo;
    var $inv_tomo;
    var $inv_nom_productor;
    var $inv_caract_fisica;
    var $inv_obs;
    var $inv_condicion_papel;
    var $inv_nitidez_escritura;
    var $inv_analisis_causa;
    var $inv_accion_curativa;
    var $usu_id;
    var $uni_id;
    var $inv_fecha_reg;
    var $inv_fecha_mod;
    var $inv_usu_mod;
    var $inv_usu_reg;
    var $inv_anio;
    var $inv_estado;

    function __construct() {
        parent::__construct();
    }

    function getInv_id() {
        return $this->inv_id;
    }

    function setInv_id($inv_id) {
        $this->inv_id = $inv_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getInv_orden() {
        return $this->inv_orden;
    }

    function setInv_orden($inv_orden) {
        $this->inv_orden = $inv_orden;
    }

    function getInv_unidad() {
        return $this->inv_unidad;
    }

    function setInv_unidad($inv_unidad) {
        $this->inv_unidad = $inv_unidad;
    }

    function getInv_pieza() {
        return $this->inv_pieza;
    }

    function setInv_pieza($inv_pieza) {
        $this->inv_pieza = $inv_pieza;
    }

    function getInv_ml() {
        return $this->inv_ml;
    }

    function setInv_ml($inv_ml) {
        $this->inv_ml = $inv_ml;
    }

    function getInv_titulo() {
        return $this->inv_titulo;
    }

    function setInv_titulo($inv_titulo) {
        $this->inv_titulo = $inv_titulo;
    }

    function getInv_tomo() {
        return $this->inv_tomo;
    }

    function setInv_tomo($inv_tomo) {
        $this->inv_tomo = $inv_tomo;
    }

    function getInv_nom_productor() {
        return $this->inv_nom_productor;
    }

    function setInv_nom_productor($inv_nom_productor) {
        $this->inv_nom_productor = $inv_nom_productor;
    }

    function getInv_caract_fisica() {
        return $this->inv_caract_fisica;
    }

    function setInv_caract_fisica($inv_caract_fisica) {
        $this->inv_caract_fisica = $inv_caract_fisica;
    }

    function getInv_obs() {
        return $this->inv_obs;
    }

    function setInv_obs($inv_obs) {
        $this->inv_obs = $inv_obs;
    }

    function getInv_condicion_papel() {
        return $this->inv_condicion_papel;
    }

    function setInv_condicion_papel($inv_condicion_papel) {
        $this->inv_condicion_papel = $inv_condicion_papel;
    }

    function getInv_nitidez_escritura() {
        return $this->inv_nitidez_escritura;
    }

    function setInv_nitidez_escritura($inv_nitidez_escritura) {
        $this->inv_nitidez_escritura = $inv_nitidez_escritura;
    }

    function getInv_analisis_causa() {
        return $this->inv_analisis_causa;
    }

    function setInv_analisis_causa($inv_analisis_causa) {
        $this->inv_analisis_causa = $inv_analisis_causa;
    }

    function getInv_accion_curativa() {
        return $this->inv_accion_curativa;
    }

    function setInv_accion_curativa($inv_accion_curativa) {
        $this->inv_accion_curativa = $inv_accion_curativa;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getInv_fecha_reg() {
        return $this->inv_fecha_reg;
    }

    function setInv_fecha_reg($inv_fecha_reg) {
        $this->inv_fecha_reg = $inv_fecha_reg;
    }

    function getInv_fecha_mod() {
        return $this->inv_fecha_mod;
    }

    function setInv_fecha_mod($inv_fecha_mod) {
        $this->inv_fecha_mod = $inv_fecha_mod;
    }

    function getInv_usu_mod() {
        return $this->inv_usu_mod;
    }

    function setInv_usu_mod($inv_usu_mod) {
        $this->inv_usu_mod = $inv_usu_mod;
    }

    function getInv_usu_reg() {
        return $this->inv_usu_reg;
    }

    function setInv_usu_reg($inv_usu_reg) {
        $this->inv_usu_reg = $inv_usu_reg;
    }

    function getInv_anio() {
        return $this->inv_anio;
    }

    function setInv_anio($inv_anio) {
        $this->inv_anio = $inv_anio;
    }

    function getInv_estado() {
        return $this->inv_estado;
    }

    function setInv_estado($inv_estado) {
        $this->inv_estado = $inv_estado;
    }

}

?>