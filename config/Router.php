<?php namespace config;
	class Router{
		public static function run(Request $request){
			$controller=$request->getController()."Controller";
			$route_controller=ROOT."controllers".DS.$controller.".php";
			$route_view=ROOT."views".DS.$request->getController().DS.$request->getMethod().".php";
			$not_found_view=ROOT."views".DS."404".DS."not_found_view.php";
			$not_found_controller=ROOT."views".DS."404".DS."not_found_controller.php";
			$method=$request->getMethod();
			$arguments=$request->getArguments();

			if(is_readable($route_controller)){
				$class_controller="controllers\\".$controller;
				$object_controller=new $class_controller;
				
				if(!isset($arguments)){
					if(method_exists($object_controller, $method)){
						$data=call_user_func(array($object_controller, $method));
						if(is_readable($route_view)){

							require_once($route_view);
						}else if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
							require_once($not_found_view);
						}
					}else{
						print "this action cannot execute";
					}
				}else{
					if(method_exists($object_controller, $method)){
						$data=call_user_func_array(array($object_controller, $method),$arguments);
						if(is_readable($route_view)){
							require_once($route_view);
						}else if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
							require_once($not_found_view);
						}
					}else{
						print "this action cannot execute";
					}
				}
			}else{
				$uri = URL.'Public/index/'.substr($controller, 0, -10);
				?>
					<script>
						location.href = '<?php echo $uri; ?>';
					</script>
				<?php
			}
		}
	}

 ?>