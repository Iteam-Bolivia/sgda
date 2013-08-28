<?php

/**
 * tab_ubicacion.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_ubicacion extends db {

    var $ubi_id;
    var $ubi_par;
    var $ubi_codigo;
    var $ubi_descripcion;
    var $ubi_direccion;
    var $ubi_fecha_crea;
    var $ubi_fecha_mod;
    var $ubi_usuario_crea;
    var $ubi_usuario_mod;
    var $ubi_estado;
    var $loc_id;

    function __construct() {
        parent::__construct();
    }

    function getUbi_id() {
        return $this->ubi_id;
    }

    function setUbi_id($ubi_id) {
        $this->ubi_id = $ubi_id;
    }

    function getUbi_par() {
        return $this->ubi_par;
    }

    function setUbi_par($ubi_par) {
        $this->ubi_par = $ubi_par;
    }

    function getUbi_codigo() {
        return $this->ubi_codigo;
    }

    function setUbi_codigo($ubi_codigo) {
        $this->ubi_codigo = $ubi_codigo;
    }

    function getUbi_descripcion() {
        return $this->ubi_descripcion;
    }

    function setUbi_descripcion($ubi_descripcion) {
        $this->ubi_descripcion = $ubi_descripcion;
    }

    function getUbi_direccion() {
        return $this->ubi_direccion;
    }

    function setUbi_direccion($ubi_direccion) {
        $this->ubi_direccion = $ubi_direccion;
    }

    function getUbi_fecha_crea() {
        return $this->ubi_fecha_crea;
    }

    function setUbi_fecha_crea($ubi_fecha_crea) {
        $this->ubi_fecha_crea = $ubi_fecha_crea;
    }

    function getUbi_fecha_mod() {
        return $this->ubi_fecha_mod;
    }

    function setUbi_fecha_mod($ubi_fecha_mod) {
        $this->ubi_fecha_mod = $ubi_fecha_mod;
    }

    function getUbi_usuario_crea() {
        return $this->ubi_usuario_crea;
    }

    function setUbi_usuario_crea($ubi_usuario_crea) {
        $this->ubi_usuario_crea = $ubi_usuario_crea;
    }

    function getUbi_usuario_mod() {
        return $this->ubi_usuario_mod;
    }

    function setUbi_usuario_mod($ubi_usuario_mod) {
        $this->ubi_usuario_mod = $ubi_usuario_mod;
    }

    function getUbi_estado() {
        return $this->ubi_estado;
    }

    function setUbi_estado($ubi_estado) {
        $this->ubi_estado = $ubi_estado;
    }

    function getLoc_id() {
        return $this->loc_id;
    }

    function setLoc_id($loc_id) {
        $this->loc_id = $loc_id;
    }

}

?>