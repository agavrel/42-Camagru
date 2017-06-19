<?php $form = new Form($_POST); ?>
<div class="sign-pages">
<h1>Sign in</h1><br>

<form method="post" action="<?= Routeur::redirect("Authsignin/signin"); ?>">
    <?= $form->input('login', 'Login'); ?>
    <?= $form->input('password', 'Password', ['type' => 'password']); ?>
    <?= $form->submit('sign_in', 'Login', 'btn btn-primary'); ?>
</form>

<hr>
<span>Don't have an account yet? <a href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/authsignup/View/" class="gold">Sign up !</a></span>
<br>
<a href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/Resetpwd/View/" style="text-align: right;" class="gold">Forgot password?</a>
<div>
