<?php namespace app\library;
	/*init the class conection*/
	class Conection {
		/*abstract variables type of protected by the conexion*/
		protected $user="";
		protected $password="";
		protected $passwordnotes="";
		protected $server="";
		protected $dbname="";
		protected $conection="";
		protected $domain="";
		/*constructor*/
		public function __construct() {
			$this->user="usermrnote";
			$this->password="F8rNw5k18k4jcLFf";
			$this->server="localhost";
			$this->dbname="mrnote";	
			$this->domain="https://www.mrnote.com";
			$this->passwordnotes='MrN0t3P4s5W0rD';
			//$this->user="id2392226_user";
			//$this->password="mscrump";
			//$this->server="localhost";
			//$this->dbname="id2392226_scrum";	
			//$this->domain="http://mrnote.000webhostapp.com";
			$this->key_domain="a813d7a3a0591cc18223d906dcdf95d10983d2c0550a0d0d690a54ec8026b54cff080e63";
		}
		public function authDomain($domain,$key) {
			return $this->domain===$domain&&$this->key_domain===$key;
		}
		/*this function serve to set new values to attributes of this class
		the fisrt parameter is the name of attribute that will be modified
		and the second is the value that will be assigned*/
		public function setAttribute($attr,$value){ 
			$this->$attr=$value;
		}
		public function getAttribute($attr) {
			return $this->$attr;
		}
		public function getConection() {
			return $this->conection;
		}
		/*the function getConexion return the currently conexion*/
		public function startConection() {
			/*this action is into an exception, because some times the server fail
			and we need know when that success*/
			try {
				$this->conection=new \PDO("mysql:host=".$this->server.";dbname=".$this->dbname, $this->user, $this->password);
				$this->conection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			} catch(\PDOException $e) {
					//show a wrong message
					print "Error: ".$e->getMessage();
			}
			return $this->conection;
		}
		/*the function stopConextion the currently conexion*/
		public function stopConection() {
			$this->conection=null;
		}
		public function __clone() {
        	return false;
    	}
    	/*this function use the plain text and the private key to bits level for cipher the passwords*/
		public function cipherFlow($flow){
			return sha1(md5($flow));
		}
		public function cipherText($plain_text,$private_key){
			//variables to join the bits flows
			$concat="";
			$concat_key="";
			/*this will become to ASCCI from the plain text and the ASCCI codes to a bits flow*/
			for($i=0;$i<strlen($plain_text);$i++){
				$ascci[$i]=ord($plain_text[$i]);
				$bin[$i]=decbin($ascci[$i]);
				$concat=$concat.$bin[$i];
			}
			/*this will become to ASCCI from the private key and the ASCCI codes to a bits flow*/
			for($i=0;$i<strlen($private_key);$i++){
				$ascci_key[$i]=ord($private_key[$i]);
				$bin_key[$i]=decbin($ascci_key[$i]);
				$concat_key=$concat_key.$bin_key[$i];
			}
			/*equalize the lengths from bits flows with ceros to left*/
			if(strlen($concat)<strlen($concat_key)){
				while (strlen($concat) < strlen($concat_key)) {
				$concat="0".$concat;
				}
			}
			else{
				while (strlen($concat_key) < strlen($concat)) {
				$concat_key="0".$concat_key;
				}
			}
			/*if the legth of the flows is equal, it'll do an operation or exclusive*/
			if(strlen($concat)===strlen($concat_key)){
				$final_flow="";
				for($i=0;$i<strlen($concat);$i++){
					if($concat[$i]==="1" || $concat_key[$i]==="1"){
						$final_flow=$final_flow."1";
					}
					else{
						$final_flow=$final_flow."0";
					}	
				}
			}
			//at last returned the cipher flow with md5 and sha1
			return sha1(md5($final_flow));
		}
		/*the function generateKey serves to create new keys for new domains and users of the  API*/
		public function generateKey($root){
			/*this takes some characteres from the string src of random way in base of the root size*/
			$src="aH☺°e⌂A1C♀|Bh!#■$%O%&☻ke`d¬sN|d♥k7/m*-sE▬k$%x~¨hI@#&c♀d0/Os°l!@(?¡)¿¡K!?e_<♀→{-Y}>♀⌂_p:,R;.I_-ñv▒0Av╝eÃr«t░»*3E/l┤½oa®d▓ºeúÉdó+⌂sƒ5s×4dØ5s£cÿdÜ5ÖùÿFûGîHæZòIÅKôLæÅMä0çPåqïdëd0gêd";
			$this->private_key=$root;
			$key=substr($src, rand(0,strlen($root)-1),strlen($root));
			//variables to join the flows bits
			$concat="";
			$concat_key="";
			/*this will become to ASCCI from the root and the ASCCI codes to a bits flow*/
			for($i=0;$i<strlen($this->private_key);$i++){
				$ascci[$i]=ord($this->private_key[$i]);
				$bin[$i]=decbin($ascci[$i]);
				$concat=$concat.$bin[$i];
			}
			/*this will become to ASCCI from the temporal key and the ASCCI codes to a bits flow*/
			for($i=0;$i<strlen($key);$i++){
				$ascci_key[$i]=ord($key[$i]);
				$bin_key[$i]=decbin($ascci_key[$i]);
				$concat_key=$concat_key.$bin_key[$i];
			}
			/*equalize the lengths from bits flows with ceros to left*/
			if(strlen($concat)<strlen($concat_key)){
				while (strlen($concat) < strlen($concat_key)) {
				$concat="0".$concat;
				}
			}
			else{
				while (strlen($concat_key) < strlen($concat)) {
				$concat_key="0".$concat_key;
				}
			}
			/*if the legth of the flows is equal, it'll do an operation or exclusive*/
			if(strlen($concat)===strlen($concat_key)){
				$final_flow="";
				for($i=0;$i<strlen($concat);$i++){
					if($concat[$i]==="1" || $concat_key[$i]==="1"){
						$final_flow=$final_flow."1";
					}
					else{
						$final_flow=$final_flow."0";
					}	
				}
			}
			//at last return the cipher flow with md5 and sha1
			return sha1(md5($final_flow));
		}//end of the generateKeys method
		
	}//end of the Conexion class	
 ?>