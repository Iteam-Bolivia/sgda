<?php

/**
 * tab_exptransferencia.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2010
 * @access public
 */
class tab_exptransferencia extends db {

    var $etr_id;
    var $str_id;
    var $etr_orden;
    var $exp_id;
    var $etr_obs;
    var $etr_estado;

    function __construct() {
        parent::__construct();
    }

    function getEtr_id() {
        return $this->etr_id;
    }

    function setEtr_id($etr_id) {
        $this->etr_id = $etr_id;
    }

    function getStr_id() {
        return $this->str_id;
    }

    function setStr_id($str_id) {
        $this->str_id = $str_id;
    }

    function getEtr_orden() {
        return $this->etr_orden;
    }

    function setEtr_orden($etr_orden) {
        $this->etr_orden = $etr_orden;
    }    
    
    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getEtr_obs() {
        return $this->etr_obs;
    }

    function setEtr_obs($etr_obs) {
        $this->etr_obs = $etr_obs;
    }

    function getEtr_estado() {
        return $this->etr_estado;
    }

    function setEtr_estado($etr_estado) {
        $this->etr_estado = $etr_estado;
    }

}

?>