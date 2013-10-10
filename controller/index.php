<?php

/* * * error reporting on ** */
error_reporting(E_ALL);

/* * * define the site path ** */
$site_path = realpath(dirname(__FILE__));
define('__SITE_PATH', $site_path);

define("PATH_LANG", "es");
define("PATH_DOMAIN", "http://" . $HTTP_SERVER_VARS ['HTTP_HOST']);
define("PATH_ROOT", $_SERVER ['DOCUMENT_ROOT']);
define("PATH_WEB", "http://" . $HTTP_SERVER_VARS ['HTTP_HOST'] . "/web");

define("PATH_DBNAME", "digitalizacion");
define("PATH_DBHOST", "localhost");
define("PATH_DDUSER", "admin");
define("PATH_DBPASS", "DBD1g1t4l#");

define("PATH_FTPHOST", "127.0.0.1");
define("PATH_FTPUSER", "Digital");
define("PATH_FTPPASS", "FTPD1g1t4l#");
define("PATH_FTPDIR", "C:/AppServ/www/Sistema_Digitalizacion/upload/");
define("PATH_FTPDIR_DOWNLOAD", "C:/AppServ/www/Sistema_Digitalizacion/descargas/");

define("PREFIX", "vipfe");
define("SESSNAME", "vipfe");
define("SESSKRYPT", "vipfe");
define("SESSKEY", "vipfe");

define("URL0", 0);
define("URL1", 1);
define("URL2", 2);
define("URL3", 3);
define("URL4", 4);
define("URL5", 5);

setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");

$url = explode('/', $_SERVER ['REQUEST_URI']);

/* * * include the init.php file ** */
include 'includes/init.php';

/* * * load the router ** */
$registry->router = new router($registry);

/* * * set the controller path ** */
$registry->router->setPath(__SITE_PATH . '/controller');

/* * * load up the template ** */
$registry->template = new template($registry);

/* * * load the controller ** */
$registry->router->loader();
?>
