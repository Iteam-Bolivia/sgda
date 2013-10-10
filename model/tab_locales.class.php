<?php

/**
 * tab_locales.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_locales extends db {

    var $loc_id;
    var $loc_descripcion;
    var $loc_usu_reg;
    var $loc_usu_mod;
    var $loc_fecha_reg;
    var $loc_fecha_mod;
    var $loc_estado;

    function __construct() {
        parent::__construct();
    }

    function getLoc_id() {
        return $this->loc_id;
    }

    function setLoc_id($loc_id) {
        $this->loc_id = $loc_id;
    }

    function getLoc_descripcion() {
        return $this->loc_descripcion;
    }

    function setLoc_descripcion($loc_descripcion) {
        $this->loc_descripcion = $loc_descripcion;
    }

    function getLoc_usu_reg() {
        return $this->loc_usu_reg;
    }

    function setLoc_usu_reg($loc_usu_reg) {
        $this->loc_usu_reg = $loc_usu_reg;
    }

    function getLoc_usu_mod() {
        return $this->loc_usu_mod;
    }

    function setLoc_usu_mod($loc_usu_mod) {
        $this->loc_usu_mod = $loc_usu_mod;
    }

    function getLoc_fecha_reg() {
        return $this->loc_fecha_reg;
    }

    function setLoc_fecha_reg($loc_fecha_reg) {
        $this->loc_fecha_reg = $loc_fecha_reg;
    }

    function getLoc_fecha_mod() {
        return $this->loc_fecha_mod;
    }

    function setLoc_fecha_mod($loc_fecha_mod) {
        $this->loc_fecha_mod = $loc_fecha_mod;
    }

    function getLoc_estado() {
        return $this->loc_estado;
    }

    function setLoc_estado($loc_estado) {
        $this->loc_estado = $loc_estado;
    }

}

?>