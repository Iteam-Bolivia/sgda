<?php

/**
 * tab_correspondencia.class.php Class
 * 
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */

class Tab_correspondencia extends db {

    var $cor_id;
    var $fil_id;
    var $cor_nur;
    var $cor_cite;
    var $cor_referencia;
    var $cor_estado;

    function __construct() {
        parent::__construct();
    }

    function getCor_id() {
        return $this->cor_id;
    }

    function setCor_id($cor_id) {
        $this->cor_id = $cor_id;
    }

    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    function getCor_nur() {
        return $this->cor_nur;
    }

    function setCor_nur($cor_nur) {
        $this->cor_nur = $cor_nur;
    }

    function getCor_cite() {
        return $this->cor_cite;
    }

    function setCor_cite($cor_cite) {
        $this->cor_cite = $cor_cite;
    }
          
    function getCor_referencia() {
        return $this->cor_referencia;
    }

    function setCor_referencia($cor_referencia) {
        $this->cor_referencia = $cor_referencia;
    }

    function getCor_estado() {
        return $this->cor_estado;
    }

    function setCor_estado($cor_estado) {
        $this->cor_estado = $cor_estado;
    }

}

?>