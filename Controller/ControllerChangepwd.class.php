<head>
	<link href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/public/css/style.css" rel="stylesheet">
</head>
<div class='alert alert-success fadein' id="save-success"></div>
<?php


/**
*
*/
class ControllerChangepwd extends Controller
{
	public function view()
	{

	}

	public function updatePwd()
	{
		if($_POST['password'] === $_POST['password2'])
		{
			$conditions = array(
									'password'		=>		"'" . Routeur::$url['params'][0] . "'",
									'id'			=>		"'" . intval(Routeur::$url['params'][1]) . "'"
								);
			$req = self::$sel->query_select('*', 'users', $conditions);
			if (isset($req) && !empty($req))
			{
				$set = array(
										'password'		=>		"'" . hash('whirlpool', $_POST['password']) . "'"
							);
				self::$up->update_value('users', $set, $conditions);
				$this->add_buff('password_changed', '<div class="alert alert-success">Your password has been changed</div>');
				// redirect to sign in page !!
			}
			else
				$this->add_buff('wrong_link', '<div class="alert alert-danger">Url address not valid</div>');
		}
		else
			$this->add_buff('invalid_password_confirmation', '<div class="alert alert-danger">Invalid password confirmation</div>');
	}
}
<script type="text/javascript" src="../public/js/misc.js"></script>
