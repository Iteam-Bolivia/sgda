<?php

/**
 * tab_oficina.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class Tab_oficina extends db {

    var $ofi_id;
    var $ofi_codigo;
    var $ofi_nombre;
    var $ofi_estado;
    var $ofi_contador;
    

    function __construct() {
        parent::__construct();
    }

    function getOfi_id() {
        return $this->ofi_id;
    }

    function setOfi_id($ofi_id) {
        $this->ofi_id = $ofi_id;
    }

    function getOfi_codigo() {
        return $this->ofi_codigo;
    }

    function setOfi_codigo($ofi_codigo) {
        $this->ofi_codigo = $ofi_codigo;
    }

    function getOfi_nombre() {
        return $this->ofi_nombre;
    }

    function setOfi_nombre($ofi_nombre) {
        $this->ofi_nombre = $ofi_nombre;
    }

    function getOfi_estado() {
        return $this->ofi_estado;
    }

    function setOfi_estado($ofi_estado) {
        $this->ofi_estado = $ofi_estado;
    }

    function getOfi_contador() {
        return $this->ofi_contador;
    }

    function setOfi_contador($ofi_contador) {
        $this->ofi_contador = $ofi_contador;
    }    

}

?>