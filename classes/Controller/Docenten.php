<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Docenten extends Controller_Website {
	
	public function action_index()
	{
		if(time() > self::$closesOn)
			HTTP::redirect("#closed");
		
		// Only if logged in
		if(!Auth::instance()->logged_in())
			HTTP::redirect("#login");
		
		$user = Auth::instance()->get_user();
		
		$this->template->content = View::factory("docenten");
		$nominees = ORM::factory('Nominee')->find_all();
		$programs = ORM::factory('Program')->find_all();
		$courses  = $user->courses->find_all();
		$votes = ORM::factory('Vote')->where("student", "=", $user->id)->find_all();
		$this->template->content->bind("tutors", $nominees);
		$this->template->content->bind("programs", $programs);
		$this->template->content->bind("courses", $courses);
		$this->template->content->bind("votes", $votes);
	}
	
	public function _action_import()
	{
		$programs = json_decode(file_get_contents(Kohana::find_file("assets","programs","json")), true);
		
		$courses = array();
		foreach($programs as $name => $vakken){
			foreach($vakken as $vak) $courses[$vak['kortenaamNL']] = $vak;
		}
		foreach($courses as $code => $vak){
			$docenten = $vak['docenten']['persoon'];
			if(isset($docenten['naam'])) $docenten = array($docenten);
			
			$co = ORM::factory('Course')->where('code', '=', $code)->find();
			if(!$co->loaded()){
				$co = ORM::factory('Course');
				$co->set('code', $code);
				$co->set('name', $vak['langenaamNL']);
				$co->save();
			}
			
			if($docenten)
			foreach($docenten as $docent){
				$el = ORM::factory('Nominee')->where('mail', '=', $docent['emailAdresTU'])->find();
				if(!$el->loaded()){
					$el = ORM::factory('Nominee');
					$el->set('mail', $docent['emailAdresTU']);
					$el->set('name', $docent['naam']['volledigeNaam']);
					$el->save();
				}
				if(!$co->has('nominees', $el))
					$co->add('nominees', $el);
			}
		}
		$this->template->content = "Imported all courses and tutors.";
	}
	public function _action_linkcourses(){
		$programs = json_decode(file_get_contents(Kohana::find_file("assets","programs","json")), true);
		$linked = 0;
		$out = "";
		
		foreach($programs as $name => $vakken){
			$prog = ORM::factory('Program')->where('name', '=', $name)->find();
			if(!$prog->loaded()) $out .= "Program $name doesn't exist. <br>";
			else
				foreach($vakken as $vak){
					$code = $vak['kortenaamNL'];
					$co = ORM::factory('Course')->where('code', '=', $code)->find();
					if(!$co->loaded()) $out .= "Course $code doesn't exist. <br>";
					elseif(!$prog->has('courses', $co)){
						$prog->add('courses', $co);
						$linked++;
					}
				}
		}
		$out .= "Linked $linked courses to a program.";
		$this->template->content = $out;
	}

} // End