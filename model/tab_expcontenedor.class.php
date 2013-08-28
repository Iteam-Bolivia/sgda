<?php

/**
 * tab_expcontenedor.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_expcontenedor extends db {

    var $exc_id;
    var $con_id;
    var $suc_id;
    var $exp_id;
    var $exc_fecha_reg;
    var $exc_usu_reg;
    var $exc_estado;

    function __construct() {
        parent::__construct();
    }

    function getExc_id() {
        return $this->exc_id;
    }

    function setExc_id($exc_id) {
        $this->exc_id = $exc_id;
    }

    function getCon_id() {
        return $this->con_id;
    }

    function setCon_id($con_id) {
        $this->con_id = $con_id;
    }
    
    function getSuc_id() {
        return $this->suc_id;
    }

    function setSuc_id($suc_id) {
        $this->suc_id = $suc_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getExc_fecha_reg() {
        return $this->exc_fecha_reg;
    }

    function setExc_fecha_reg($exc_fecha_reg) {
        $this->exc_fecha_reg = $exc_fecha_reg;
    }

    function getExc_usu_reg() {
        return $this->exc_usu_reg;
    }

    function setExc_usu_reg($exc_usu_reg) {
        $this->exc_usu_reg = $exc_usu_reg;
    }

    function getExc_estado() {
        return $this->exc_estado;
    }

    function setExc_estado($exc_estado) {
        $this->exc_estado = $exc_estado;
    }

}

?>