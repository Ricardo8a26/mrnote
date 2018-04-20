<?php namespace controllers;
	use models\CRUD as crud;
	use models\Admin as admin;
	class AdminController{
		protected $admin;
		public function __construct(){
			$this->crud = new CRUD();
			$this->admin = new Admin();
		}
		public function index(){
			//print_r($this->admin->crud);
			if($_POST){
				$_SESSION['data'] = $_POST;
				//$this->admin->goTo('Admin/home');
				echo json_encode(array('response'=>true));
			}
		}
		public function logOut(){
			if(isset($_SESSION['data'])){
				session_destroy();
				$this->admin->goTo('Admin');
			}
		}
		public function updateSession($attr,$val){ 
			if(isset($_SESSION['data']['rol'])&&$_SESSION['data']['rol']=='1'){
				if($attr == 'request'){
					$_SESSION['request'] = $_SESSION['request']+($val);
				}else{
					$_SESSION['data'][$attr] = $val;
				}
			}else{
				$this->admin->goTo('Admin/home');
			}
		}
	}
 ?>