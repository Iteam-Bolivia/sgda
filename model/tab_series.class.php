<?php

/**
 * tab_series.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_series extends db {

    var $ser_id;
    var $uni_id;
    var $tco_id;
    var $red_id;
    var $ser_par;
    var $ser_codigo;
    var $ser_categoria;
    var $ser_contador;
    var $ser_estado;
    var $ser_nivel;
    
    // Others
    var $ser_tipo;
    var $dep_id;
    
    function __construct() {
        parent::__construct();
    }

    function getSer_id() {
        return $this->ser_id;
    }

    function setSer_id($ser_id) {
        $this->ser_id = $ser_id;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }
    
    function getTco_id() {
        return $this->tco_id;
    }

    function setTco_id($tco_id) {
        $this->tco_id = $tco_id;
    }
    
    function getRed_id() {
        return $this->red_id;
    }

    function setRed_id($red_id) {
        $this->red_id = $red_id;
    } 
    
    function getSer_par() {
        return $this->ser_par;
    }

    function setSer_par($ser_par) {
        $this->ser_par = $ser_par;
    }    
    
    function getSer_codigo() {
        return $this->ser_codigo;
    }

    function setSer_codigo($ser_codigo) {
        $this->ser_codigo = $ser_codigo;
    }
    
    function getSer_categoria() {
        return $this->ser_categoria;
    }
    
    function setSer_categoria($ser_categoria) {
        $this->ser_categoria = $ser_categoria;
    }

    function getSer_contador() {
        return $this->ser_contador;
    }

    function setSer_contador($ser_contador) {
        $this->ser_contador = $ser_contador;
    } 
    
    function getSer_estado() {
        return $this->ser_estado;
    }

    function setSer_estado($ser_estado) {
        $this->ser_estado = $ser_estado;
    }    
    
    // Others
    function getSer_tipo() {
        return $this->ser_tipo;
    }

    function setSer_tipo($ser_tipo) {
        $this->ser_tipo = $ser_tipo;
    }

    function getDep_id() {
        return $this->dep_id;
    }

    function setDep_id($dep_id) {
        $this->dep_id = $dep_id;
    }
    
    function getSer_nivel() {
        return $this->ser_nivel;
    }

    function setSer_nivel($ser_nivel) {
        $this->ser_nivel = $ser_nivel;
    } 


    
   
    
   
}

?>