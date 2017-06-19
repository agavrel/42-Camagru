<?php $form = new Form(); ?>
<div class="sign-pages">
<h1>Change Password</h1><br>
<?php if (isset($invalid_password_confirmation)) { echo $invalid_password_confirmation; } ?>
<?php if (isset($password_changed)) { echo $password_changed; } ?>
<?php if (isset($wrong_link)) { echo $wrong_link; } ?>

<form method="post" action="<?= Routeur::redirect('Changepwd/updatePwd') . '/' . Routeur::$url['params'][0] . '/' . Routeur::$url['params'][1]; ?>">
	<?= $form->input('password', 'New password', ['type' => 'password']); ?>
	<?= $form->input('password2', 'New password confirmation', ['type' => 'password']); ?>
	<?= $form->submit('reset', 'Reset', 'btn btn-primary'); ?>
</form>
</div>
