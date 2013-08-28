<?php

/**
 * tab_expcampo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_expcampovalor extends db {
    
    var $ecv_id;
    var $exp_id;
    var $ecp_id;
    var $ecl_id;
    var $ecv_valor;
    var $ecv_estado;

    function __construct() {
        parent::__construct();
    }

    function getEcv_id() {
        return $this->ecv_id;
    }

    function setEcv_id($ecv_id) {
        $this->ecv_id = $ecv_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
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

    function getEcv_valor() {
        return $this->ecv_valor;
    }

    function setEcv_valor($ecv_valor) {
        $this->ecv_valor = $ecv_valor;
    }
    
    function getEcv_estado() {
        return $this->ecv_estado;
    }

    function setEcv_estado($ecv_estado) {
        $this->ecv_estado = $ecv_estado;
    }

}

?>