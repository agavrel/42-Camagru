<head>
	<link href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/public/css/style.css" rel="stylesheet">
	<script>document.title = "Camagru - Reset Password";</script>
</head>
<div class='alert alert-success fadein' id="save-success"></div>
<?php

class ControllerResetpwd extends Controller
{

	public function view()
	{

	}

	public function sendEmail()
	{
		$email = htmlspecialchars($_POST['email']);
		if (isset($email) && !empty($email))
		{
			$condition = array('email' => '?');
			$attribute = array($email);
			$req = self::$sel->query_select('*', 'users', $condition, true, null, null, $attribute);
			if (isset($req) && !empty($req))
			{
				$emailFrom = 'no-reply@camagru.com';
				$subject = "Camagru - Reset your password";
				$message = '<html>Hi ' . ucfirst($req['login']) . '</br></br>To reset your password, click on the link below:</br></br>http://localhost:' . PORT . '/' . Routeur::$url['dir'] . '/Changepwd/view/' . $req['password'] . '/' . $req['id'] . '</br></br>Kind regards,</br></br>Team Camagru</html>';
				$headers = "From: " . $emailFrom . "\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				mail($email, $subject, $message);
				echo '<script type="text/javascript">messageAnimation("An email has been sent", 2000); window.location.href = "../Changepwd/view/' . $req['password'] . '/' . $req['id'].'"</script>';
			}
			else
				echo '<script type="text/javascript">messageAnimation("Email address does not exist", 2000);</script>';
		}
	}
}
?>
<script type="text/javascript" src="../public/js/misc.js"></script>
