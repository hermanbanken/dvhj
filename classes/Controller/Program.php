<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Program extends Controller {

	public function action_index()
	{
		$p = ORM::factory("Program")->find_all();
		
		$format = $this->request->param('output', 'json');
		$this->request->headers('Content-Type', 'application/json');
		$this->request->response = json_encode($p);
	}
	
	public function action_id()
	{
		$p = ORM::factory("Program", $this->request->param('id'));
		if($p->loaded()){
			
		}
	}

} // End