<?php
abstract class Controller_Website extends Controller_Template {
 
    public $page_title;
 
    public function before()
    {
				$this->page_title = "Docent van het jaar ".date("Y");
        
				parent::before();
 
        // Make $page_title available to all views
        View::bind_global('page_title', $this->page_title);
 
        // Load $sidebar into the template as a view
        $this->template->menu = View::factory('template/menu');
				$this->template->content = new stdClass();
    }
 
}