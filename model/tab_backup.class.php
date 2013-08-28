<?php

/**
 * tab_backup.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_backup extends db {

    var $bac_id;
    var $bac_accion;
    var $bac_file;
    var $bac_size;
    var $bac_fecha_crea;
    var $bac_usuario;
    var $bac_estado;

    function __construct() {
        parent::__construct();
    }

    function getBac_id() {
        return $this->bac_id;
    }

    function setBac_id($bac_id) {
        $this->bac_id = $bac_id;
    }

    function getBac_accion() {
        return $this->bac_accion;
    }

    function setBac_accion($bac_accion) {
        $this->bac_accion = $bac_accion;
    }

    function getBac_file() {
        return $this->bac_file;
    }

    function setBac_file($bac_file) {
        $this->bac_file = $bac_file;
    }

    function getBac_size() {
        return $this->bac_size;
    }

    function setBac_size($bac_size) {
        $this->bac_size = $bac_size;
    }

    function getBac_fecha_crea() {
        return $this->bac_fecha_crea;
    }

    function setBac_fecha_crea($bac_fecha_crea) {
        $this->bac_fecha_crea = $bac_fecha_crea;
    }

    function getBac_usuario() {
        return $this->bac_usuario;
    }

    function setBac_usuario($bac_usuario) {
        $this->bac_usuario = $bac_usuario;
    }

    function getBac_estado() {
        return $this->bac_estado;
    }

    function setBac_estado($bac_estado) {
        $this->bac_estado = $bac_estado;
    }

}

?>