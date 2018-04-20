<?php namespace app\routes\publicSite;
	use app\library\Conection as conection;
	class Router extends conection{

		public static function request($app){
			
			$app->post("/publicSite/authDomain", function() use ($app){
	        	//create the conexion
		        $conection=new Conection();
		        //if the domains is valid, we send the API key and we close the conexion
		        if($conection->authDomain($app->request->post("domain"),$app->request->post("key_domain"))){
		            $app->setCookie('IS_AUTHORIZED', $app->request->post("key_domain"), '30 minutes');         
		            $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		            $app->response->headers->set("Content-type", "application/json");
		            $app->response->status(200);
		            $app->response->body(json_encode(array('response' => true)));
		        //othewise we send a worng message and we close the conexion
		        }else{
		            $app->deleteCookie('IS_AUTHORIZED', '/', $_SERVER['HTTP'], true, true);
		            $app->response->headers->set("Access-Control-Allow-Origin",$_SERVER['HTTP_ORIGIN']);
		            $app->response->headers->set("Content-type", "application/json");
		            $app->response->status(200);
		            $app->response->body(json_encode(array("response"=>false)));
		        }
		    });//end getDomain request
		    $app->post("/publicSite/create/:table",function($table) use ($app){
				$fields=array();
	            $values=array();
	            $query="";
	            try{
	                $key_api=$app->getCookie("IS_AUTHORIZED");
	                if(isset($key_api)&&$table == 'request_memberships'){
	                    $conection=new Conection();
	                	$conection->startConection();
	                	foreach ($app->request->post() as $key => $value) {
	                        array_push($fields, $key);
	                        array_push($values, $value);
	                    }       
	                    $querys="INSERT INTO ".$table." VALUES (";
	                    for ($i=0; $i < count($fields); $i++) { 
	                        if($i==count($fields)-1){
	                            $querys=$querys."?)";
	                        }else{
	                            $querys=$querys."?,";
	                        }
	                        
	                    }
	                    
	                    $sql=$conection->getConection()->prepare($querys);
	                    for ($i=1; $i <= count($values) ; $i++) { 
	                        $sql->bindParam($i,$values[$i-1]);
	                    }
	                    $sql->execute();
	                    $new=$conection->getConection()->lastInsertId();
	                    if(isset($new)){
	                        //$app->response->headers->set("Access-Control-Allow-Origin",$conexion->getAttribute("domain"));
	                        $app->response->headers->set("Access-Control-Allow-Origin",$conection->getAttribute("domain"));
	                        $app->response->headers->set("Content-type", "application/json");
	                        $app->response->status(200);
	                        $app->response->body(json_encode(array("response"=>true)));
	                    }else{
	                    	$app->response->headers->set("Access-Control-Allow-Origin",$conection->getAttribute("domain"));
	                        //$app->response->headers->set("Access-Control-Allow-Origin",$conexion->getAttribute("domain"));
	                        $app->response->headers->set("Content-type", "application/json");
	                        $app->response->status(200);
	                        $app->response->body(json_encode(array("response"=>false,)));
	                    }

	                }else{
		                $app->response->headers->set("Access-Control-Allow-Origin",$_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
		            }
	                $conection=null;
	            }catch(\PDOException $e){
	                    print "Error: Internal Error ".$e;
	            }
			});
			$app->get('/publicSite/:table',function($table) use ($app){
				$key_api=$app->getCookie("IS_AUTHORIZED");
				if(isset($key_api)&&$table != 'admins'){
					try{
						$conection = new Conection();
						$conection->startConection();
						$sql = $conection->getConection()->prepare('SELECT * FROM '.$table);
						$sql->execute();
						$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
						if($data){
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode($data));
						}else{
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode(array('response'=>false)));
						}
					}catch(\PDOException $e){

					}
				}else{
	                $app->response->headers->set("Access-Control-Allow-Origin",$_SERVER['HTTP_ORIGIN']);
	                $app->response->headers->set("Content-type", "application/json");
	                $app->response->status(200);
	                $app->response->body(json_encode(array("response"=>false)));
	            }

			});
			$app->get('/publicSite/:table/:pattern/:value',function($table,$pattern,$value) use ($app){
				$key_api=$app->getCookie("IS_AUTHORIZED");
				if(isset($key_api)&&$table != 'admins'){
					try{
						$conection = new Conection();
						$conection->startConection();
						$sql = $conection->getConection()->prepare("SELECT * FROM $table WHERE $pattern LIKE '%$value%'");
						$sql->execute();
						$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
						if($data){
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode($data));
						}else{
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode(array('response'=>false)));
						}
					}catch(\PDOException $e){
						print $e;
					}
				}else{
	                $app->response->headers->set("Access-Control-Allow-Origin",$_SERVER['HTTP_ORIGIN']);
	                $app->response->headers->set("Content-type", "application/json");
	                $app->response->status(200);
	                $app->response->body(json_encode(array("response"=>false)));
	            }

			});
			$app->get('/publicSite/byCond/:table/:condition/:value_condition',function($table, $condition, $value_condition) use ($app){
				$key_api=$app->getCookie("IS_AUTHORIZED");
				if(isset($key_api)&&$table != 'admins'){
					try{
						$conection = new Conection();
						$conection->startConection();
						$sql = $conection->getConection()->prepare('SELECT * FROM '.$table.' WHERE '.$condition.' = ?');
						$sql->bindParam(1,$value_condition);
						$sql->execute();
						$data = $sql->fetch(\PDO::FETCH_ASSOC);
						if($data){
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode($data));
						}else{
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode(array('response'=>false)));
						}
					}catch(\PDOException $e){

					}
				}else{
	                $app->response->headers->set("Access-Control-Allow-Origin",$_SERVER['HTTP_ORIGIN']);
	                $app->response->headers->set("Content-type", "application/json");
	                $app->response->status(200);
	                $app->response->body(json_encode(array("response"=>false)));
	            }

			});
		
		}

	}

 ?>