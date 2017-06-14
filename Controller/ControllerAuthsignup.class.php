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
			$check = $this->checker($_POST);
			if (!preg_match('/[a-z0-9]+@[a-z0-9]+[.][a-z]+/', $_POST['email']))
				$this->add_buff('invalid_email', '<div class="alert alert-danger">Invalid email</div>');
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
				echo $password;
				$attributes = array(
										$_POST['login'], 
										$_POST['email'], 
										$password
									);
				$insert->insert_value('users', $values, $attributes);
				$this->sendEmail($_POST);
				$this->add_buff('email_sent','<div class="alert alert-info">An email has been sent to you</div>');
			}
			else
			{
				if ($check['login'] === $_POST['login'])
					$this->add_buff('already_taken', '<div class="alert alert-danger">Login already taken</div>');
				else
					$this->add_buff('already_taken', '<div class="alert alert-danger">Email already taken</div>');
			}
		}
		else
		{
			$this->add_buff('wrong_password_confirmation', '<div class="alert alert-danger">Invalid password confirmation</div>');
		}
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
		$emailFrom = 'tasoeur@camagru.com';
		$subject = "Camagru - Confirm Your Account";
		$message = "To create your account, confirm by clicking on the link below <br/> <a href='http://localhost:" . PORT . "/" . Routeur::$url['dir'] . "/Authsignin/validEmail/" . $_POST['login'] . "'>Confirm account</a>";
		$headers = "From: " . $emailFrom . "\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($emailTo, $subject, $message, $headers);
	}
}
?>
