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
		if (isset($_POST['sign_in']) && $_POST['sign_in'] === 'Login')
		{
			$condition = array('login' => '?');
			$attributes = array($_POST['login']);
			$array = $sel->query_select("login, password, email_confirmed", "users", $condition, true, null, null, $attributes);
			if (isset($array) && !empty($array))
			{
				if ($array['email_confirmed'] === 'no')
					$this->add_buff('email_not_confirmed', '<div class="alert alert-danger">Please confirm your email address</div>');
				else if (hash('whirlpool', $_POST['password']) === $array['password'])
				{
					$_SESSION['auth'] = $_POST['login'];
					header('Location: ' . Routeur::redirect('Userindex/view'));
				}
				else
					$this->add_buff('wrong_pwd', '<div class="alert alert-danger">Invalid password</div>');
			}
			else
				$this->add_buff('wrong_log', '<div class="alert alert-danger">Invalid login</div>');
		}
	}

	public function signOut()
	{
		$_SESSION['auth'] = "";
		$this->add_buff('alert_disconnected', '<div class="alert alert-success">You have been disconnected</div>');
	}

	public function noAccess()
	{
		$this->add_buff('no_access', '<div class="alert alert-danger">No access rights</div>');
	}

	public function view(){
		if (isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			header('Location: ' . Routeur::redirect('Userindex/view'));
	}
}

?>
