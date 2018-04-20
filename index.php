<?php 	
	ini_set('date.timezone', 'America/Mexico_City');
	define("DS", DIRECTORY_SEPARATOR);
	define("ROOT",realpath(dirname(__FILE__)).DS);
	if(isset($_SERVER['HTTPS'])) {
		define("URL", "https://".$_SERVER['HTTP_HOST']."/");
	} else {
		define("URL", "http://".$_SERVER['HTTP_HOST']."/");
		//header('location: https://'.$_SERVER['HTTP_HOST'].'/');
	}
	define("API_ADMIN", "http://".$_SERVER['HTTP_HOST']."/middleware/index.php/mrnote/");
	define("API_SITE", "http://".$_SERVER['HTTP_HOST']."/middleware/index.php/publicSite/");
	require_once("config/Autoload.php");
	config\Autoload::run();
	require_once("views/layouts/DefaultLayout.php");
	config\Router::run(new config\Request());
 ?>