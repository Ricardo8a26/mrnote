<?php 	
	ini_set('date.timezone', 'America/Mexico_City');
	define("DS", DIRECTORY_SEPARATOR);
	define("ROOT",realpath(dirname(__FILE__)).DS);
	if(isset($_SERVER['HTTPS'])) {
		define("URL", "https://".$_SERVER['HTTP_HOST']."/");
		define("URLC", "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		define("API_SITE", "http://".$_SERVER['HTTP_HOST']."/middleware/index.php/mrNote/");
	} else {
		define("URL", "http://".$_SERVER['HTTP_HOST']."/");
		define("URLC", "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		define("API_SITE", "http://".$_SERVER['HTTP_HOST']."/middleware/index.php/mrNote/");
	}
	require_once("config/Autoload.php");
	config\Autoload::run();
	require_once("views/layouts/DefaultLayout.php");
	config\Router::run(new config\Request());
 ?>