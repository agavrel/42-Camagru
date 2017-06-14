<?php $form = new Form($_POST); ?>
<div class="sign-pages">
<h3>Sign in</h3><br>
<?php
	if (isset($wrong_pwd))
		echo $wrong_pwd;
	if (isset($wrong_log))
		echo $wrong_log;
	if (isset($no_access))
		echo $no_access;
	if (isset($alert_disconnected))
		echo $alert_disconnected;
	if (isset($email_not_confirmed))
		echo $email_not_confirmed;
?>
<form method="post" action="<?= Routeur::redirect("Authsignin/signin"); ?>">
    <?= $form->input('login', 'Login'); ?>
    <?= $form->input('password', 'Password', ['type' => 'password']); ?> 
    <?= $form->submit('sign_in', 'Login', 'btn btn-primary'); ?>
</form>

<hr>
<span>Don't have an account yet? <a href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/authsignup/View/">Sign up</a></span>
<br>
<a href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/Resetpwd/View/" style="text-align: right;">Forgot password?</a>
<div>