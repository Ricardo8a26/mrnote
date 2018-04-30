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
		public function createNote($name=null){
			if ($name == null) {
				if ($_POST) {
					$hash = $this->note->encryptName($_POST['name']);
					$this->note->setAttr('name',$hash);
					$response = json_decode($this->note->createNote());
					if($response->response){
						if(isset($_POST['password'])){
							$liid = json_decode($this->crud->sendGet(API_SITE.'lId/notes'))->id_note;
							$this->note->setAttr('id_note',$liid);
							$this->note->setAttr('password',$_POST['password']);
							$response = json_decode($this->note->createPassword());
						}
						$liid = json_decode($this->crud->sendGet(API_SITE.'lId/notes'))->id_note;
						$this->note->setAttr('id_note',$liid);
						$response = json_decode($this->note->createText());
						if($response->response){
							$response = json_decode($this->note->createHtml());
							if($response->response){
								$this->note->goTo('Public/note/'.$_POST['name']);
								echo '<div class="response_true">Se ha creado una nueva nota.</div>';
							}
						}
					}else{
						echo '<div class="response_false">Lo sentimos, ha ocurrido un error.</div>';
					}
				}
			} else {
				$hash = $this->note->encryptName($name);
				$this->note->setAttr('name',$hash);
				$response = json_decode($this->note->createNote());
				if($response->response){
						$liid = json_decode($this->crud->sendGet(API_SITE.'lId/notes'))->id_note;
						$this->note->setAttr('id_note',$liid);
						$response = json_decode($this->note->createText());
						if($response->response){
							$response = json_decode($this->note->createHtml());
							if($response->response){
								$this->note->goTo('Public/note/'.$name);
								echo '<div class="response_true">Se ha creado una nueva nota.</div>';
							}
						}
					}else{
					echo '<div class="response_false">Lo sentimos, ha ocurrido un error.</div>';
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
				$this->note->setAttr('condition','id_note');
				$this->note->setAttr('value_condition',$response['data']->id_note);
				$response['text'] = json_decode($this->note->getText());
				$response['html'] = json_decode($this->note->getHtml());
				return $response;
			}
		}
		public function updateNoteText($name){
			$hash = $this->note->encryptName($name);
		}
		public function updateNoteHtml($name){
			$hash = $this->note->encryptName($name);
		}
		public function viewNote($name=null){
			if ($name == null) {
				$this->note->goTo('Public/index');
			} else {
				$response['name'] = $name;
				$hash = $this->note->encryptName($name);
				$this->note->setAttr('condition','name');
				$this->note->setAttr('value_condition',$hash);
				$response['data'] = json_decode($this->note->getNote());
				$this->note->setAttr('condition','id_note');
				$this->note->setAttr('value_condition',$response['data']->id_note);
				$response['html'] = json_decode($this->note->getHtml());
				return $response;
			}
		}
	}
 ?>
