<head>
	<script>document.title = "Camagru - Index";</script>
</head>
<?php

class ControllerUserindex extends Controller
{
	public function view()
	{
		if (!isset($_SESSION['auth']) && empty($_SESSION['auth']))
			header('Location: ' . Routeur::redirect('Authsignin/noAccess'));
		else
		{
			$filters = "";
			$i = 0;
			if ($handle = opendir("public/resources/filter"))
			{
				while (($entry = readdir($handle)) !== false) {
					if ($i > 1)	{
						$i == 2 ? $required = 'checked="checked"' : $required = "";
						$filters .= '<div class="div_filters"><img class="filters" src="../public/resources/filter/' . $entry . '"><br />
						<input type="radio" name="filter" value="' . $entry . '" ' . $required .'></div>';
					}
					$i++;
				}
				$this->add_buff('filters', $filters);
			}
		}
	}

	public function save()
	{
		$date_of_file = date('Y-m-d-H-i-s');
		$file = uniqid(date('Y-m-d-H-i-s'));
		$encodedData = str_replace(' ', '+', $_POST['contents']);
		$decodedData = base64_decode($encodedData);
		$fp = fopen('public/copies/' . $file . '.jpg', 'w');
		fwrite($fp, $decodedData);
		fclose($fp);
		$ins = $this->call_model('insert');
		$values = array	(
												'id'			=>		'null',
												'image_path'	=>		"'public/copies/" . $file . ".jpg'",
												'login'			=>		"'" . $_SESSION['auth'] . "'",
												'date'			=>		"'" . $date_of_file . "'"
						);
		$ins->insert_value('posts', $values);
	}
}
