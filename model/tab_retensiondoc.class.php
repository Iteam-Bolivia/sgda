<?php

/**
 * tab_retensiondoc.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class Tab_retensiondoc extends db {

    var $red_id;
    var $red_codigo;
    var $red_series;
    var $red_tipodoc;
    var $red_valdoc;
    var $red_prearc;
    var $red_estado;
    

    function __construct() {
        parent::__construct();
    }

    function getRed_id() {
        return $this->red_id;
    }

    function setRed_id($red_id) {
        $this->red_id = $red_id;
    }

    function getRed_codigo() {
        return $this->red_codigo;
    }

    function setRed_codigo($red_codigo) {
        $this->red_codigo = $red_codigo;
    }

    function getRed_series() {
        return $this->red_series;
    }

    function setRed_series($red_series) {
        $this->red_series = $red_series;
    }

    function getRed_tipodoc() {
        return $this->red_tipodoc;
    }

    function setRed_tipodoc($red_tipodoc) {
        $this->red_tipodoc = $red_tipodoc;
    }
    
    function getRed_valdoc() {
        return $this->red_valdoc;
    }

    function setRed_valdoc($red_valdoc) {
        $this->red_valdoc = $red_valdoc;
    }    
    
    function getRed_prearc() {
        return $this->red_prearc;
    }

    function setRed_prearc($red_prearc) {
        $this->red_prearc = $red_prearc;
    }        
    
    function getRed_estado() {
        return $this->red_estado;
    }

    function setRed_estado($red_estado) {
        $this->red_estado = $red_estado;
    }


}

?>