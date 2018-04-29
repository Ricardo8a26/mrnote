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
							'cookies.secret_key' => "a813d7a3a0591cc18223d906dcdf95d10983d2c0550a0d0d690a54ec8026b54cff080e63",
							'cookies.cipher' => MCRYPT_RIJNDAEL_256,
							'cookies.cipher_mode' => MCRYPT_MODE_CBC
			));
$uri = str_replace('/index.php','',$_SERVER['REQUEST_URI']);
$uri = explode('/',$uri);
if(strlen($uri[2])>0) {
	$class = 'app\routes'.'\\'.$uri[2].'\Router';
	$object = new $class();
	$object::request($app);
} else {
	$class = 'app\routes\Router';
	$object = new $class();
	$object::request($app);
}
$app->run();