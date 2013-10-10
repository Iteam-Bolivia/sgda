<?php

/**
 * tab_departamento.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_intermedia extends db2 {

    var $cor_id;
    var $cor_nur;
    var $cor_parnur;
    var $cor_cite;
    var $cor_referencia;
    var $tdo_id;
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

    function getCor_nur() {
        return $this->cor_nur;
    }

    function setCor_nur($cor_nur) {
        $this->cor_nur = $cor_nur;
    }

    function getCor_parnur() {
        return $this->cor_parnur;
    }

    function setCor_parnur($cor_parnur) {
        $this->cor_parnur = $cor_parnur;
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

    function getTdo_id() {
        return $this->tdo_id;
    }

    function setTdo_id($tdo_id) {
        $this->tdo_id = $tdo_id;
    }

    function getCor_estado() {
        return $this->cor_estado;
    }

    function setCor_estado($cor_estado) {
        $this->cor_estado = $cor_estado;
    }

}

?>