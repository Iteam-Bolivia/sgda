<?php

/**
 * tab_palclavea.class.php Class
 *
 * @pcakage
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_palclavea extends db {

    var $pca_id;
    var $fil_id;
    var $pca_nombre;
    var $pca_formulario;
    var $pca_estado;

    function __construct() {
        parent::__construct();
    }

    function getPca_id() {
        return $this->pca_id;
    }

    function setPca_id($pca_id) {
        $this->pca_id = $pca_id;
    }

    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    
    function getPca_nombre() {
        return $this->pca_nombre;
    }

    function setPca_nombre($pca_nombre) {
        $this->pca_nombre = $pca_nombre;
    }

    function getPca_formulario() {
        return $this->pca_formulario;
    }

    function setPca_formulario($pca_formulario) {
        $this->pca_formulario = $pca_formulario;
    }

    function getPca_estado() {
        return $this->pca_estado;
    }

    function setPca_estado($pca_estado) {
        $this->pca_estado = $pca_estado;
    }

}

?>