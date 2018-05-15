<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student extends Controller {

	private $user;

	public function __construct(Kohana_Request $request, Response $response)
	{
		parent::__construct($request, $response);
		 
		// Only if logged in
		if(!Auth::instance()->logged_in())
			HTTP::redirect("#login");
		
		$this->user = Auth::instance()->get_user();
	}
	
	public function action_courses()
	{	
		if($this->request->method() == "POST"){
			$courses = $this->request->post('course');
			$this->user->remove("courses");
			if(is_array($courses))
				$this->user->add("courses", $courses);
		}
	}

	public function action_votes()
	{
		if($this->request->method() == "POST"){
			$motivations = $this->request->post('motivation');
			$grades = $this->request->post('grade');
			$results = array();
			$all_success = true;
			
			
			foreach($grades as $tutorId => $grade){
				
				$tutor = ORM::factory("Nominee", $tutorId);
				$vote = ORM::factory("Vote")->where("student", "=", $this->user->id)->and_where("nominee", "=", $tutor->id)->find();
				
				// Delete if vote was empty
				if(!isset($grade) || empty($grade)){
					if($vote->loaded()) $vote->delete();
					continue;
				} 
				
				$motivation = isset($motivations[$tutorId]) ? $motivations[$tutorId] : null;
				
				if(!$vote->loaded()){
					$vote->set('student', $this->user)->set('nominee', $tutor);
				}
				
				$vote->set('vote', min(10, max(1,floatval($grade))))->set('why', $motivation);
				
				if($vote->save()){
					$results[$tutorId] = 'success';
				} else {
					$results[$tutorId] = 'fail';
					$all_success = false;
				}
			}
			if(!$all_success){
				throw new Kohana_Exception(
					'Did not succeed in saving all votes. :debug',
					array(':debug' => print_r($results, 1))
			 	);
			}
		}
	}
} // End