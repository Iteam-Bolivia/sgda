<?php

/* * * error reporting on ** */
error_reporting(E_ALL);

/* * * define the site path ** */
$site_path = realpath(dirname(__FILE__));
define('__SITE_PATH', $site_path);
define("PATH_LANG", "es");

/* * * Define Variables Globales server applications: dominio. * * */
//define("PATH_DOMAIN", "http://archivo-prueba.abc.gob.bo");
//define("PATH_ROOT", $_SERVER ['DOCUMENT_ROOT']);
//define("PATH_WEB", "http://archivo-prueba.abc.gob.bo/web");

/* * * Define Variables Globales server applications . * * */
define("PATH_DOMAIN", "http://localhost/archivo-prueba2");
define("PATH_ROOT", $_SERVER ['DOCUMENT_ROOT'] . "/archivo-prueba2");
define("PATH_WEB", "http://localhost/archivo-prueba2/web");

/* * * Define constants  * * */
define("DELIMITER", ".");
define("SEPARATOR_SEARCH", ";");
define("ROUNDED", "2");

/* * * Define PostgreSQL database server connect parameters - SGDA ** */
define('PGHOST', 'localhost');
define('PGPORT', 5432);
define('PGDATABASE', 'bd_abc_archivo2');
define('PGUSER', 'jovando');
define('PGPASSWORD', 'iteam123');

/* * * Define Mysql database server connect parameters - SIACO ** */
define ( "PATH_DBNAME", "siaco" );
define ( "PATH_DBHOST", "localhost" );
define ( "PATH_DDUSER", "root" );
define ( "PATH_DBPASS", "" );


/* * * Define FTP Account connect parameters. ** */
define("PATH_FTPHOST", "127.0.0.1");
define("PATH_FTPUSER", "Digital");
define("PATH_FTPPASS", "FTPD1g1t4l#");
define("PATH_FTPDIR", $_SERVER ['DOCUMENT_ROOT'] . "/upload/");
define("PATH_FTPDIR_DOWNLOAD", $_SERVER ['DOCUMENT_ROOT'] . "/descargas/");

define("PREFIX", "abc");
define("SESSNAME", "abc");
define("SESSKRYPT", "abc");
define("SESSKEY", "abc");

/* * * Define Level Path domain * * */
//define("URL0", 0);
//define("URL1", 1);
//define("URL2", 2);
//define("URL3", 3);
//define("URL4", 4);
//define("URL5", 5);

/* * * Define Level Path IP * * */
define("URL0", 1);
define("URL1", 2);
define("URL2", 3);
define("URL3", 4);
define("URL4", 5);
define("URL5", 6);




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
