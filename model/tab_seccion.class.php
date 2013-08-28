<?php

/**
 * tab_seccion.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_seccion extends db {

    var $sec_id;
    var $uni_id;
    var $sec_codigo;
    var $sec_nombre;
    var $sec_estado;

    function __construct() {
        parent::__construct();
    }

    function getSec_id() {
        return $this->sec_id;
    }

    function setSec_id($sec_id) {
        $this->sec_id = $sec_id;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getSec_codigo() {
        return $this->sec_codigo;
    }

    function setSec_codigo($sec_codigo) {
        $this->sec_codigo = $sec_codigo;
    }

    function getSec_nombre() {
        return $this->sec_nombre;
    }

    function setSec_nombre($sec_nombre) {
        $this->sec_nombre = $sec_nombre;
    }

    function getSec_estado() {
        return $this->sec_estado;
    }

    function setSec_estado($sec_estado) {
        $this->sec_estado = $sec_estado;
    }

}

?>