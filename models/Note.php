<?php namespace models;
	use models\CRUD as crud;
	class Admin{
		protected $crud;
		protected $id_note;
		protected $name;
		protected $plain_text;
		protected $html;
		protected $last_access;
		protected $private;
		protected $;
		protected $;
		protected $condition;
		protected $value_condition;
		public function __construct(){
			$this->crud = new CRUD();
		}
		public function addAdmin(){
			$url = 'views'.DS.'assets'.DS.'img'.DS.'admins'.DS.'admin_'.sha1($this->user).'.png';
			if(move_uploaded_file($this->avatar['tmp_name'], $url)){
				$this->key = $this->crud->generateKey($this->email);
				$data = array('id_admin'=>'','user'=>$this->user,'email'=>$this->email,'private_key'=>$this->key,'password'=>$this->crud->cipherText($this->password,$this->key)[0],'avatar'=>$url,'id_rol'=>$this->rol);
				$response = $this->crud->sendPost(API_ADMIN.'create/admins',$data);
			}else{
				$response = json_encode(array('response'=>'file upload failed'));
			}
			return $response;
		}
		public function setAttr($attr,$val){
			$this->$attr = $val;
		}
		public function getAttr($attr){
			return $this->$attr;
		}
		public function getAdmins(){
			$response = $this->crud->sendGet(API_ADMIN.'admins');
			return $response;
		}
		public function getAdminByCondition(){
			$response = $this->crud->sendGet(API_ADMIN.'admins/'.$this->condition.'/'.$this->value_condition);
			return $response;
		}
		public function getUser(){
			$response = $this->crud->sendPost(API_ADMIN.'getUser',array('user'=>$this->user));
			return $response;
		}
		public function updateAdmin(){
			$url = 'views'.DS.'assets'.DS.'img'.DS.'admins'.DS.$this->avatar;
			if(move_uploaded_file($this->blob['tmp_name'],$url)){
				$response = $this->crud->sendPost(API_ADMIN.'update/admins',array('field'=>'avatar','value_field' => $url,'condition' => $this->condition, 'value_condition'  => $this->value_condition));
				return $response;
			}else{
				return json_encode(array('response'=>false));
			}
		}
		public function goTo($uri){
			$this->crud->go($uri);
		}
	}
 ?>