<?php

/**
 * tab_contenedor.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_tipocontenedor extends db {

    var $ctp_id;
    var $ctp_codigo;
    var $ctp_descripcion;
    var $ctp_nivel;
    var $ctp_fecha_crea;
    var $ctp_fecha_mod;
    var $ctp_usu_crea;
    var $ctp_usu_mod;
    var $ctp_estado;

    function __construct() {
        parent::__construct();
    }

    function getCtp_id() {
        return $this->ctp_id;
    }

    function setCtp_id($ctp_id) {
        $this->ctp_id = $ctp_id;
    }

    function getCtp_codigo() {
        return $this->ctp_codigo;
    }

    function setCtp_codigo($ctp_codigo) {
        $this->ctp_codigo = $ctp_codigo;
    }

    function getCtp_descripcion() {
        return $this->ctp_descripcion;
    }

    function setCtp_descripcion($ctp_descripcion) {
        $this->ctp_descripcion = $ctp_descripcion;
    }

    function getCtp_nivel() {
        return $this->ctp_nivel;
    }

    function setCtp_nivel($ctp_nivel) {
        $this->ctp_nivel = $ctp_nivel;
    }

    function getCtp_fecha_crea() {
        return $this->ctp_fecha_crea;
    }

    function setCtp_fecha_crea($ctp_fecha_crea) {
        $this->ctp_fecha_crea = $ctp_fecha_crea;
    }

    function getCtp_fecha_mod() {
        return $this->ctp_fecha_mod;
    }

    function setCtp_fecha_mod($ctp_fecha_mod) {
        $this->ctp_fecha_mod = $ctp_fecha_mod;
    }

    function getCtp_usu_crea() {
        return $this->ctp_usu_crea;
    }

    function setCtp_usu_crea($ctp_usu_crea) {
        $this->ctp_usu_crea = $ctp_usu_crea;
    }

    function getCtp_usu_mod() {
        return $this->ctp_usu_mod;
    }

    function setCtp_usu_mod($ctp_usu_mod) {
        $this->ctp_usu_mod = $ctp_usu_mod;
    }

    function getCtp_estado() {
        return $this->ctp_estado;
    }

    function setCtp_estado($ctp_estado) {
        $this->ctp_estado = $ctp_estado;
    }

}

?>