<?php namespace views\layouts;
	$obj_default=new DefaultLayout();
	class DefaultLayout{
		public function __construct(){
			?>
			<!DOCTYPE html>
			<html lang="es">
				<head>
					<meta charset="utf-8">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>views/assets/css/material.min.css"/>
					<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>views/assets/css/style.css">
					<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>views/assets/css/medias.css">
					<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
					<script type="text/javascript" src="<?php echo URL; ?>views/assets/js/material.min.js"></script>
					<script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
					<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL; ?>views/assets/img/platform/favicon.ico">
					<script src="<?php echo URL; ?>views/assets/js/main.js" type="text/javascript" charset="utf-8" async defer></script>
					<title>Mr. Note</title>
				</head>
				<body>
					<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
				  		<header class="mdl-layout__header">
				    		<div class="mdl-layout__header-row">
				      			<span class="mdl-layout-title"><a class="index" href="<?php echo URL; ?>">Mr. Note</a></span>
							</div>
				  		</header>
				  		<main class="mdl-layout__content">
			<?php
		}
		public function __destruct(){
			?>
			  			</main>
			  			<footer class="mdl-mini-footer">
						  	<div class="mdl-mini-footer__left-section">
						    	<div class="mdl-logo">Mr. Note</div>
					    		<ul class="mdl-mini-footer__link-list">
					      			<li><a class="mrnote_footer_link" href="#">Ayuda</a></li>
					      			<li><a class="mrnote_footer_link" href="#">Terminos y condiciones</a></li>
					      			<li><a class="mrnote_footer_link" href="#">Politica de privacidad</a></li>
					    		</ul>
						  	</div>
						</footer>
			<?php
		}
	}
?>
