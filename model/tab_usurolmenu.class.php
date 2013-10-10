<?php

/**
 * tab_usurolmenu.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_usurolmenu extends db {

    var $urm_id;
    var $rol_id;
    var $men_id;
    var $urm_privilegios;
    var $urm_fecha_reg;
    var $urm_usu_reg;
    var $urm_fecha_mod;
    var $urm_usu_mod;
    var $urm_estadom;
    var $urm_estado;

    function __construct() {
        parent::__construct();
    }

    function getUrm_id() {
        return $this->urm_id;
    }

    function setUrm_id($urm_id) {
        $this->urm_id = $urm_id;
    }

    function getRol_id() {
        return $this->rol_id;
    }

    function setRol_id($rol_id) {
        $this->rol_id = $rol_id;
    }

    function getMen_id() {
        return $this->men_id;
    }

    function setMen_id($men_id) {
        $this->men_id = $men_id;
    }

    function getUrm_privilegios() {
        return $this->urm_privilegios;
    }

    function setUrm_privilegios($urm_privilegios) {
        $this->urm_privilegios = $urm_privilegios;
    }

    function getUrm_fecha_reg() {
        return $this->urm_fecha_reg;
    }

    function setUrm_fecha_reg($urm_fecha_reg) {
        $this->urm_fecha_reg = $urm_fecha_reg;
    }

    function getUrm_usu_reg() {
        return $this->urm_usu_reg;
    }

    function setUrm_usu_reg($urm_usu_reg) {
        $this->urm_usu_reg = $urm_usu_reg;
    }

    function getUrm_fecha_mod() {
        return $this->urm_fecha_mod;
    }

    function setUrm_fecha_mod($urm_fecha_mod) {
        $this->urm_fecha_mod = $urm_fecha_mod;
    }

    function getUrm_usu_mod() {
        return $this->urm_usu_mod;
    }

    function setUrm_usu_mod($urm_usu_mod) {
        $this->urm_usu_mod = $urm_usu_mod;
    }

    function getUrm_estadom() {
        return $this->urm_estadom;
    }

    function setUrm_estadom($urm_estadom) {
        $this->urm_estadom = $urm_estadom;
    }

    function getUrm_estado() {
        return $this->urm_estado;
    }

    function setUrm_estado($urm_estado) {
        $this->urm_estado = $urm_estado;
    }
    
}

?>
