<?php

/**
 * tab_exparchivo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_exparchivo extends db {

    var $exa_id;
    var $fil_id;
    var $euv_id;
    var $exp_id;
    //var $ser_id;
    var $tra_id;
    var $cue_id;
    var $trc_id;
    var $uni_id;
    var $ver_id;
    var $exc_id;
    var $con_id;
    var $suc_id;
    var $usu_id;
    var $exa_condicion;
    var $exa_fecha_crea;
    var $exa_usuario_crea;
    var $exa_fecha_mod;
    var $exa_usuario_mod;
    var $exa_estado;

    function __construct() {
        parent::__construct();
    }

    function getExa_id() {
        return $this->exa_id;
    }

    function setExa_id($exa_id) {
        $this->exa_id = $exa_id;
    }

    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    function getEuv_id() {
        return $this->euv_id;
    }

    function setEuv_id($euv_id) {
        $this->euv_id = $euv_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

//    function getSer_id() {
//        return $this->ser_id;
//    }
//
//    function setSer_id($ser_id) {
//        $this->ser_id = $ser_id;
//    }

    function getTra_id() {
        return $this->tra_id;
    }

    function setTra_id($tra_id) {
        $this->tra_id = $tra_id;
    }

    function getCue_id() {
        return $this->cue_id;
    }

    function setCue_id($cue_id) {
        $this->cue_id = $cue_id;
    }

    function getTrc_id() {
        return $this->trc_id;
    }

    function setTrc_id($trc_id) {
        $this->trc_id = $trc_id;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getVer_id() {
        return $this->ver_id;
    }

    function setVer_id($ver_id) {
        $this->ver_id = $ver_id;
    }

    function getExc_id() {
        return $this->exc_id;
    }

    function setExc_id($exc_id) {
        $this->exc_id = $exc_id;
    }

    function getCon_id() {
        return $this->con_id;
    }

    function setCon_id($con_id) {
        $this->con_id = $con_id;
    }

    function getSuc_id() {
        return $this->suc_id;
    }

    function setSuc_id($suc_id) {
        $this->suc_id = $suc_id;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getExa_condicion() {
        return $this->exa_condicion;
    }

    function setExa_condicion($exa_condicion) {
        $this->exa_condicion = $exa_condicion;
    }

    function getExa_fecha_crea() {
        return $this->exa_fecha_crea;
    }

    function setExa_fecha_crea($exa_fecha_crea) {
        $this->exa_fecha_crea = $exa_fecha_crea;
    }

    function getExa_usuario_crea() {
        return $this->exa_usuario_crea;
    }

    function setExa_usuario_crea($exa_usuario_crea) {
        $this->exa_usuario_crea = $exa_usuario_crea;
    }

    function getExa_fecha_mod() {
        return $this->exa_fecha_mod;
    }

    function setExa_fecha_mod($exa_fecha_mod) {
        $this->exa_fecha_mod = $exa_fecha_mod;
    }

    function getExa_usuario_mod() {
        return $this->exa_usuario_mod;
    }

    function setExa_usuario_mod($exa_usuario_mod) {
        $this->exa_usuario_mod = $exa_usuario_mod;
    }

    function getExa_estado() {
        return $this->exa_estado;
    }

    function setExa_estado($exa_estado) {
        $this->exa_estado = $exa_estado;
    }

}

?>