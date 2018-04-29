<?php
ini_set('date.timezone', 'America/Mexico_City');
define("DS", DIRECTORY_SEPARATOR);
define("ROOT",realpath(dirname(__FILE__)).DS);

include("Slim/Slim.php");
include("app/library/Autoload.php");
\Slim\Slim::registerAutoloader();
\app\library\Autoload::run();
$app = new \Slim\Slim(array(
							'cookies.encrypt' => true,
							'cookies.secret_key' => "4c497c6ef2f4de9952509635b57e7b13a83bbb72b6158550cba5301a4af8c947b0f49c83",
							'cookies.cipher' => MCRYPT_RIJNDAEL_256,
							'cookies.cipher_mode' => MCRYPT_MODE_CBC
			));
$uri = str_replace('/index.php','',$_SERVER['REQUEST_URI']);
$uri = explode('/',$uri);

if(strlen($uri[2])>0){
	$class = 'app\routes'.'\\'.$uri[2].'\Router';
	$object = new $class();
	$object::request($app);
}else{
	$class = 'app\routes\Router';
	$object = new $class();
	$object::request($app);
}

$app->run();
