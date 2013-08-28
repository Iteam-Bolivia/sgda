<?php

/**
 * tab_expcampolista.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_expcampolista extends db {

    var $ecl_id;
    var $ecp_id;
    var $ecl_valor;
    var $ecl_estado;

    function __construct() {
        parent::__construct();
    }

    function getEcl_id() {
        return $this->ecl_id;
    }

    function setEcl_id($ecl_id) {
        $this->ecl_id = $ecl_id;
    }


    function getEcp_id() {
        return $this->ecp_id;
    }

    function setEcp_id($ecp_id) {
        $this->ecp_id = $ecp_id;
    }

    function getEcl_valor() {
        return $this->ecl_valor;
    }

    function setEcl_valor($ecl_valor) {
        $this->ecl_valor = $ecl_valor;
    }
    
    function getEcl_estado() {
        return $this->ecl_estado;
    }

    function setEcl_estado($ecl_estado) {
        $this->ecl_estado = $ecl_estado;
    }


}

?>