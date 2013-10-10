<?php

/**
 * tab_tiposolicitud.class.php Class
 *
 * @package
 * @author Lic. Arsenio Castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class Tab_tiposolicitud extends db {

    var $sol_id;
    var $sol_codigo;
    var $sol_descripcion;
    var $sol_fecha_crea;
    var $sol_usuario_crea;
    var $sol_fecha_mod;
    var $sol_usuario_mod;
    var $sol_estado;

    function __construct() {
        parent::__construct();
    }

    function getSol_id() {
        return $this->sol_id;
    }

    function setSol_id($sol_id) {
        $this->sol_id = $sol_id;
    }

    function getSol_codigo() {
        return $this->sol_codigo;
    }

    function setSol_codigo($sol_codigo) {
        $this->sol_codigo = $sol_codigo;
    }

    function getSol_descripcion() {
        return $this->sol_descripcion;
    }

    function setSol_descripcion($sol_descripcion) {
        $this->sol_descripcion = $sol_descripcion;
    }

    function getSol_fecha_crea() {
        return $this->sol_fecha_crea;
    }

    function setSol_fecha_crea($sol_fecha_crea) {
        $this->sol_fecha_crea = $sol_fecha_crea;
    }

    function getSol_usuario_crea() {
        return $this->sol_usuario_crea;
    }

    function setSol_usuario_crea($sol_usuario_crea) {
        $this->sol_usuario_crea = $sol_usuario_crea;
    }

    function getSol_fecha_mod() {
        return $this->sol_fecha_mod;
    }

    function setSol_fecha_mod($sol_fecha_mod) {
        $this->sol_fecha_mod = $sol_fecha_mod;
    }

    function getSol_usuario_mod() {
        return $this->sol_usario_mod;
    }

    function setSol_usuario_mod($sol_usuario_mod) {
        $this->sol_usuario_mod = $sol_usuario_mod;
    }

    function getSol_estado() {
        return $this->sol_estado;
    }

    function setSol_estado($sol_estado) {
        $this->sol_estado = $sol_estado;
    }

}

?>