<?php

/**
 * tab_doccampolista.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class Tab_doccampolista extends db {

    var $dcl_id;
    var $dcp_id;
    var $dcl_valor;
    var $dcl_estado;

    function __construct() {
        parent::__construct();
    }

    function getDcl_id() {
        return $this->dcl_id;
    }

    function setDcl_id($dcl_id) {
        $this->dcl_id = $dcl_id;
    }


    function getDcp_id() {
        return $this->dcp_id;
    }

    function setDcp_id($dcp_id) {
        $this->dcp_id = $dcp_id;
    }

    function getDcl_valor() {
        return $this->dcl_valor;
    }

    function setDcl_valor($dcl_valor) {
        $this->dcl_valor = $dcl_valor;
    }
    
    function getDcl_estado() {
        return $this->dcl_estado;
    }

    function setDcl_estado($dcl_estado) {
        $this->dcl_estado = $dcl_estado;
    }


}

?>