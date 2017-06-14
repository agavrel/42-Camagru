<?php

class Controller
{
	public static $cont;
	protected static $sel;
	protected static $del;
	protected static $ins;
	protected static $up;

	public function __construct()
	{
		/**
		 * a appele dans les sous controleurs
		 * @var [type]
		 */
		self::$sel = $this->call_model('select');
		self::$del = $this->call_model('delete');
		self::$ins = $this->call_model('insert');
		self::$up = $this->call_model('update');
	}

	public function header()
	{
		if (isset($_SESSION['auth']) && !empty($_SESSION['auth']))
		{
			$currentPage = Routeur::$url['controller'];
		//	echo Routeur::$url['controller'];
			$home = '<a class="navbar-brand '.($currentPage === 'Userindex' ? 'navbar-current':"").'" href="http://localhost:' . PORT . '/' . Routeur::$url['dir'] . '/Userindex/view' .'">Camagru</a>'; //  ".'$_SESSION['login'] .'"
			$profile = '<a class="navbar-brand '.($currentPage === 'Userprofile' ? 'navbar-current':"").'" href="http://localhost:' . PORT . '/' . Routeur::$url['dir'] . '/Userprofile/view/' . $_SESSION['auth'] .'">Profile</a>'; //  ".'$_SESSION['login'] .'"
			$camjs = '<a class="navbar-brand '.($currentPage === 'Userindex' ? 'navbar-current':"").'" href="http://localhost:' . PORT . '/' . Routeur::$url['dir'] . '/Userindex/view">Cam JS</a>';
			$camphp = '<a class="navbar-brand '.($currentPage === 'Userindexphp' ? 'navbar-current':"").'" href="http://localhost:' . PORT . '/' . Routeur::$url['dir'] . '/Userindexphp/view">Cam PHP</a>';
			$gallery = '<a class="navbar-brand '.($currentPage === 'Usergallery' ? 'navbar-current':"").'" href="http://localhost:' . PORT . '/' . Routeur::$url['dir'] . '/Usergallery/view">Gallery</a>';
			$disconnect = '<a class="navbar-brand" href="http://localhost:' . PORT . '/' . Routeur::$url['dir'] . '/Authsignin/signOut">Sign Out</a>';


		}
		require_once('View/templates/header.php');
	}

	public function footer()
	{
		require_once('View/templates/footer.php');
	}

	public function init()
	{
		$name = Routeur::$url['controller'];
		$func = $this->call_controller($name);
		$func_name = Routeur::$url['method'];
		if (method_exists($func, $func_name) == true)
			$func->$func_name();
		else
			Routeur::redirect('Page404/view');
	}

	public function call_controller($name)
	{
	   $name = 'Controller' . ucfirst($name);
		if (file_exists('Controller/' . $name . '.class.php'))
			require_once('Controller/' . $name . '.class.php');
		else
		{
			Routeur::redirect('Page404/view');
			return ;
		}
		return (new $name());
	}

	public function rend($name)
	{
		if (isset(Controller::$cont))
			extract(Controller::$cont, EXTR_OVERWRITE);
		$this->header();
		require_once('View/' . ucfirst($name) . '.php');
		$this->footer();
	}

	public function add_buff($name, $value)
	{
		Controller::$cont[$name] = $value;
	}

	public function call_model($model_name)
	{
		$name = ucfirst($model_name);
		require_once('Model/' . $name . '.class.php');
		return (new $name());
	}
}

?>
