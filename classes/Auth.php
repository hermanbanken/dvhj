<?php defined('SYSPATH') or die('No direct script access.');

class Auth {

	public static $instance;

	public static function instance(){
		if(!self::$instance) self::$instance = new Auth();
		return self::$instance;
	}
	
	public function login($token){
		$user = ORM::factory('Student')->where('token', '=', $token)->find();
		if($user->loaded()){
			Session::instance()->set('student_token', $token);
			return true;
		}
		return false;
	}
	public function logout(){
		Session::instance()->delete('student_token');
	}
	
	public function logged_in(){
		$token = Session::instance()->get('student_token', false);
		return $token;
	}
	
	public function get_user(){
		if($this->logged_in()){
			$user = ORM::factory('Student')->where('token', '=', $this->logged_in())->find();
			return $user;
		}
		return false;
	}

}