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
			$this->plain_text = '';
			$this->html = '';
			$this->last_access = date ('Y/n/j');
			$this->private = 0;
		}
		public function createNote(){
			$data = array('id_note'=>'','name'=>$this->name,'plain_text'=>$this->plain_text,'html'=>$this->html,'last_access'=>$this->last_access,'private'=>$this->private);
				$response = $this->crud->sendPost(API_SITE.'create/notes',$data);
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
		public function goTo($uri){
			$this->crud->go($uri);
		}
		public function updateDate($name){
			$data=array('field'=>$this->field,'value_field'=>$this->value_field,'condition'=>$this->condition,'value_condition'=>$name);
			$response =  $this->crud->sendPost(API_SITE.'update/notes',$data);
			return $response;
		}
	}
 ?>