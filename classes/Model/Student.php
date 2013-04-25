<?php
class Model_Student extends ORM
{
    protected $_table_name = 'students';
		
		protected $_has_many = array(
		    'votes' => array(
		        'model'       => 'Vote',
        		'foreign_key' => 'student',
		    ),
				'courses' => array(
						'model'				=> 'Course',
        		'through' 		=> 'student_course',
						'foreign_key'	=> 'student_id',
				),
		);
		
		public function has_voted(){
			return $this->votes->count_all() > 0;
		}
		
		public function dirty(){
			$this->_changed['lastLogin'] = 'lastLogin';
			return $this->set('lastLogin', null);
		}
}