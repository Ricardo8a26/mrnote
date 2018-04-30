<div class="note-container">
	<div class="view_html">
		<div class="name_note"><?php echo $data['name']; ?></div>
		<div class="html_content">
			<div class="html_code">
				<?php echo $data['html']->html; ?>
			</div>
		</div>
		<a class="mdl-button" href="<?php echo URL; ?>Public/note/<?php echo $data['name']; ?>">Regresar</a>
	</div>
</div>