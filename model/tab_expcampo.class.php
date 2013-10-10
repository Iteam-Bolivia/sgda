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
class Tab_expcampo extends db {

    var $ecp_id;
    var $ser_id;
    var $ecp_orden;
    var $ecp_nombre;
    var $ecp_eti;
    var $ecp_tipdat;
    var $ecp_estado;

    function __construct() {
        parent::__construct();
    }

    function getEcp_id() {
        return $this->ecp_id;
    }

    function setEcp_id($ecp_id) {
        $this->ecp_id = $ecp_id;
    }

    function getSer_id() {
        return $this->ser_id;
    }

    function setSer_id($ser_id) {
        $this->ser_id = $ser_id;
    }

    function getEcp_orden() {
        return $this->ecp_orden;
    }

    function setEcp_orden($ecp_orden) {
        $this->ecp_orden = $ecp_orden;
    }

    function getEcp_nombre() {
        return $this->ecp_nombre;
    }

    function setEcp_nombre($ecp_nombre) {
        $this->ecp_nombre = $ecp_nombre;
    }
    
    function getEcp_eti() {
        return $this->ecp_eti;
    }

    function setEcp_eti($ecp_eti) {
        $this->ecp_eti = $ecp_eti;
    }

    function getEcp_tipdat() {
        return $this->ecp_tipdat;
    }

    function setEcp_tipdat($ecp_tipdat) {
        $this->ecp_tipdat = $ecp_tipdat;
    }

    function getEcp_estado() {
        return $this->ecp_estado;
    }

    function setEcp_estado($ecp_estado) {
        $this->ecp_estado = $ecp_estado;
    }


}

?>