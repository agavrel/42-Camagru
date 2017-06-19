<head>
	<link href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/public/css/style.css" rel="stylesheet">
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
					echo '<script type="text/javascript">', 'messageAnimation("Please confirm your email address");', '</script>';
				//	$this->add_buff('email_not_confirmed', '<div class="alert alert-danger">Please confirm your email address</div>');
				else if (hash('whirlpool', htmlspecialchars($_POST['password'])) === $array['password'])
				{
					$_SESSION['auth'] = htmlspecialchars($_POST['login']);
					header('Location: ' . Routeur::redirect('Userindex/view'));
				}
				else
					echo '<script type="text/javascript">', 'messageAnimation("Invalid password");', '</script>';
					//$this->add_buff('wrong_pwd', '<div class="alert alert-danger">Invalid password</div>');
			}
			else
				echo '<script type="text/javascript">', 'messageAnimation("Invalid login");', '</script>';
				//$this->add_buff('wrong_log', '<div class="alert alert-danger">Invalid login</div>');
		}
	}

	public function signOut()
	{
		$_SESSION['auth'] = "";
		echo '<script type="text/javascript">', 'messageAnimation("You have been disconnected");', '</script>';
	//	$this->add_buff('alert_disconnected', '<div class="alert alert-success">You have been disconnected</div>');
	}

	public function noAccess()
	{
		echo '<script type="text/javascript">', 'messageAnimation("No access rights");', '</script>';
		//$this->add_buff('no_access', '<div class="alert alert-danger">No access rights</div>');
	}

	public function view(){
		if (isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			header('Location: ' . Routeur::redirect('Userindex/view'));
	}
}

?>

<script type="text/javascript">
function messageAnimation(msg) {
	const alert			= document.querySelector('.alert');

	alert.style.display = 'inline';
	alert.innerHTML = msg;
	alert.classList.add("fadein");
	setTimeout(function () {
		alert.classList.remove("fadein");
		alert.classList.add("fadeout");
	}, 1000);
	/* 2sd to fadeout and fadeout during 600ms (css for save-success) = 2600 */
	setTimeout(function () {
		//alert.remove();
		alert.style.display = 'none';
	}, 1600);
}
</script>
