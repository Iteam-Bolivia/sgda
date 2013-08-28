<?php

/**
 * tab_sopfisico.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_sopfisico extends db {

    var $sof_id;
    var $sof_codigo;
    var $sof_nombre;
    var $sof_estado;

    function __construct() {
        parent::__construct();
    }

    function getSof_id() {
        return $this->sof_id;
    }

    function setSof_id($sof_id) {
        $this->sof_id = $sof_id;
    }

    function getSof_codigo() {
        return $this->sof_codigo;
    }

    function setSof_codigo($sof_codigo) {
        $this->sof_codigo = $sof_codigo;
    }

    function getSof_nombre() {
        return $this->sof_nombre;
    }

    function setSof_nombre($sof_nombre) {
        $this->sof_nombre = $sof_nombre;
    }

    function getSof_estado() {
        return $this->sof_estado;
    }

    function setSof_estado($sof_estado) {
        $this->sof_estado = $sof_estado;
    }

}

?>