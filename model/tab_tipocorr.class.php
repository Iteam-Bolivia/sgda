<?php

/**
 * tab_tipocorr.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class Tab_tipocorr extends db {

    var $tco_id;
    var $tco_codigo;
    var $tco_nombre;
    var $tco_estado;
    

    function __construct() {
        parent::__construct();
    }

    function getTco_id() {
        return $this->tco_id;
    }

    function setTco_id($tco_id) {
        $this->tco_id = $tco_id;
    }

    function getTco_codigo() {
        return $this->tco_codigo;
    }

    function setTco_codigo($tco_codigo) {
        $this->tco_codigo = $tco_codigo;
    }

    function getTco_nombre() {
        return $this->tco_nombre;
    }

    function setTco_nombre($tco_nombre) {
        $this->tco_nombre = $tco_nombre;
    }

    function getTco_estado() {
        return $this->tco_estado;
    }

    function setTco_estado($tco_estado) {
        $this->tco_estado = $tco_estado;
    }


}

?>