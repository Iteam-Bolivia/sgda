<?php

Class indexController Extends baseController {

    public function index() {

        $this->registry->template->nivel = '';
        /*         * * set a template variable ** */
        $this->registry->template->inventario = 'inventario';
        $this->registry->template->prestamos = 'prestamos';
        $this->registry->template->observaciones = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "login";
        $this->registry->template->show('index.tpl');
    }

}

?>
