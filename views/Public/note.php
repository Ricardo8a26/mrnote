<!DOCTYPE html>
<html>
<head>
	<title><?php echo $data['name']; ?></title>
</head>
<body>
	<?php echo $data['name']; ?>
	<br>
	<?php echo $data['data']->name; ?>
	<br>
	<?php echo $data['data']->plain_text; ?>
	<br>
	<?php echo $data['data']->html; ?>
	<br>
	<?php echo $data['data']->last_access; ?>
	<br>
	<?php echo $data['data']->private; ?>
	<br>
</body>
</html>






