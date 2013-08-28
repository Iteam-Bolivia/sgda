<?php

/**
 * tab_expproyecto.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_expproyecto extends db {

    var $epp_id;
    var $exp_id;
    var $pry_id;
    var $epp_estado;

    function __construct() {
        parent::__construct();
    }

    function getEpp_id() {
        return $this->epp_id;
    }

    function setEpp_id($epp_id) {
        $this->epp_id = $epp_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getPry_id() {
        return $this->pry_id;
    }

    function setPry_id($pry_id) {
        $this->pry_id = $pry_id;
    }

    function getEpp_estado() {
        return $this->epp_estado;
    }

    function setEpp_estado($epp_estado) {
        $this->epp_estado = $epp_estado;
    }

}

?>