<?php
class Delete
{
	public function delete_value($table, $condition = null)
	{
		$request = "DELETE FROM " . $table . " WHERE ";
		if (isset($condition) && !empty($condition))	
		{
			foreach ($condition as $k => $v)
				$request .= $k . ' = ' . $v . ' AND ';
			$request = substr($request, 0, -5);
		}
		return (Dispatcher::$db->query($request));
	}
}