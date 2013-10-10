<?php

/**
 * dim_usuario.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class dusuario extends db {

    var $usr_login;
    var $uni_codigo;
    var $estado;

    function __construct() {
        parent::__construct();
    }

    function getUsr_login() {
        return $this->usr_login;
    }

    function setUsr_login($usr_login) {
        $this->usr_login = $usr_login;
    }

    function getUni_codigo() {
        return $this->uni_codigo;
    }

    function setUni_codigo($uni_codigo) {
        $this->uni_codigo = $uni_codigo;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
?>
