<?php

Class error404Controller Extends baseController {

    public function index() {
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->show('error404');
    }

}

?>
