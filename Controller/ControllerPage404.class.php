<?php

class ControllerPage404 extends Controller
{
	public function view()
	{
		header('HTTP/1.1 404 Not Found');
	}
}