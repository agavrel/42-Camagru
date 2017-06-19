<html>
<body>
<?php $form = new Form(); ?>
<div class="sign-pages">
<h1>Change Password</h1><br>

<form method="post" action="<?= Routeur::redirect('Changepwd/updatePwd') . '/' . Routeur::$url['params'][0] . '/' . Routeur::$url['params'][1]; ?>">
	<?= $form->input('password', 'New password', ['type' => 'password']); ?>
	<?= $form->input('password2', 'New password confirmation', ['type' => 'password']); ?>
	<?= $form->submit('reset', 'Reset', 'btn btn-primary'); ?>
</form>
</div>
</body>
</html>
