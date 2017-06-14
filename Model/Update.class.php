<?php
class Update
{
	public function update_value($table, $set, $condition, $attributes = null)
	{
		$request = "UPDATE " . $table . " SET ";
		foreach ($set as $k => $v)
			$request .= $k . ' = ' . $v . ', ';
		$request = substr($request, 0, -2);
		if (isset($condition) && !empty($condition))
		{
			$request .= ' WHERE ';
			foreach ($condition as $k => $v)
				$request .= $k . ' = ' . $v . ' AND ';
			$request = substr($request, 0, -5);
		}
		return ((isset($attributes) ? Dispatcher::$db->prepare($request, $attributes) : Dispatcher::$db->query($request)));
	}
}