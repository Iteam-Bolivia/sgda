<?php

/**
 * tab_transferencia.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_transferencia extends db {

    var $trn_id;
    var $exp_id;
    var $trn_descripcion;
    var $trn_contenido;
    var $trn_uni_origen;
    var $trn_uni_destino;
    var $trn_confirmado;
    var $trn_fecha_crea;
    var $trn_usuario_crea;
    var $trn_usuario_des;
    var $trn_usuario_orig;
    var $trn_estado;
    
    var $tfc_id;

    function __construct() {
        parent::__construct();
    }

    function getTrn_id() {
        return $this->trn_id;
    }

    function setTrn_id($trn_id) {
        $this->trn_id = $trn_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getTrn_descripcion() {
        return $this->trn_descripcion;
    }

    function setTrn_descripcion($trn_descripcion) {
        $this->trn_descripcion = $trn_descripcion;
    }

    function getTrn_contenido() {
        return $this->trn_contenido;
    }

    function setTrn_contenido($trn_contenido) {
        $this->trn_contenido = $trn_contenido;
    }

    function getTrn_uni_origen() {
        return $this->trn_uni_origen;
    }

    function setTrn_uni_origen($trn_uni_origen) {
        $this->trn_uni_origen = $trn_uni_origen;
    }

    function getTrn_uni_destino() {
        return $this->trn_uni_destino;
    }

    function setTrn_uni_destino($trn_uni_destino) {
        $this->trn_uni_destino = $trn_uni_destino;
    }

    function getTrn_confirmado() {
        return $this->trn_confirmado;
    }

    function setTrn_confirmado($trn_confirmado) {
        $this->trn_confirmado = $trn_confirmado;
    }

    function getTrn_fecha_crea() {
        return $this->trn_fecha_crea;
    }

    function setTrn_fecha_crea($trn_fecha_crea) {
        $this->trn_fecha_crea = $trn_fecha_crea;
    }

    function getTrn_usuario_crea() {
        return $this->trn_usuario_crea;
    }

    function setTrn_usuario_crea($trn_usuario_crea) {
        $this->trn_usuario_crea = $trn_usuario_crea;
    }

    function getTrn_usuario_orig() {
        return $this->trn_usuario_orig;
    }

    function setTrn_usuario_orig($trn_usuario_orig) {
        $this->trn_usuario_orig = $trn_usuario_orig;
    }

    function getTrn_usuario_des() {
        return $this->trn_usuario_des;
    }

    function setTrn_usuario_des($trn_usuario_des) {
        $this->trn_usuario_des = $trn_usuario_des;
    }

    function getTrn_estado() {
        return $this->trn_estado;
    }

    function setTrn_estado($trn_estado) {
        $this->trn_estado = $trn_estado;
    }
    
    function getTfc_id() {
        return $this->tfc_id;
    }
    function setTfc_id($tfc_id) {
        $this->tfc_id = $tfc_id;
    }

}

?>