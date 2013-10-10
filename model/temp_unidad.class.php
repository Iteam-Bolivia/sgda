<?php

/**
 * tab_unidad.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Temp_unidad extends db {

    var $temp_uni_id;
    var $uni_id;
    var $niv_id;
    var $ver_id;
    var $ubi_id;
    var $uni_piso;
    var $uni_par;
    var $uni_codigo;
    var $uni_descripcion;
    var $uni_fecha_crea;
    var $uni_fecha_mod;
    var $uni_usuario_crea;
    var $uni_usuario_mod;
    var $uni_estado;
    var $ins_id;

    function __construct() {
        parent::__construct();
    }

    function getTemp_uni_id() {
        return $this->temp_uni_id;
    }

    function setTemp_uni_id($temp_uni_id) {
        $this->temp_uni_id = $temp_uni_id;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getNiv_id() {
        return $this->niv_id;
    }

    function setNiv_id($niv_id) {
        $this->niv_id = $niv_id;
    }

    function getVer_id() {
        return $this->ver_id;
    }

    function setVer_id($ver_id) {
        $this->ver_id = $ver_id;
    }

    function getUbi_id() {
        return $this->ubi_id;
    }

    function setUbi_id($ubi_id) {
        $this->ubi_id = $ubi_id;
    }

    function getUni_piso() {
        return $this->uni_piso;
    }

    function setUni_piso($uni_piso) {
        $this->uni_piso = $uni_piso;
    }

    function getUni_par() {
        return $this->uni_par;
    }

    function setUni_par($uni_par) {
        $this->uni_par = $uni_par;
    }

    function getUni_codigo() {
        return $this->uni_codigo;
    }

    function setUni_codigo($uni_codigo) {
        $this->uni_codigo = $uni_codigo;
    }

    function getUni_descripcion() {
        return $this->uni_descripcion;
    }

    function setUni_descripcion($uni_descripcion) {
        $this->uni_descripcion = $uni_descripcion;
    }

    function getUni_fecha_crea() {
        return $this->uni_fecha_crea;
    }

    function setUni_fecha_crea($uni_fecha_crea) {
        $this->uni_fecha_crea = $uni_fecha_crea;
    }

    function getUni_fecha_mod() {
        return $this->uni_fecha_mod;
    }

    function setUni_fecha_mod($uni_fecha_mod) {
        $this->uni_fecha_mod = $uni_fecha_mod;
    }

    function getUni_usuario_crea() {
        return $this->uni_usuario_crea;
    }

    function setUni_usuario_crea($uni_usuario_crea) {
        $this->uni_usuario_crea = $uni_usuario_crea;
    }

    function getUni_usuario_mod() {
        return $this->uni_usuario_mod;
    }

    function setUni_usuario_mod($uni_usuario_mod) {
        $this->uni_usuario_mod = $uni_usuario_mod;
    }

    function getUni_estado() {
        return $this->uni_estado;
    }

    function setUni_estado($uni_estado) {
        $this->uni_estado = $uni_estado;
    }

    function getIns_id() {
        return $this->ins_id;
    }

    function setIns_id($ins_id) {
        $this->ins_id = $ins_id;
    }

}

?>