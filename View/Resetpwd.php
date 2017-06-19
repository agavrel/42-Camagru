<?php $form = new Form(); ?>
<div class="sign-pages">
<h1>Reset your password</h1><br>
<?php if (isset($email_sent)) echo $email_sent; ?>
<?php if (isset($invalid_email)) echo $invalid_email; ?>

<form method="post", action="<?= Routeur::redirect('resetpwd/sendEmail'); ?>">
	<?= $form->input('email', 'Email address'); ?>
	<?= $form->submit('signup', 'Submit', 'btn btn-primary'); ?>
</form>
</div>
