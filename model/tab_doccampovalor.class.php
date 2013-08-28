<?php

/**
 * tab_doccampovalor.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class Tab_doccampovalor extends db {
    var $dcv_id;
    var $fil_id;
    var $ecp_id;
    var $ecl_id;
    var $dcv_valor;
    var $dcv_estado;
    

    function __construct() {
        parent::__construct();
    }

    function getDcv_id() {
        return $this->dcv_id;
    }

    function setDcv_id($dcv_id) {
        $this->dcv_id = $dcv_id;
    }
    
    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    function getEcp_id() {
        return $this->ecp_id;
    }

    function setEcp_id($ecp_id) {
        $this->ecp_id = $ecp_id;
    }

    function getEcl_id() {
        return $this->ecl_id;
    }

    function setEcl_id($ecl_id) {
        $this->ecl_id = $ecl_id;
    } 
    
    function getDcv_valor() {
        return $this->dcv_valor;
    }

    function setDcv_valor($dcv_valor) {
        $this->dcv_valor = $dcv_valor;
    }    
        
    function getDcv_estado() {
        return $this->fil_estado;
    }

    function setDcv_estado($fil_estado) {
        $this->fil_estado = $fil_estado;
    }

}

?>