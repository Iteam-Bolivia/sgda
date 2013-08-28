<?php

/**
 * tab_etiqexpediente.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_etiqexpediente extends db {

    var $ete_id;
    var $ete_procedencia;
    var $ete_direccion;
    var $ete_unidad;
    var $ete_serie;
    var $ete_titulo;
    var $ete_fecha_exi;
    var $ete_fecha_exf;
    var $ete_cod_ref;
    var $ete_nro;
    var $ete_contenedor;
    var $ete_fecha_reg;
    var $ete_usu_reg;
    var $ete_estado;

    function __construct() {
        parent::__construct();
    }

    function getEte_id() {
        return $this->ete_id;
    }

    function setEte_id($ete_id) {
        $this->ete_id = $ete_id;
    }

    function getEte_procedencia() {
        return $this->ete_procedencia;
    }

    function setEte_procedencia($ete_procedencia) {
        $this->ete_procedencia = $ete_procedencia;
    }

    function getEte_direccion() {
        return $this->ete_direccion;
    }

    function setEte_direccion($ete_direccion) {
        $this->ete_direccion = $ete_direccion;
    }

    function getEte_unidad() {
        return $this->ete_unidad;
    }

    function setEte_unidad($ete_unidad) {
        $this->ete_unidad = $ete_unidad;
    }

    function getEte_serie() {
        return $this->ete_serie;
    }

    function setEte_serie($ete_serie) {
        $this->ete_serie = $ete_serie;
    }

    function getEte_titulo() {
        return $this->ete_titulo;
    }

    function setEte_titulo($ete_titulo) {
        $this->ete_titulo = $ete_titulo;
    }

    function getEte_fecha_exi() {
        return $this->ete_fecha_exi;
    }

    function setEte_fecha_exi($ete_fecha_exi) {
        $this->ete_fecha_exi = $ete_fecha_exi;
    }

    function getEte_fecha_exf() {
        return $this->ete_fecha_exf;
    }

    function setEte_fecha_exf($ete_fecha_exf) {
        $this->ete_fecha_exf = $ete_fecha_exf;
    }

    function getEte_cod_ref() {
        return $this->ete_cod_ref;
    }

    function setEte_cod_ref($ete_cod_ref) {
        $this->ete_cod_ref = $ete_cod_ref;
    }

    function getEte_nro() {
        return $this->ete_nro;
    }

    function setEte_nro($ete_nro) {
        $this->ete_nro = $ete_nro;
    }

    function getEte_contenedor() {
        return $this->ete_contenedor;
    }

    function setEte_contenedor($ete_contenedor) {
        $this->ete_contenedor = $ete_contenedor;
    }

    function getEte_fecha_reg() {
        return $this->ete_fecha_reg;
    }

    function setEte_fecha_reg($ete_fecha_reg) {
        $this->ete_fecha_reg = $ete_fecha_reg;
    }

    function getEte_usu_reg() {
        return $this->ete_usu_reg;
    }

    function setEte_usu_reg($ete_usu_reg) {
        $this->ete_usu_reg = $ete_usu_reg;
    }

    function getEte_estado() {
        return $this->ete_estado;
    }

    function setEte_estado($ete_estado) {
        $this->ete_estado = $ete_estado;
    }

}

?>