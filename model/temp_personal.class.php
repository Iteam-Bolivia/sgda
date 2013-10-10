<?php

/**
 * tab_unidad.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Temp_personal extends db {

    var $temp_per_id;
    var $usu_id;
    var $uni_origen;
    var $uni_destino;

    function __construct() {
        parent::__construct();
    }

    function getTemp_per_id() {
        return $this->temp_per_id;
    }

    function setTemp_per_id($temp_per_id) {
        $this->temp_per_id = $temp_per_id;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
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