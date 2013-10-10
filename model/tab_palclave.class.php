<?php

/**
 * tab_palclave.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_palclave extends db {

    var $pac_id;
    var $exp_id;
    var $fil_id;
    var $pac_nombre;
    var $pac_formulario;
    var $pac_estado;

    function __construct() {
        parent::__construct();
    }

    function getPac_id() {
        return $this->pac_id;
    }

    function setPac_id($pac_id) {
        $this->pac_id = $pac_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getFil_id() {
        return $this->fil_id;
    }
    
    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }    

    function getPac_nombre() {
        return $this->pac_nombre;
    }

    function setPac_nombre($pac_nombre) {
        $this->pac_nombre = $pac_nombre;
    }

    function getPac_formulario() {
        return $this->pac_formulario;
    }

    function setPac_formulario($pac_formulario) {
        $this->pac_formulario = $pac_formulario;
    }

    function getPac_estado() {
        return $this->pac_estado;
    }

    function setPac_estado($pac_estado) {
        $this->pac_estado = $pac_estado;
    }

}

?>