<?php

class router {
    /*
     * @the registry
     */

    private $registry;
    /*
     * @the controller path
     */
    private $path;
    private $args = array();
    public $file;
    public $controller;
    public $action;

    function __construct($registry) {
        $this->registry = $registry;
    }

    /**
     *
     * @set controller directory path
     *
     * @param string $path
     *
     * @return void
     *
     */
    function setPath($path) {
        /*         * * check if path i sa directory ** */
        if (is_dir($path) == false) {
            throw new Exception('Invalid controller path: `' . $path . '`');
        }
        /*         * * set the path ** */
        $this->path = $path;
    }

    /**
     *
     * @load the controller
     *
     * @access public
     *
     * @return void
     *
     */
//	public function loader()
//	{
//		/*** check the route ***/
//		$this->getController();
//
//		/*** if the file is not there diaf ***/
//		if (is_readable($this->file) == false)
//		{
//			$this->file = $this->path.'/error404.php';
//			$this->controller = 'error404';
//		}
//
//		/*** include the controller ***/
//		include $this->file;
//
//		/*** a new controller class instance ***/
//		$class = $this->controller . 'Controller';
//		$controller = new $class($this->registry);
//
//		/*** check if the action is callable ***/
//		if (is_callable(array($controller, $this->action)) == false)
//		{
//			$action = 'index';
//		}
//		else
//		{
//			$action = $this->action;
//		}
//
//
//		/*** run the action ***/
//		$controller->$action();
//	}

    public function loader() {
        /*         * * check the route ** */
        $this->getController();

        /*         * * if the file is not there diaf ** */
        if (is_readable($this->file) == false) {
            $this->file = $this->path . '/error404.php';
            $this->controller = 'error404';
        }


        $rol = new rol();
        if ($this->controller != "index" && $this->controller != "login") {
            $usu_id = $_SESSION['USU_ID'];
            $switch = $rol->validaAcceso($usu_id, $this->controller);
            if ($switch == false) {
                $this->file = $this->path . '/error404.php';
                $this->controller = 'error404';
            }
        }




        /*         * * include the controller ** */
        include $this->file;

        /*         * * a new controller class instance ** */
        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);

        /*         * * check if the action is callable ** */
        if (is_callable(array($controller, $this->action)) == false) {
            $action = 'index';
        } else {
            $action = $this->action;
        }


        /*         * * run the action ** */
        $controller->$action();
    }

    /**
     *
     * @get the controller
     *
     * @access private
     *
     * @return void
     *
     */
    private function getController() {
        /*         * * get the route from the url ** */
        //$route = (empty($_GET['rt'])) ? '' : $_GET['rt'];
        $route = explode('/', $_SERVER['REQUEST_URI']);

        if (isset($route[URL1])) {
            define("VAR1", $route[URL1]);
        }

        if (isset($route[URL2])) {
            define("VAR2", $route[URL2]);
        }

        if (isset($route[URL3])) {
            define("VAR3", $route[URL3]);
        }

        if (isset($route[URL4])) {
            define("VAR4", $route[URL4]);
        }

        if (isset($route[URL5])) {
            define("VAR5", $route[URL5]);
        }

        if (empty($route[URL1])) {
            $route = 'index';
        } else {
            /*             * * get the parts of the route ** */
            //$parts = explode('/', $route);
            $this->controller = $route[URL1];
            if (isset($route[URL2])) {
                $this->action = $route[URL2];
            }
        }

        if (empty($this->controller)) {
            $this->controller = 'index';
        }

        /*         * * Get action ** */
        if (empty($this->action)) {
            $this->action = 'index';
        }

        /*         * * set the file path ** */
        //print($this->path .'/'. $this->controller . 'Controller.php');
        //print ($this->action);
        if (!isset($_SESSION['USU_ID'])) {
            if ($this->controller != "login") {
                $this->controller = 'index';
                $this->action = 'index';
            }
            if ($this->controller == "login" && $this->action == "show") {
                $this->controller = 'index';
                $this->action = 'index';
            }
        }
        $this->file = $this->path . '/' . $this->controller . 'Controller.php';
    }

}

?>