<?php
class Model_Course extends ORM
{
    protected $_table_name = 'courses';
		
		protected $_has_many = array(
		    'programs' => array(
		        'model'       => 'Program',
        		'through' => 'program_course',
        		'foreign_key' => 'cours_id',
		    ),
				'nominees' => array(
		        'model'       => 'Nominee',
						'foreign_key' => 'cours_id',
        		'through' => 'course_nominee',
		    ),
				'courses' => array(
						'model'				=> 'Student',
        		'through' => 'student_course',
						'foreign_key'	=> 'cours_id',
				)
		);
}