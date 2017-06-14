<?php $form = new Form(); ?>
<div class="sign-pages">
<h3>Reset your password</h3><br>

<?php if (isset($email_sent)) echo $email_sent; ?>
<?php if (isset($invalid_email)) echo $invalid_email; ?>

<form method="post", action="<?= Routeur::redirect('resetpwd/sendEmail'); ?>">
	<?= $form->input('email', 'Email address'); ?>
	<?= $form->submit('signup', 'Submit', 'btn btn-primary'); ?>
</form>
</div>