<?php
class Insert
{
	public function insert_value($table, $values, $attributes = null)
	{
		$request = "INSERT INTO " . $table . "(";
		foreach ($values as $k => $v)
			$request .= $k . ', ';
		$request = substr($request, 0, -2);
		$request .= ") VALUES (";
		foreach ($values as $k => $v)
			$request .= $v . ', ';
		$request = substr($request, 0, -2);
		$request .= ");";
		return ((isset($attributes) ? Dispatcher::$db->prepare($request, $attributes, false) : Dispatcher::$db->query($request)));
	}
}