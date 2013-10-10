<?php

/**
 * tab_exp_prestamo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_exp_prestamo extends db {

    var $epr_id;
    var $spr_id;
    var $epr_orden;
    var $exp_id;
    var $epr_obs;
    var $epr_estado;

    function __construct() {
        parent::__construct();
    }

    function getEpr_id() {
        return $this->epr_id;
    }

    function setEpr_id($epr_id) {
        $this->epr_id = $epr_id;
    }

    function getSpr_id() {
        return $this->spr_id;
    }

    function setSpr_id($spr_id) {
        $this->spr_id = $spr_id;
    }

    function getEpr_orden() {
        return $this->epr_orden;
    }

    function setEpr_orden($epr_orden) {
        $this->epr_orden = $epr_orden;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getEpr_obs() {
        return $this->epr_obs;
    }

    function setEpr_obs($epr_obs) {
        $this->epr_obs = $epr_obs;
    }

    function getEpr_estado() {
        return $this->epr_estado;
    }

    function setEpr_estado($epr_estado) {
        $this->epr_estado = $epr_estado;
    }

}

?>