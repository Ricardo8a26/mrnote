<?php namespace controllers;
	use models\CRUD as crud;
	use models\Note as note;
	class PublicController {
		protected $note;
		protected $flag;
		protected $date;
		public function __construct() {
			$this->crud = new CRUD();
			$this->note = new Note();
			$this->flag = false;
			$this->date = date ('Y/n/j');
		}
		public function createNote($name){
			$hash = $this->note->encryptName($name);
			if ($_POST) {
				
			} else {
				$this->note->setAttr('name',$hash);
				$response = json_decode($this->note->createNote());
				if($response->response){
					echo '<div class="response_true">Se ha creado una nueva nota</div>';
				}else{
					echo '<div class="response_false">Lo sentimos, ha ocurrido un error</div>';
				}
			}

		}
		public function index($name=null){
			if ($name == null) {

			} else {
				$this->note->goTo('Public/note/'.$name);
			}
		}
		public function note($name){
			$hash = $this->note->encryptName($name);
			$this->note->setAttr('condition','name');
			$this->note->setAttr('value_condition',$hash);
			$response['data'] = json_decode($this->note->getNote());
			$response['name'] = $name;
			if (isset($response['data']->response)) {
				$this->note->goTo('Public/createNote/'.$name);
			} else {
				$this->note->setAttr('field','last_access');
				$this->note->setAttr('value_field',$this->date);
				$this->note->setAttr('condition','name');
				$response['last_access'] = json_decode($this->note->updateDate($hash));
				return $response;
			}
		}

	}
 ?>