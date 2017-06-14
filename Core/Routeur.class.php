<?php

class Routeur
{
	public static $url = null;

	public function __construct()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$url = explode('/', $uri);
		Routeur::$url['dir'] = $url[1];
		if (empty($url[2]))
		{
			header('Location: ' . ((isset($_SESSION['auth']) && !empty($_SESSION['auth'])) ? $this->redirect("Userindex/view") : $this->redirect("Authsignin/signIn")));
		}
		else
		{
			(isset($url[2])) ? Routeur::$url['controller'] = $url[2] : (isset($_SESSION['auth']) ? $this->redirect("Userindex/view") : $this->redirect("Page404/view"));
			(isset($url[3])) ? Routeur::$url['method'] = $url[3] : $this->redirect("Page404/view");
			for ($i = 4; $i <= count($url) - 1; $i++)
				Routeur::$url['params'][] = $url[$i];
		}
		
	}

	public static function redirect($new_url)
	{
		$new_url = explode('/', $new_url);
		Routeur::$url['controller'] = $new_url[0];
		Routeur::$url['method'] = $new_url[1];
		return ('http://localhost:' . PORT . '/' . Routeur::$url['dir'] . '/' . Routeur::$url['controller'] . '/' . Routeur::$url['method']);
	}
}

?>