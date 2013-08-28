<?php

/**
 * tab_archivobin.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_archivobin extends db {

    var $fil_id;
    var $fil_contenido;
    var $fil_estado;

    function __construct() {
        parent::__construct();
    }

    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    function getFil_contenido() {
        return $this->fil_contenido;
    }

    function setFil_contenido($fil_contenido) {
        $this->fil_contenido = $fil_contenido;
    }

    function getFil_estado() {
        return $this->fil_estado;
    }

    function setFil_estado($fil_estado) {
        $this->fil_estado = $fil_estado;
    }

}

?>