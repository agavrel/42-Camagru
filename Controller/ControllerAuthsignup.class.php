<head>
	<link href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/public/css/style.css" rel="stylesheet">
	<script>document.title = "Camagru - Sign Up";</script>
<head>
<div class='alert alert-success fadein' id="save-success"></div>
<?php

class ControllerAuthsignup extends Controller
{
	public function view()
	{

	}

	public function signUp()
	{
		$pwd = htmlspecialchars($_POST['password']);
		if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $pwd))
			echo '<script type="text/javascript">', 'messageAnimation("Unsecured Password, Please use 8 characters, combination of lowercase, uppercase letters and digits with special character", 5000);', '</script>';
		else if ($_POST['signup'] === 'Submit' && $pwd === htmlspecialchars($_POST['password2']))
		{
			$check = $this->checker($_POST);
			if (!preg_match('/[a-z0-9]+@[a-z0-9]+[.][a-z]+/', htmlspecialchars($_POST['email'])))
				echo '<script type="text/javascript">', 'messageAnimation("Invalid email : It should be email@provider.xxx", 4000);', '</script>';
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
				$password = hash('whirlpool', $pwd);
				$attributes = array(
										htmlspecialchars($_POST['login']),
										htmlspecialchars($_POST['email']),
										$password
									);
				$insert->insert_value('users', $values, $attributes);
				$this->sendEmail($_POST);
				echo '<script type="text/javascript">', 'messageAnimation("An email has been sent to you", 2000);', '</script>';
			}
			else
			{
				if ($check['login'] === htmlspecialchars($_POST['login']))
					echo '<script type="text/javascript">', 'messageAnimation("Login already used", 2000);', '</script>';
				else
					echo '<script type="text/javascript">', 'messageAnimation("Email already used", 2000);', '</script>';
			}
		}
		else
			echo '<script type="text/javascript">', 'messageAnimation("Invalid password confirmation", 2000);', '</script>';
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
