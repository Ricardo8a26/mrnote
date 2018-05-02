<?php namespace models;
	use models\CRUD as crud;
	class Note{
		protected $crud;
		protected $id_note;
		protected $name;
		protected $plain_text;
		protected $html;
		protected $last_access;
		protected $private;
		protected $password;
		protected $private_key;
		protected $condition;
		protected $value_condition;
		protected $field;
		protected $value_field;
		public function __construct(){
			$this->crud = new CRUD();
			$this->last_access = date ('Y/n/j');
			$this->private = 0;
		}
		public function createNote(){
			$data = array('id_note'=>'null','name'=>$this->name,'last_access'=>$this->last_access,'private'=>$this->private);
				$response = $this->crud->sendPost(API_SITE.'create/notes',$data);
			return $response;
		}
		public function createText(){
			$data = array('id'=>'','id_note'=>$this->id_note,'plain_text'=>'');
			$response = $this->crud->sendPost(API_SITE.'create/notes_text',$data);
			return $response;
		}
		public function createHtml(){
			$data = array('id'=>'','id_note'=>$this->id_note,'html'=>'');
			$response = $this->crud->sendPost(API_SITE.'create/notes_html',$data);
			return $response;
		}
		public function createPassword(){			
			$this->private_key = $this->crud->generateKey($this->name);
			$data = array('id_pass'=>'','id_note'=>$this->id_note,'private_key'=>$this->private_key,'password'=>$this->crud->cipherText($this->password,$this->private_key));
			$response = $this->crud->sendPost(API_SITE.'create/passwords',$data);
			return $response;
		}
		public function encryptName($name){
			$hash = sha1(md5($name));
			return $hash;
		}
		public function setAttr($attr,$val){
			$this->$attr = $val;
		}
		public function getAttr($attr){
			return $this->$attr;
		}
		public function getNote(){
			$response = $this->crud->sendGet(API_SITE.'notes/'.$this->condition.'/'.$this->value_condition);
			return $response;
		}
		public function getText(){
			$response = $this->crud->sendGet(API_SITE.'notes_text/'.$this->condition.'/'.$this->value_condition);
			return $response;
		}
		public function getHtml(){
			$response = $this->crud->sendGet(API_SITE.'notes_html/'.$this->condition.'/'.$this->value_condition);
			return $response;
		}
		public function goTo($uri){
			$this->crud->go($uri);
		}
		public function login(){
			$key = json_decode($this->crud->sendPost(API_SITE.'getUser',array('id_note' => $this->id_note)));
			$this->private_key=$key->private_key;
			$data = array('email'=>$this->email,'password'=>$this->password,'private_key'=>$this->private_key);
			$response = $this->crud->sendPost(API_ADMIN.'login',$data);
			return $response;
		}
		public function updateDate($name){
			$data=array('field'=>$this->field,'value_field'=>$this->value_field,'condition'=>$this->condition,'value_condition'=>$name);
			$response =  $this->crud->sendPost(API_SITE.'update/notes',$data);
			return $response;
		}
		public function updateText($id_note){
			$data=array('field'=>$this->field,'value_field'=>$this->value_field,'condition'=>$this->condition,'value_condition'=>$id_note);
			$response =  $this->crud->sendPost(API_SITE.'update/notes_text',$data);
			return $response;
		}
		public function updateHtml($id_note){
			$data=array('field'=>$this->field,'value_field'=>$this->value_field,'condition'=>$this->condition,'value_condition'=>$id_note);
			$response =  $this->crud->sendPost(API_SITE.'update/notes_html',$data);
			return $response;
		}
	}
 ?>