<?php namespace app\library;

	class Autoload{
		public static function run(){
			spl_autoload_register(function($class){
				$uri=str_replace("\\","/",$class).".php";
				if(is_readable($uri)){
					include_once($uri);
				}else{
					print "this class doesn't exist";
				}
			});
		}
	}
	
 ?>