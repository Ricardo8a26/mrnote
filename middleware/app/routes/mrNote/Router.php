<?php namespace app\routes\mrNote;
	use app\library\Conection as conection;
	class Router extends conection {

		public static function request($app) {
	
			$app->post("/mrNote/authDomain", function() use ($app) {
	  			//create the conection
		        $conection=new Conection();
		        //if the domains is valid, we send the API key and we close the conection
		        if($conection->authDomain($app->request->post("domain"), $app->request->post("key_domain"))) {
		            $app->setCookie('IS_AUTHORIZED', $app->request->post("key_domain"), '30 minutes');
		            $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		            $app->response->headers->set("Content-type","application/json");
		            $app->response->status(200);
		            $app->response->body(json_encode(array('response' => true)));
		        //othewise we send a wrong message and we close the conection
		        } else {
		            $app->deleteCookie('IS_AUTHORIZED', '/', $_SERVER['HTTP'], true, true);
		            $app->response->headers->set("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN']);
		            $app->response->headers->set("Content-type", "application/json");
		            $app->response->status(200);
		            $app->response->body(json_encode(array("response"=>false)));
		        }
		    });

			$app->post("/mrNote/create/:table",function($table) use ($app) {
				$fields=array();
	            $values=array();
	            $query="";
	            try {
	                $key_api=$app->getCookie("IS_AUTHORIZED");
	                if(isset($key_api)) {
	                    $conection=new Conection();
	                	$conection->startConection();
	                	foreach ($app->request->post() as $key => $value) {
	                        array_push($fields, $key);
	                        array_push($values, $value);  
	                    }
	                    $querys="INSERT INTO ".$table." VALUES (";
	                    for ($i=0; $i<count($fields); $i++) { 
	                        if($i==count($fields)-1) {
	                            $querys=$querys."?)";
	                        } else {
	                            $querys=$querys."?,";
	                        } 
	                    }
	                    $sql=$conection->getConection()->prepare($querys);
	                    for ($i=1; $i <= count($values) ; $i++) { 
	                        $sql->bindParam($i, $values[$i-1]);
	                    }
	                    $sql->execute();
	                    $new=$conection->getConection()->lastInsertId();
	                    if(isset($new)) {
	                        $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
	                        $app->response->headers->set("Content-type", "application/json");
	                        $app->response->status(200);
	                        $app->response->body(json_encode(array("response"=>true)));
	                    } else {
	                    	$app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
	                        $app->response->headers->set("Content-type", "application/json");
	                        $app->response->status(200);
	                        $app->response->body(json_encode(array("response"=>false,)));
	                    }
	                    $conection->stopConection();
	                } else {
		                $app->response->headers->set("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
		            }
	            } catch(\PDOException $e) {
	                    print "Error: Internal Service Error ".$e;
	            }
			});

			$app->get('/mrNote/:table',function($table) use ($app) {
				try{
					$key_api=$app->getCookie("IS_AUTHORIZED");	
					if(isset($key_api)) {
						$conection = new Conection();
						$conection->startConection();
						$sql = $conection->getConection()->prepare('SELECT * FROM '.$table);
						$sql->execute();
						$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
						if($data) {
							$app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode($data));
						} else {
							$app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode(array('response'=>false)));
						}
						$conection->stopConection();
					} else {
		                $app->response->headers->set("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
	           		}	
				} catch(\PDOException $e) {
					print "Error: Internal Service Error ".$e;
				}
			});

			$app->get('/mrNote/:table/:condition/:value_condition',function($table, $condition, $value_condition) use ($app) {
				try{
					$key_api=$app->getCookie("IS_AUTHORIZED");
					if(isset($key_api)) {
						$conection = new Conection();
						$conection->startConection();
						$sql = $conection->getConection()->prepare('SELECT * FROM '.$table.' WHERE '.$condition.' = ?');
						$sql->bindParam(1, $value_condition);
						$sql->execute();
						$data = $sql->fetch(\PDO::FETCH_ASSOC);
						if($data) {
							$app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode($data));
						} else {
							$app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode(array('response'=>false)));
						}
						$conection->stopConection();
					} else {
		                $app->response->headers->set("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
		            }	
				} catch(\PDOException $e) {
					print "Error: Internal Service Error ".$e;
				}
			});

			$app->post("/mrNote/update/:table", function($table) use ($app) {
		        try{
		            $key_api=$app->getCookie("IS_AUTHORIZED");
		            if(isset($key_api)) {
		                $conection=new Conection();
		                $conection->startConection();
		                $field = $app->request->post('field');
		                $value_field = $app->request->post('value_field');
		                $condition = $app->request->post('condition');
		                $value_condition = $app->request->post('value_condition');
		                $sql = $conection->getConection()->prepare("UPDATE $table set $field=? WHERE $condition=?");
		                $sql->bindParam(1, $value_field);
		                $sql->bindParam(2, $value_condition);
		                $response = $sql->execute();
		                if(isset($response)) {
		                    $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode(array("response"=>true)));
		                } else {
		                    $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode(array("response"=>false)));
		                }
		                $conection->stopConection();
		            } else {
		                $app->response->headers->set("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
		            }
		        } catch(\PDOException $e) {
		            print "Error: Internal Service Error ".$e;
		        }
		    });

		    $app->post("/mrNote/delete/:table", function($table) use ($app) {
		        try{
		            $key_api=$app->getCookie("IS_AUTHORIZED");
		            if(isset($key_api)) {
		                $conection=new Conection();
		                $conection->startConection();
		                $condition = $app->request->post('condition');
		                $value_condition = $app->request->post('value_condition');
		                $sql = $conection->getConection()->prepare('DELETE FROM '.$table.' WHERE '.$condition.' = ?');
		                $sql->bindParam(1, $value_condition);
		                $response = $sql->execute();
		                if($response) {
		                    $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode(array("response"=>true)));
		                } else {
		                    $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode(array("response"=>false)));
		                }
		                $conection->stopConection();
		            } else {
		                $app->response->headers->set("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
		            }
		        } catch(\PDOException $e) {
		            print "Error: Internal Service Error ".$e;
		        }
		    });

		    $app->post("/mrNote/verify", function() use ($app) {
		        try{
		            $key_api=$app->getCookie("IS_AUTHORIZED");
		            if(isset($key_api)) {
		                $conection=new Conection();
		                $conection->startConection();
		                $password = $conection->cipherFlow($app->request->post('pass'));
		                $sql = $conection->getConection()->prepare('SELECT private_key FROM users WHERE password=?');
		                $sql->bindParam(1, $password);
		                $field = $app->request->post('field');
		                if($field == 'password') {
		                	$value_field = $conection->cipherFlow($app->request->post('value_field'));
		                } else {
		                	$value_field = $app->request->post('value_field');
		                }
		                $sql = $conection->getConection()->prepare('SELECT private_key FROM users WHERE '.$field.'=?');
		                $sql->bindParam(1, $value_field);
		                $sql->execute();
		                $response = $sql->fetch(\PDO::FETCH_ASSOC);
		                if(isset($response)) {
		                    $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode($response));
		                } else {
		                    $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode(array("response"=>false)));
		                }
		                $conection->stopConection();
		            } else {
		                $app->response->headers->set("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
		            }
		        } catch(\PDOException $e) {
		            print "Error: Internal Service Error ".$e;
		        }
		    });

		    $app->post("/mrNote/getUser", function() use ($app) {
		        try{
		            $key_api=$app->getCookie("IS_AUTHORIZED");
		            if(isset($key_api)) {
		                $conection=new Conection();
		                $conection->startConection();
		                $email = $app->request->post('email');
		                $sql = $conection->getConection()->prepare('SELECT user, email, private_key FROM users WHERE email=?');
		                $sql->bindParam(1, $email);
		                $sql->execute();
		                $response = $sql->fetch(\PDO::FETCH_ASSOC);
		                if(isset($response)) {
		                    $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode($response));
		                } else {
		                    $app->response->headers->set("Access-Control-Allow-Origin", $conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode(array("response"=>false)));
		                }
		                $conection->stopConection();
		            } else {
		                $app->response->headers->set("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
		            }
		        } catch(\PDOException $e) {
		            print "Error: Internal Service Error ".$e;
		        }
		    });

		    $app->post("/mrNote/login", function() use ($app){
		        try{
		            $key_api=$app->getCookie("IS_AUTHORIZED");
		            if(isset($key_api)){
		                $conection=new Conection();
		                $conection->startConection();
		                $user = $app->request->post('email');
		                $pass = $conection->cipherText($app->request->post('password'),$app->request->post('private_key'));
		                $sql = $conection->getConection()->prepare('SELECT id,user,email,private_key,avatar,id_rol FROM users WHERE email=? AND password=?');
		                $sql->bindParam(1,$user);
		                $sql->bindParam(2,$pass);
		                $sql->execute();
		                $response = $sql->fetch(\PDO::FETCH_ASSOC);
		                if(isset($response)){
		                    $app->response->headers->set("Access-Control-Allow-Origin",$conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode($response));
		                }else{
		                    $app->response->headers->set("Access-Control-Allow-Origin",$conection->getAttribute("domain"));
		                    $app->response->headers->set("Content-type", "application/json");
		                    $app->response->status(200);
		                    $app->response->body(json_encode(array("response"=>false)));
		                }
		                $conection = null;
		            }else{
		                $app->response->headers->set("Access-Control-Allow-Origin",$_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
		            }

		        } catch(PDOException $e) {
		            print "Error: Internal Service Error ".$e;
		        }
		    });

		     $app->get("/mrNote/lId/:table", function($table) use ($app) {
		    	try{
		    		$key_api=$app->getCookie("IS_AUTHORIZED");
		    		if(isset($key_api)) {
			            $conection=new Conection();
		                $conection->startConection();
			            $sql = $conection->getConection()->prepare('SELECT MAX(id) as id FROM '.$table);
						$sql->execute();
						$data = $sql->fetch(\PDO::FETCH_ASSOC);
						if($data) {
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode($data));
						} else {
							$app->response->headers->set("Content-type", "application/json");
		            		$app->response->status(200);
							$app->response->body(json_encode(array('response'=>false)));
						}
						$conection->stopConection();
					} else {
		                $app->response->headers->set("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN']);
		                $app->response->headers->set("Content-type", "application/json");
		                $app->response->status(200);
		                $app->response->body(json_encode(array("response"=>false)));
		            }
				} catch(\PDOException $e) {
					print "Error: Internal Service Error ".$e;
				}
		    });
		}
	}
 ?>