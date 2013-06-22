<?php
define("CLOSES_ON", strtotime("24 May 2013 16:59:59"));

abstract class Controller_Website extends Controller_Template {
 
    public $page_title;
		protected static $closesOn = CLOSES_ON;
 
    public function before()
    {
				// Deal with i18n
				View::set_global('lang', $this->lang());
				View::set_global('closesOn', self::$closesOn);
				
				$this->page_title = __("Docent van het jaar :year", array(":year"=>date("Y")));;
				
				parent::before();
 
        // Make $page_title available to all views
        View::bind_global('page_title', $this->page_title);

        View::set_global('container_style', '-narrow');
 
        // Load $sidebar into the template as a view
        $this->template->menu = View::factory('template/menu')->set("token", $this->request->query("token"));
				$this->template->content = new stdClass();
    }
		
		/**
		 * i18n functionality
		 */
		public function lang(){
			// Language
			$l = $this->request->query("lang");
			if($l){
				Session::instance()->set("lang", $l);
			}
			
			$lang = Session::instance()->get(
				"lang", 
				$this->request->headers()->preferred_language(array(
					'en', 'nl'
				))
			);
				
			I18n::lang($lang);
			return $lang;
		}
}