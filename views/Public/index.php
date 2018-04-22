<div class="page-content mdl-grid">
	<div class="mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
		<div class="mrnote_new">
			<h1>Bienvenido a Mr. Note</h1>
			<h3>Crear una nueva nota</h3>
			<form class="mrnote_note" action="<?php echo URL; ?>Public/createNote" method="POST">
				<input class="mrnote_input" type="text" name="name" id="name" placeholder="Nombre de nueva nota" required>
				<br>
				<br>
				<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="mrnote_check_password">
				  	<input type="checkbox" id="mrnote_check_password" name="mrnote_check_password" class="mdl-checkbox__input">
				  	<span class="mdl-checkbox__label">¿Desea proteger con contraseña?</span>
				</label>
				<br>
				<div class="mrnote_password mrnote_hide" id="mrnote_password" name="mrnote_password">
					<br>
					<input class="mrnote_input" type="password" name="mrnote_enter_password" id="mrnote_enter_password" minlength="6" placeholder="Ingrese su contraseña">
					<br>
					<br>
					<input class="mrnote_input" type="password" name="mrnote_confirm_password" id="mrnote_confirm_password" minlength="6" placeholder="Repita la contraseña">
					<br>
					<span class="mrnote_alert_password">No olvides tu contraseña ya que no podra ser restablecida.</span>
				</div>
				<br>
				<button class="mrnote_new_note mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
				Crear nota
				</button>
			</form>
		</div>
	</div>
	<div class="mdl-cell--6-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone mrnote_logo_container">
		<img class="mrnote_logo" src="<?php echo URL; ?>views/assets/img/platform/mrnote.jpeg">
	</div>
</div>