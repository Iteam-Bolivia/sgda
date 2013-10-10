<?php

/**
 * tab_usuario.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_usuario extends db {

    var $usu_id;
    var $uni_id;
    var $usu_nombres;
    var $usu_apellidos;
    var $usu_iniciales;
    var $usu_fono;
    var $usu_email;
    var $usu_nro_item;
    var $usu_fech_ing;
    var $usu_fech_fin;
    var $usu_login;
    var $usu_pass;
    var $usu_leer_doc;
    var $usu_pass_leer;
    var $usu_pass_fecha;
    var $usu_pass_dias;
    var $usu_crear_doc;
    var $usu_fecha_crea;
    var $usu_fecha_mod;
    var $usu_crea;
    var $usu_mod;
    var $usu_estado;
    var $rol_id;
    var $usu_verproy;

    function __construct() {
        parent::__construct();
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getRol_id() {
        return $this->rol_id;
    }

    function setRol_id($rol_id) {
        $this->rol_id = $rol_id;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getUsu_nombres() {
        return $this->usu_nombres;
    }

    function setUsu_nombres($usu_nombres) {
        $this->usu_nombres = $usu_nombres;
    }

    function getUsu_apellidos() {
        return $this->usu_apellidos;
    }

    function setUsu_apellidos($usu_apellidos) {
        $this->usu_apellidos = $usu_apellidos;
    }

    function getUsu_iniciales() {
        return $this->usu_iniciales;
    }

    function setUsu_iniciales($usu_iniciales) {
        $this->usu_iniciales = $usu_iniciales;
    }

    function getUsu_fono() {
        return $this->usu_fono;
    }

    function setUsu_fono($usu_fono) {
        $this->usu_fono = $usu_fono;
    }

    function getUsu_email() {
        return $this->usu_email;
    }

    function setUsu_email($usu_email) {
        $this->usu_email = $usu_email;
    }

    function getUsu_nro_item() {
        return $this->usu_nro_item;
    }

    function setUsu_nro_item($usu_nro_item) {
        $this->usu_nro_item = $usu_nro_item;
    }

    function getUsu_fech_ing() {
        return $this->usu_fech_ing;
    }

    function setUsu_fech_ing($usu_fech_ing) {
        $this->usu_fech_ing = $usu_fech_ing;
    }

    function getUsu_fech_fin() {
        return $this->usu_fech_fin;
    }

    function setUsu_fech_fin($usu_fech_fin) {
        $this->usu_fech_fin = $usu_fech_fin;
    }

    function getUsu_login() {
        return $this->usu_login;
    }

    function setUsu_login($usu_login) {
        $this->usu_login = $usu_login;
    }

    function getUsu_pass() {
        return $this->usu_pass;
    }

    function setUsu_pass($usu_pass) {
        $this->usu_pass = $usu_pass;
    }

    function getUsu_leer_doc() {
        return $this->usu_leer_doc;
    }

    function setUsu_leer_doc($usu_leer_doc) {
        $this->usu_leer_doc = $usu_leer_doc;
    }

    function getUsu_pass_leer() {
        return $this->usu_pass_leer;
    }

    function setUsu_pass_leer($usu_pass_leer) {
        $this->usu_pass_leer = $usu_pass_leer;
    }

    function getUsu_pass_fecha() {
        return $this->usu_pass_fecha;
    }

    function setUsu_pass_fecha($usu_pass_fecha) {
        $this->usu_pass_fecha = $usu_pass_fecha;
    }

    function getUsu_pass_dias() {
        return $this->usu_pass_dias;
    }

    function setUsu_pass_dias($usu_pass_dias) {
        $this->usu_pass_dias = $usu_pass_dias;
    }

    function getUsu_crear_doc() {
        return $this->usu_crear_doc;
    }

    function setUsu_crear_doc($usu_crear_doc) {
        $this->usu_crear_doc = $usu_crear_doc;
    }

    function getUsu_fecha_crea() {
        return $this->usu_fecha_crea;
    }

    function setUsu_fecha_crea($usu_fecha_crea) {
        $this->usu_fecha_crea = $usu_fecha_crea;
    }

    function getUsu_fecha_mod() {
        return $this->usu_fecha_mod;
    }

    function setUsu_fecha_mod($usu_fecha_mod) {
        $this->usu_fecha_mod = $usu_fecha_mod;
    }

    function getUsu_crea() {
        return $this->usu_crea;
    }

    function setUsu_crea($usu_crea) {
        $this->usu_crea = $usu_crea;
    }

    function getUsu_mod() {
        return $this->usu_mod;
    }

    function setUsu_mod($usu_mod) {
        $this->usu_mod = $usu_mod;
    }

    function getUsu_estado() {
        return $this->usu_estado;
    }

    function setUsu_estado($usu_estado) {
        $this->usu_estado = $usu_estado;
    }
    
    function getUsu_verproy() {
        return $this->usu_verproy;
    }
    function setUsu_verproy($usu_verproy) {
        $this->usu_verproy = $usu_verproy;
    }

}

?>