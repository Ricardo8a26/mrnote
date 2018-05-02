<div class="page-content mdl-grid">
	<div class="mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
		<div class="pw_request">
			<div class="name_note">Ingrese la contraseña para acceder a:<?php echo ' '.$data['name']; ?></div>
			<form class="mrnote_note" action="<?php echo URL; ?>Public/pwRequest/<?php echo $data['name']; ?>" method="POST">
		    	<input class="mrnote_input" type="password" name="password" id="password" minlength="4" title="Debe contener al menos 4 carácteres" placeholder="Ingrese su contraseña">
		    	<button class="mrnote_pw_note mdl-button mdl-js-button mdl-button--raised mdl-button--colored" name="submit" id="submit" type="submit">
					Ingresar
				</button>
			</form>
    	</div>
    </div>
</div>
