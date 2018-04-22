<?php namespace app\library;
	/*init the class conection*/
	class Conection{
		/*abstract variables type of protected by the conexion*/
		protected $user="";
		protected $pwd="";
		protected $server;
		protected $dbname;
		protected $conection;
		protected $domain;
		
		/*constructor*/
		public function __construct(){
			$this->user="usermrnote";
			$this->pwd="F8rNw5k18k4jcLFf";
			$this->server="localhost";
			$this->dbname="mrnote";	
			$this->domain="http://www.mrnote.tcd";
			$this->key_domain="4c497c6ef2f4de9952509635b57e7b13a83bbb72b6158550cba5301a4af8c947b0f49c83";
		}
		public function authDomain($domain,$key){
			return $this->domain===$domain&&$this->key_domain===$key;
		}
		/*this function serve to set new values to attributes of this class
		the fisrt parameter is the name of attribute that will be modified
		and the second is the value that will be assigned*/
		public function setAttribute($attr,$value){
			$this->$attr=$value;
		}
		public function getAttribute($attr){
			return $this->$attr;
		}
		public function getConection(){
			return $this->conection;
		}
		/*the function getConexion return the currently conexion*/
		public function startConection(){
			/*this action is into an exception, because some times the server fail
			and we need know when that success*/
			try{
				$this->conection=new \PDO("mysql:host=".$this->server.";dbname=".$this->dbname, $this->user, $this->pwd);
				$this->conection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			}catch(\PDOException $e){
					//show a wrong message
					print "Error: ".$e->getMessage();
			}
			return $this->conection;
		}
		/*the function stopConextion the currently conexion*/
		public function stopConection(){
			$this->conection=null;
		}
	}//end of the Conexion class	
 ?>
