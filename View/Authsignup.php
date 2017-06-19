<html>
<body>
	<?php $form = new Form(); ?>
	<div class="sign-pages">
	<h1>Sign up</h1><br>
	<form method="post" action="<?= Routeur::redirect('authsignup/signUp'); ?>">
	    <?= $form->input('login', 'Login'); ?>
	    <?= $form->input('email', 'Email address'); ?>
	    <?= $form->input('password', 'Password', ['type' => 'password']); ?>
	    <?= $form->input('password2', 'Password confirmation', ['type' => 'password']); ?>
	    <?= $form->submit('signup', 'Submit', 'btn btn-primary'); ?>
	</form>

	<hr>
	<p>Already have an account? <a href='http://localhost:<?= PORT ?>/<?= Routeur::$url['dir']; ?>/authsignin/SignIn/'>Sign in</a></p>
	</div>
</body>
</html>
