<?php

/**
 * tab_prestamos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_prestamos extends db {

    var $pre_id;
    var $exp_id;
    var $uni_id;
    var $exa_id;
    var $pre_sigla_of;
    var $pre_solicitante;
    var $pre_institucion;
    var $pre_doc_aval;
    var $pre_descripcion;
    var $pre_justificacion;
    var $pre_tipo;
    var $pre_fecha_pres;
    var $pre_fecha_dev;
    var $pre_usu_reg;
    var $pre_fecha_reg;
    var $pre_usu_mod;
    var $pre_fecha_mod;
    var $pre_estado;

    function __construct() {
        parent::__construct();
    }

    function getPre_id() {
        return $this->pre_id;
    }

    function setPre_id($pre_id) {
        $this->pre_id = $pre_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getExa_id() {
        return $this->exa_id;
    }

    function setExa_id($exa_id) {
        $this->exa_id = $exa_id;
    }

    function getPre_sigla_of() {
        return $this->pre_sigla_of;
    }

    function setPre_sigla_of($pre_sigla_of) {
        $this->pre_sigla_of = $pre_sigla_of;
    }

    function getPre_solicitante() {
        return $this->pre_solicitante;
    }

    function setPre_solicitante($pre_solicitante) {
        $this->pre_solicitante = $pre_solicitante;
    }

    function getPre_institucion() {
        return $this->pre_institucion;
    }

    function setPre_institucion($pre_institucion) {
        $this->pre_institucion = $pre_institucion;
    }

    function getPre_doc_aval() {
        return $this->pre_doc_aval;
    }

    function setPre_doc_aval($pre_doc_aval) {
        $this->pre_doc_aval = $pre_doc_aval;
    }

    function getPre_descripcion() {
        return $this->pre_descripcion;
    }

    function setPre_descripcion($pre_descripcion) {
        $this->pre_descripcion = $pre_descripcion;
    }

    function getPre_justificacion() {
        return $this->pre_justificacion;
    }

    function setPre_justificacion($pre_justificacion) {
        $this->pre_justificacion = $pre_justificacion;
    }

    function getPre_tipo() {
        return $this->pre_tipo;
    }

    function setPre_tipo($pre_tipo) {
        $this->pre_tipo = $pre_tipo;
    }

    function getPre_fecha_pres() {
        return $this->pre_fecha_pres;
    }

    function setPre_fecha_pres($pre_fecha_pres) {
        $this->pre_fecha_pres = $pre_fecha_pres;
    }

    function getPre_fecha_dev() {
        return $this->pre_fecha_dev;
    }

    function setPre_fecha_dev($pre_fecha_dev) {
        $this->pre_fecha_dev = $pre_fecha_dev;
    }

    function getPre_usu_reg() {
        return $this->pre_usu_reg;
    }

    function setPre_usu_reg($pre_usu_reg) {
        $this->pre_usu_reg = $pre_usu_reg;
    }

    function getPre_fecha_reg() {
        return $this->pre_fecha_reg;
    }

    function setPre_fecha_reg($pre_fecha_reg) {
        $this->pre_fecha_reg = $pre_fecha_reg;
    }

    function getPre_usu_mod() {
        return $this->pre_usu_mod;
    }

    function setPre_usu_mod($pre_usu_mod) {
        $this->pre_usu_mod = $pre_usu_mod;
    }

    function getPre_fecha_mod() {
        return $this->pre_fecha_mod;
    }

    function setPre_fecha_mod($pre_fecha_mod) {
        $this->pre_fecha_mod = $pre_fecha_mod;
    }

    function getPre_estado() {
        return $this->pre_estado;
    }

    function setPre_estado($pre_estado) {
        $this->pre_estado = $pre_estado;
    }

}

?>