<?php namespace app\routes;

	class Router{

		public static function request($app){
			$app->get('/',function() use ($app){
				echo 'no namespace';
			});
		}
	}


 ?>