<?php
namespace UserApp\Services;

class ViewMaker
{
	protected $layout;
	private $view_path;

	public function __construct($layout_file = 'layout')
	{
		$this->layout = $this->_view_file_path($layout_file);
	}

	public function render($view, Array $view_data = array())
	{
		foreach($view_data as $key => $value)
			$$key = $value;

		ob_start();
		require $this->_view_file_path($view);
		$content = ob_get_clean();
		ob_end_clean();

		require $this->layout;
		exit;
	}

	private function _view_file_path($view)
	{
		$view = str_replace(".", "/", $view);

		$view_file = app_path()."/views/".$view.".php";
		if(!file_exists($view_file))
			throw new \Exception("View file {$view_file} does not exist in ".app_path()."/views", 1);					

		return $view_file;
	}


}