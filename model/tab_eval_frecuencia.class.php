<?php

/**
 * tab_evalriesgos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_eval_frecuencia extends db {

    var $evf_id;
    var $fre_id;
    var $evf_usu_reg;
    var $evf_fecha_reg;
    var $evf_usu_mod;
    var $evf_fecha_mod;
    var $evf_estado;

    function __construct() {
        parent::__construct();
    }

    function getEvf_id() {
        return $this->evf_id;
    }

    function setEvf_id($evf_id) {
        $this->evf_id = $evf_id;
    }

    function getFre_id() {
        return $this->fre_id;
    }

    function setFre_id($fre_id) {
        $this->fre_id = $fre_id;
    }

    function getEvf_usu_reg() {
        return $this->evf_usu_reg;
    }

    function setEvf_usu_reg($evf_usu_reg) {
        $this->evf_usu_reg = $evf_usu_reg;
    }

    function getEvf_fecha_reg() {
        return $this->evf_fecha_reg;
    }

    function setEvf_fecha_reg($evf_fecha_reg) {
        $this->evf_fecha_reg = $evf_fecha_reg;
    }

    function getEvf_usu_mod() {
        return $this->evf_usu_mod;
    }

    function setEvf_usu_mod($evf_usu_mod) {
        $this->evf_usu_mod = $evf_usu_mod;
    }

    function getEvf_fecha_mod() {
        return $this->evf_fecha_mod;
    }

    function setEvf_fecha_mod($evf_fecha_mod) {
        $this->evf_fecha_mod = $evf_fecha_mod;
    }

    function getEvf_estado() {
        return $this->evf_estado;
    }

    function setEvf_estado($evf_estado) {
        $this->evf_estado = $evf_estado;
    }

}

?>