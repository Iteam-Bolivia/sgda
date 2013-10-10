<?php

/**
 * tab_version.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_version extends db {

    var $ver_id;
    var $ver_fecha_ini;
    var $ver_fecha_fin;
    var $ver_paso;
    var $usu_id;
    var $ver_fecha_crea;
    var $ver_estado;

    function __construct() {
        parent::__construct();
    }

    function getVer_id() {
        return $this->ver_id;
    }

    function setVer_id($ver_id) {
        $this->ver_id = $ver_id;
    }

    function getVer_fecha_ini() {
        return $this->ver_fecha_ini;
    }

    function setVer_fecha_ini($ver_fecha_ini) {
        $this->ver_fecha_ini = $ver_fecha_ini;
    }

    function getVer_fecha_fin() {
        return $this->ver_fecha_fin;
    }

    function setVer_fecha_fin($ver_fecha_fin) {
        $this->ver_fecha_fin = $ver_fecha_fin;
    }

    function getVer_paso() {
        return $this->ver_paso;
    }

    function setVer_paso($ver_paso) {
        $this->ver_paso = $ver_paso;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getVer_fecha_crea() {
        return $this->ver_fecha_crea;
    }

    function setVer_fecha_crea($ver_fecha_crea) {
        $this->ver_fecha_crea = $ver_fecha_crea;
    }

    function getVer_estado() {
        return $this->ver_estado;
    }

    function setVer_estado($ver_estado) {
        $this->ver_estado = $ver_estado;
    }

}

?>
