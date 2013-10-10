<?php

/**
 * tab_menu.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_menu extends db {

    var $men_id;
    var $men_par;
    var $men_titulo;
    var $men_enlace;
    var $men_posicion;
    var $men_fecha_reg;
    var $men_usu_reg;
    var $men_fecha_mod;
    var $men_usu_mod;
    var $men_estado;

    function __construct() {
        parent::__construct();
    }

    function getMen_id() {
        return $this->men_id;
    }

    function setMen_id($men_id) {
        $this->men_id = $men_id;
    }

    function getMen_par() {
        return $this->men_par;
    }

    function setMen_par($men_par) {
        $this->men_par = $men_par;
    }

    function getMen_titulo() {
        return $this->men_titulo;
    }

    function setMen_titulo($men_titulo) {
        $this->men_titulo = $men_titulo;
    }

    function getMen_enlace() {
        return $this->men_enlace;
    }

    function setMen_enlace($men_enlace) {
        $this->men_enlace = $men_enlace;
    }

    function getMen_posicion() {
        return $this->men_posicion;
    }

    function setMen_posicion($men_posicion) {
        $this->men_posicion = $men_posicion;
    }

    function getMen_fecha_reg() {
        return $this->men_fecha_reg;
    }

    function setMen_fecha_reg($men_fecha_reg) {
        $this->men_fecha_reg = $men_fecha_reg;
    }

    function getMen_usu_reg() {
        return $this->men_usu_reg;
    }

    function setMen_usu_reg($men_usu_reg) {
        $this->men_usu_reg = $men_usu_reg;
    }

    function getMen_fecha_mod() {
        return $this->men_fecha_mod;
    }

    function setMen_fecha_mod($men_fecha_mod) {
        $this->men_fecha_mod = $men_fecha_mod;
    }

    function getMen_usu_mod() {
        return $this->men_usu_mod;
    }

    function setMen_usu_mod($men_usu_mod) {
        $this->men_usu_mod = $men_usu_mod;
    }

    function getMen_estado() {
        return $this->men_estado;
    }

    function setMen_estado($men_estado) {
        $this->men_estado = $men_estado;
    }

}

?>