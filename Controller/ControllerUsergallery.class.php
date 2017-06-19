<head>
	<script>document.title = "Camagru - Gallery";</script>
</head>
<?php
class ControllerUsergallery extends Controller
{
	private static $posts;
	public function view()
	{
		self::$posts = self::$sel->query_select('*', 'posts', null, false, 'image_path');
	}
	private static function displayCom($img_path)
	{
		$condition = array(
								'img_path'		=>		"'{$img_path}'"
							);
		$req = self::$sel->query_select('*', 'comments', $condition, false, 'date');
		echo '<br><div class="com_container">';
		if (isset($req) && !empty($req))
		{
			foreach ($req as $v) {
				echo "<p class='comment'><b>{$v['login']}:</b>&nbsp;{$v['img_comment']}</p>";
			}
		}
		echo '</div>';
	}
	public function infiniteScroll()
	{
		//Get image path
		$condition = array(
								'image_path'	=>	"'" . $_POST['img_path'] . "'"
					);
		$id = self::$sel->query_select('id', 'posts', $condition);
		$extra = " WHERE id < " . $id['id'] . " ORDER BY id DESC LIMIT 1";
		$info = self::$sel->query_select('image_path, login AS owner', 'posts', null, true, null, $extra);
		if (!isset($info['image_path']))
		{
			echo 'null';
			return ;
		}
		//Get like
		if (isset($_SESSION['auth']) && !empty($_SESSION['auth'])) {
			$conditions = array(
								'img_path'	=>	"'" . $info['image_path'] . "'",
								'login'		=>	"'" . $_SESSION['auth'] . "'"
							);
		$liked_by_user = self::$sel->query_select('id', 'likes', $conditions);
		if (isset($liked_by_user) && !empty($liked_by_user))
			$info['liked'] = 'yes';
		else
			$info['liked'] = 'no';
		} else {
			$info['liked'] = 'no';
		}
		//Get Count(Like)
		$condition = array(
								'img_path'	=>	"'" . $info['image_path'] . "'"
							);
		$value = "Count(id) AS 'countLikes'";
		$count = self::$sel->query_select($value, 'likes', $condition);
		$info['countLikes'] = $count['countLikes'];
		//Get Comments
		$comments = self::$sel->query_select('login, img_comment', 'comments', $condition, false, 'id');
		$info['comments'] = $comments;
		echo json_encode($info);
		echo "|";
	}
	public static function five_imgs($begin, $form)
	{
		$finish = $begin + 5;
		if (isset($_SESSION['auth']) && !empty($_SESSION['auth']))
		{
			$condition = array (
									'login' => "'" . $_SESSION['auth'] . "'"
								);
			$likes = self::$sel->query_select('img_path', 'likes', $condition, false);
		}
		$value = "Count(id) AS 'countLikes'";
		if (empty(self::$posts[$begin]))
			echo '<h1>You didn\'t take any picture yet</h1>';
		while ($begin < $finish && isset(self::$posts[$begin]))
		{
			$bool = false;
			echo '<div class="img-thumbnail">';
			/* image */
			echo $form->img('../' . self::$posts[$begin]['image_path'], 'image');
			/* user */
			echo '<div class="by_likes">
				<p class="alignleft">Posted by '; echo $form->surround(self::$posts[$begin]['login'], 'a', 'userLink'); echo '</p>';
			/* like counter */
			$condition = array ('img_path' => "'" . self::$posts[$begin]['image_path'] . "'");
			$req = self::$sel->query_select($value, 'likes', $condition);
			echo '<p class="alignright">';
			$output = $req['countLikes'] . " like" . ($req['countLikes'] > 1 ? "s" : "");
			echo $form->surround($output, 'a', 'countLikes');
			echo '</p></div>';
			/* like button */
			if (isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				foreach ($likes as $v) {

					if ($v['img_path'] === self::$posts[$begin]['image_path'])
					{
						echo '<img class="like" src="../public/resources/colored_heart.png" id="' . self::$posts[$begin]['image_path'] . '" />';
						$bool = true;
					}
				}
				if ($bool === false)
					echo '<img class="like" src="../public/resources/empty_heart.png" id="' . self::$posts[$begin]['image_path'] . '" />';
				echo '<br>';
			}
			else
				echo '<img class="like" style="display: none;"><br>';

			if (isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				echo $form->input('comment', null, null, 'form-control', false);

			//	echo discuss about it with Arnaud



				echo '<button class="btn btn-primary">Comment</button>';
			} else {
				echo '<button class="btn btn-primary style="display: none;">Comment</button>';
			}
			echo '<br>';
			self::displayCom(self::$posts[$begin]['image_path']);
			echo '</div>';
			echo '<br><br>';
			$begin++;
		}
	}
	public function like(){
		if (isset($_POST['image_path']) && !empty($_POST['image_path'])) {
			$values = array (	'id'			=>		'null',
								'img_path'		=> 		"'" . $_POST['image_path'] . "'",
								'login'			=>		"'" . $_SESSION['auth'] . "'"
							);
			self::$ins->insert_value('likes', $values);
		}
	}
	public function unlike(){
		if (isset($_POST['image_path']) && !empty($_POST['image_path']))
		{
			$condition = array (
									'img_path' 	=>		"'" . $_POST['image_path'] . "'",
									'login'		=>		"'" . $_SESSION['auth'] . "'"
								);
			self::$del->delete_value('likes', $condition);
		}
	}
	public function showLikers()
	{
		if (isset($_POST['image_path']) && !empty($_POST['image_path']))
		{
			$condition = array  (
									'img_path' 	=>		"'" . $_POST['image_path'] . "'"
								);
			$userWhoLiked = self::$sel->query_select('login', 'likes', $condition, false);
			$ret = array ();
			header('Content-type: text/plain');
			foreach ($userWhoLiked as $v) {
				echo $v['login'] . ',';
			}
		}
	}
	public function comment()
	{
		if (isset($_POST['comment']) && !empty($_POST['comment']))
		{
			$values = array(
								'id'			=>		'null',
								'img_path'		=>		'?',
								'login'			=>		'?',
								'img_comment'	=>		'?',
								'date'			=>		"'" . date('Y-m-d-H-i-s') . "'"
							);
			$attributes = array(
									$_POST['img_path'],
									$_SESSION['auth'],
									$_POST['comment']
								);
			self::$ins->insert_value('comments', $values, $attributes);
			$condition = array(
									'image_path'	=>		"'" . $_POST['img_path'] . "'"
								);
			$req = self::$sel->query_select('login', 'posts', $condition);
			if ($req['login'] !== $_SESSION['auth'])
			{
				$condition = array(
										'login'		=>	"'" . $req['login'] . "'"
									);
				$q2 = self::$sel->query_select('email', 'users',  $condition);
				$emailTo = htmlspecialchars($q2['email']);
				$emailFrom = 'tatante@camagru.com';
				$subject = "Camagru - " . $_SESSION['auth'] . " commented your photo";
				$img_link = "http://localhost:" . PORT . "/" . Routeur::$url['dir'] . "/" . $_POST['img_path'];
				$profile_link = "http://localhost:" . PORT . "/" . Routeur::$url['dir'] . "/Userprofile/view/" . $req['login'];
				$message = "Hi " . ucfirst($req['login']) . "<br/> Awesome, " . $_SESSION['auth'] . " just comments your photo !<br/> <a href='$profile_link'>Click here to see his profile page</a><br/><label>Comment:</label><br/><p>" . $_POST['comment'] . "</p>";
				$headers = "From: " . $emailFrom . "\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				mail($emailTo, $subject, $message, $headers);
			}
		}
		echo json_encode(array('user' => "{$_SESSION['auth']}"));
	}
}
?>
