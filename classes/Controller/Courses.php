<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Courses extends Controller {

	public function action_index()
	{
		$p = ORM::factory("Course")->find_all();
		
		$format = $this->request->param('output', 'json');
		$this->request->headers('Content-Type', 'application/json');
		$this->request->response = json_encode($p);
	}
	
	public function action_byprogram()
	{
		$p = ORM::factory("Program", $this->request->param('id'));
		if($p->loaded()){
			$all = $p->courses->find_all()->as_array();
			$this->output($all);
		} else {
			echo "[]";
		}
	}
	
	public function action_byname(){
		$i = $this->request->param('id');
		if(strpos($i, " | ")){
			$p = explode(" | ", $i);
			$c = ORM::factory("Course")->where('code', 'like', $p[0])->find_all();
		} else {
			$l = '%'.$this->request->param('id').'%';
			$c = ORM::factory("Course")->where('code', 'like', $l)->or_where('name', 'like', $l)->find_all();			
		}
		$this->output($c->as_array());
	}
	public function action_byteacher(){
		$l = '%'.$this->request->param('id').'%';
		$p = ORM::factory("Nominee")->where('name', 'like', $l)->or_where('mail', 'like', $l)->find_all();
		$list = array();
		foreach($p as $n){
			$cs = $n->courses->find_all();
			foreach($cs as $c){
				$list[] = $n->name . " | " . $c->code . " | " . $c->name;
			}
		}
		$list = array_unique($list);
		$this->output($list);
	}
	
	public function output($array){
		$this->request->headers('Content-Type', 'application/json');
		foreach($array as $key=>$val){
			if(is_object($val))
				$array[$key] = $val->object();
			else
				$array[$key] = $val;
		}
		echo json_encode($array);
	}

} // End