<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Default extends Controller_Website {

	public function action_index()
	{
		$this->template->content = View::factory("welcome");
	}

} // End