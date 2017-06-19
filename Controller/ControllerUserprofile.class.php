<head>
	<script>document.title = "Camagru - My Profile";</script>
</head>
<?php

class ControllerUserprofile extends Controller
{
	public function view()
	{
		if (isset(Routeur::$url['params'][0]) && !empty(Routeur::$url['params'][0]))
		{
			$username = ucfirst(Routeur::$url['params'][0]);
			if ($username !== ucfirst($_SESSION['auth']))
				$this->add_buff('username', '~ ' . $username . ' ~');
			else
				$this->add_buff('username', 'Your profile page');
		}
		else
			header('Location: ' . Routeur::redirect("Page404/view"));

		$condition = array(
								'login' => '?'
							);
		$attributes = array($username);
		$req = self::$sel->query_select('*', 'posts', $condition, false, 'date', null, $attributes);
		$img = "";
		foreach ($req as $v) {
			$img .= '
						<div class="div_image">
							<img class="images" src="../../' . $v['image_path'] . '">
							<img class="cross" src="../../public/resources/delete.png">
						</div>
					';
		}
		$this->add_buff('images', $img);
		$value = "COUNT('id') AS 'nbLike'";
		$extra = " INNER JOIN posts ON likes.img_path = posts.image_path WHERE posts.login = '" . Routeur::$url['params'][0] . "'";
		$req = self::$sel->query_select($value, 'likes', null, true, null, $extra);
		$this->add_buff('nbLikes', $req['nbLike']);
	}

	public function delete()
	{
		if (isset($_POST['img_path']) && !empty($_POST['img_path']))
		{
			$conditions = array(
									'image_path'	=>		"'" . $_POST['img_path'] . "'",
									'login'			=>		"'" . $_SESSION['auth'] . "'"
								);
			self::$del->delete_value('posts', $conditions);
			unlink($_POST['img_path']);
		}
	}
}
