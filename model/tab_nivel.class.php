<?php

/**
 * tab_nivel.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_nivel extends db {

    var $niv_id;
    var $niv_codigo;
    var $niv_descripcion;
    var $niv_par;
    var $niv_abrev;
    var $niv_usu_crea;
    var $niv_fecha_crea;
    var $niv_usu_mod;
    var $niv_fecha_mod;
    var $niv_estado;
    

    function __construct() {
        parent::__construct();
    }

    function getNiv_id() {
        return $this->niv_id;
    }

    function setNiv_id($niv_id) {
        $this->niv_id = $niv_id;
    }

    function getNiv_codigo() {
        return $this->niv_codigo;
    }

    function setNiv_codigo($niv_codigo) {
        $this->niv_codigo = $niv_codigo;
    }

    function getNiv_descripcion() {
        return $this->niv_descripcion;
    }

    function setNiv_descripcion($niv_descripcion) {
        $this->niv_descripcion = $niv_descripcion;
    }

    function getNiv_par() {
        return $this->niv_par;
    }

    function setNiv_par($niv_par) {
        $this->niv_par = $niv_par;
    }

    function getNiv_abrev() {
        return $this->niv_abrev;
    }

    function setNiv_abrev($niv_abrev) {
        $this->niv_abrev = $niv_abrev;
    }
    
    
    function getNiv_usu_crea() {
        return $this->niv_usu_crea;
    }

    function setNiv_usu_crea($niv_usu_crea) {
        $this->niv_usu_crea = $niv_usu_crea;
    }

    function getNiv_fecha_crea() {
        return $this->niv_fecha_crea;
    }

    function setNiv_fecha_crea($niv_fecha_crea) {
        $this->niv_fecha_crea = $niv_fecha_crea;
    }

    function getNiv_usu_mod() {
        return $this->niv_usu_mod;
    }

    function setNiv_usu_mod($niv_usu_mod) {
        $this->niv_usu_mod = $niv_usu_mod;
    }

    function getNiv_fecha_mod() {
        return $this->niv_fecha_mod;
    }

    function setNiv_fecha_mod($niv_fecha_mod) {
        $this->niv_fecha_mod = $niv_fecha_mod;
    }

    function getNiv_estado() {
        return $this->niv_estado;
    }

    function setNiv_estado($niv_estado) {
        $this->niv_estado = $niv_estado;
    }


}

?>