<head>
	<link href="http://localhost:<?= PORT ?>/<?= Routeur::$url['dir'] ?>/public/css/style.css" rel="stylesheet">
	<script>document.title = "Camagru - Change Password";</script>
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

		// warning : password can be unsecured when changed.
		$pwd = htmlspecialchars($_POST['password']);
		if ($pwd === htmlspecialchars($_POST['password2']))
		{
			$conditions = array(
									'password'		=>		"'" . Routeur::$url['params'][0] . "'",
									'id'			=>		"'" . intval(Routeur::$url['params'][1]) . "'"
								);
			$req = self::$sel->query_select('*', 'users', $conditions);

			if (isset($req) && $req)
			{
				$set = array(
										'password'		=>		"'" . hash('whirlpool', $pwd) . "'"
							);
				self::$up->update_value('users', $set, $conditions);
				echo '<script type="text/javascript">messageAnimation("Your password has been changed", 2000); window.location.href = "../Userindex/view";</script>';
			}
			else
				echo '<script type="text/javascript">', 'messageAnimation("User not found", 2000);', '</script>';
		}
		else
			echo '<script type="text/javascript">', 'messageAnimation("Invalid password confirmation", 2000);', '</script>';
	}
}
?>
<script type="text/javascript" src="../public/js/misc.js"></script>
