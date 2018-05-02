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
					if(isset($_POST['password'])){
						$this->note->setAttr('private',1);
					}else{
						$this->note->setAttr('private',0);
					}
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
			}else if(isset($_POST['text'])){
				$this->note->setAttr('field','plain_text');
				$this->note->setAttr('value_field',$_POST['text_note']);
				$this->note->setAttr('condition','id_note');
				$response['update_text'] = json_decode($this->note->updateText($response['data']->id_note));
				if($response['update_text']->response){
					$this->note->goTo('Public/note/'.$name);
				} else {
					echo '<div class="response_false">Algo anda mal, intenta de nuevo por favor.</div>';
				}
			}else if(isset($_POST['html'])){
				$this->note->setAttr('field','html');
				$this->note->setAttr('value_field',$_POST['html_note']);
				$this->note->setAttr('condition','id_note');
				$response['update_html'] = json_decode($this->note->updateHtml($response['data']->id_note));
				if($response['update_html']->response){
					$this->note->goTo('Public/note/'.$name);
				} else {
					echo '<div class="response_false">Algo anda mal, intenta de nuevo por favor.</div>';
				}
			}else{
				$this->note->setAttr('field','last_access');
				$this->note->setAttr('value_field',$this->date);
				$this->note->setAttr('condition','name');
				$response['last_access'] = json_decode($this->note->updateDate($hash));
				$this->note->setAttr('condition','id_note');
				$this->note->setAttr('value_condition',$response['data']->id_note);
				$response['text'] = json_decode($this->note->getText());
				$response['html'] = json_decode($this->note->getHtml());
			}
			return $response;
		}
		public function updateNoteText($name){
			if ($name == null) {
				$this->note->goTo('Public/index');
			} else {
				$hash = $this->note->encryptName($name);
				$this->note->setAttr('field','last_access');
				$this->note->setAttr('value_field',$this->date);
				$this->note->setAttr('condition','name');
				$response = json_decode($this->note->updateDate($hash));
			}
		}
		public function updateNoteHtml($name){
			if ($name == null) {
				$this->note->goTo('Public/index');
			} else {
				$hash = $this->note->encryptName($name);

			}
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
		public function pwrequest(){
			
		}
	}
 ?>
