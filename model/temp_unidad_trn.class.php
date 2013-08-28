<?php

/**
 * temp_unidad_trn.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Temp_unidad_trn extends db {

    var $temp_unitrn_id;
    var $uni_origen;
    var $uni_destino;

    function __construct() {
        parent::__construct();
    }

    function getTemp_unitrn_id() {
        return $this->temp_unitrn_id;
    }

    function setTemp_unitrn_id($temp_unitrn_id) {
        $this->temp_unitrn_id = $temp_unitrn_id;
    }

    function getUni_origen() {
        return $this->uni_origen;
    }

    function setUni_origen($uni_origen) {
        $this->uni_origen = $uni_origen;
    }

    function getUni_destino() {
        return $this->uni_destino;
    }

    function setUni_destino($uni_destino) {
        $this->uni_destino = $uni_destino;
    }

}

?>