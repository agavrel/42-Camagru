<head>
	<link href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/public/css/style.css" rel="stylesheet">
	<script>document.title = "Camagru - Sign In";</script>
</head>
<div class='alert alert-success fadein' id="save-success"></div>
<?php

class ControllerAuthsignin extends Controller
{
	public function validEmail()
	{
		$upd = $this->call_model('update');
		$set_value = array('email_confirmed' => "'yes'");
		$cond = array('login' => "'" . Routeur::$url['params'][0] . "'");
		$upd->update_value('users', $set_value, $cond);

		$_SESSION['auth'] = htmlspecialchars(Routeur::$url['params'][0]);
		header('Location: ' . Routeur::redirect('Userindex/view'));
	}

	public function signIn()
	{
		$sel = $this->call_model('select');
		if (isset($_POST['sign_in']) && htmlspecialchars($_POST['sign_in']) === 'Login')
		{
			$condition = array('login' => '?');
			$attributes = array(htmlspecialchars($_POST['login']));
			$array = $sel->query_select("login, password, email_confirmed", "users", $condition, true, null, null, $attributes);
			if (isset($array) && !empty($array))
			{
				if ($array['email_confirmed'] === 'no')
					echo '<script type="text/javascript">', 'messageAnimation("Please confirm your email address", 2000);', '</script>';
				else if (hash('whirlpool', htmlspecialchars($_POST['password'])) === $array['password'])
				{
					echo '<script type="text/javascript">window.location.href = "../Userindex/view"; messageAnimation("Hello, you are now logged in", 2000);</script>';
					$_SESSION['auth'] = htmlspecialchars($_POST['login']);

				}
				else
					echo '<script type="text/javascript">', 'messageAnimation("Invalid password", 2000);', '</script>';
			}
			else
				echo '<script type="text/javascript">', 'messageAnimation("Invalid login", 2000);', '</script>';
		}
	}

	public function signOut()
	{
		$_SESSION['auth'] = "";
		echo '<script type="text/javascript">', 'messageAnimation("You have been disconnected", 2000);', '</script>';
	}

	public function noAccess()
	{
		echo '<script type="text/javascript">', 'messageAnimation("No access rights", 2000);', '</script>';
	}

	public function view(){
		if (isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			header('Location: ' . Routeur::redirect('Userindex/view'));
	}
}

?>
<script type="text/javascript" src="../public/js/misc.js"></script>
