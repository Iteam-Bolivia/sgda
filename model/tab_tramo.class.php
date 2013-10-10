<?php

/**
 * tab_trmmo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_tramo extends db {

    var $trm_id;
    var $pry_id;
    var $trm_codigo;
    var $trm_nombre;
    var $trm_estado;

    function __construct() {
        parent::__construct();
    }

    function getTrm_id() {
        return $this->trm_id;
    }

    function setTrm_id($trm_id) {
        $this->trm_id = $trm_id;
    }

    function getPry_id() {
        return $this->pry_id;
    }

    function setPry_id($pry_id) {
        $this->pry_id = $pry_id;
    }

    function getTrm_codigo() {
        return $this->trm_codigo;
    }

    function setTrm_codigo($trm_codigo) {
        $this->trm_codigo = $trm_codigo;
    }

    function getTrm_nombre() {
        return $this->trm_nombre;
    }

    function setTrm_nombre($trm_nombre) {
        $this->trm_nombre = $trm_nombre;
    }

    function getTrm_estado() {
        return $this->trm_estado;
    }

    function setTrm_estado($trm_estado) {
        $this->trm_estado = $trm_estado;
    }

}

?>