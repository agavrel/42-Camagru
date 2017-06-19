<head>
	<link href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/public/css/style.css" rel="stylesheet">
</head>
<div class='alert alert-success fadein' id="save-success"></div>
<?php

class ControllerAuthsignup extends Controller
{
	public function view()
	{

	}

	public function signUp()
	{
		if ($_POST['signup'] === 'Submit' && $_POST['password'] === $_POST['password2'])
		{
			if (!isset($errors['password']) && !preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $_POST['password']))
			{
				echo '<script type="text/javascript">', 'messageAnimation("Unsecured Password, Please use at combination of lowercase, uppercase letters and digits with special character");', '</script>';
				return ;
			}
			$check = $this->checker($_POST);
			if (!preg_match('/[a-z0-9]+@[a-z0-9]+[.][a-z]+/', $_POST['email']))
				echo '<script type="text/javascript">', 'messageAnimation("Invalid email");', '</script>';
			else if ($check === false)
			{
				$insert = $this->call_model('insert');
				$values = array(
									'id' 				=>	'null',
									'login' 			=>	'?',
									'email'				=>	'?',
									'password'			=>	'?',
									'email_confirmed' 	=>	"'no'",
									'admin'				=>	"'no'"
								);
			$password = hash('whirlpool', $_POST['password']);
				$attributes = array(
										$_POST['login'],
										$_POST['email'],
										$password
									);
				$insert->insert_value('users', $values, $attributes);
				$this->sendEmail($_POST);
				echo '<script type="text/javascript">', 'messageAnimation("An email has been sent to you");', '</script>';
			}
			else
			{
				if ($check['login'] === $_POST['login'])
					echo '<script type="text/javascript">', 'messageAnimation("Login already used");', '</script>';
				else
					echo '<script type="text/javascript">', 'messageAnimation("Email already used");', '</script>';
			}
		}
		else
			echo '<script type="text/javascript">', 'messageAnimation("Invalid password confirmation");', '</script>';
	}

	private function checker($posts)
	{
		$sel = $this->call_model('select');
		$condition = array(
								"login" => "?",
								"email" => "?"
							);
		$attributes = array(
							$posts['login'],
							$posts['email']
							);
		$res = $sel->query_select_or("login, email", "users", $condition, $attributes);
		return $res;
	}

	private function sendEmail($userinfo)
	{
		$emailTo = htmlspecialchars($userinfo['email']);
		$emailFrom = 'no-reply@camagru.com';
		$subject = "Camagru - Confirm Your Account";
		$message = "To create your account, confirm by clicking on the link below <br/> <a href='http://localhost:" . PORT . "/" . Routeur::$url['dir'] . "/Authsignin/validEmail/" . $_POST['login'] . "'>Confirm account</a>";
		$headers = "From: " . $emailFrom . "\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($emailTo, $subject, $message, $headers);
	}
}
?>
<script type="text/javascript" src="../public/js/misc.js"></script>
