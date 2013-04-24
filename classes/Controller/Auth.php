<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller {

	public function action_login()
	{
		$post = $this->request->post();
		if(Auth::instance()->logged_in() || isset($post['token']) && Auth::instance()->login($post['token'])){
			HTTP::redirect(preg_replace("/[^a-zA-Z0-9]/", "", isset($post['redirect']) ? $post['redirect'] : ""));
		} else {
			echo "Wrong login!";
		}
	}
	
	public function action_logout()
	{
		if(Auth::instance()->logged_in()){
			Auth::instance()->logout();
			HTTP::redirect("");
		} else {
			echo "Not logged in";
		}
	}

} // End