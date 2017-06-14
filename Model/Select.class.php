<?php
class Select
{
	public function	all($table, $one = true)
	{
		return (Dispatcher::$db->query("SELECT * FROM " . $table, $one));
	}

	// Une fois que ca marche essayer de mettre attributes juste apres condition
	public function query_select($value, $table, $condition = null, $one = true, $order = null, $extra = null, $attributes = null)
	{
		$request = "SELECT " . $value . " FROM " . $table;
		if ($condition)
		{
			$request .= " WHERE ";
			foreach ($condition as $k => $v)
				$request .= $k . ' = ' . $v . ' AND ';
			$request = substr($request, 0, -5);
		}
		if (isset($order) && !empty($order))
			$request .= " ORDER BY " . $order . " DESC";
		if (isset($extra) && !empty($extra))
			$request .= $extra;
		return ((isset($attributes) ? Dispatcher::$db->prepare($request, $attributes, $one) : Dispatcher::$db->query($request, $one)));
	}

	public function query_select_or($value, $table, $condition = null, $attributes = null, $one = true)
	{
		$request = "SELECT " . $value . " FROM " . $table;
		if ($condition)
		{
			$request .= " WHERE ";
			foreach ($condition as $k => $v)
				$request .= $k . ' = ' . $v . ' OR ';
			$request = substr($request, 0, -4);
		}
		return ((isset($attributes) ? Dispatcher::$db->prepare($request, $attributes, $one) : Dispatcher::$db->query($request, $one)));
	}
}

?>