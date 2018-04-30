<?php namespace config;
	
	class Request{
		protected $controller;
		protected $method;
		protected $arguments;

		public function __construct(){
			if(isset($_GET['url'])){
				$url=filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL);
				$url=explode("/",$url);
				$url=array_filter($url);
				$this->controller=array_shift($url);
				if(!$this->controller){
					$this->controller="Public";
				}
				$this->method=array_shift($url);
				if(!$this->method){
					$this->method="index";
				}
				$this->arguments=$url;
			}else{
				$this->controller="Public";
				$this->method="index";
			}
		}

		public function getController(){
			return $this->controller;
		}

		public function getMethod(){
			return $this->method;
		}
		public function getArguments(){
			return $this->arguments;
		}
	}

 ?>