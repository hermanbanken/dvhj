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
}