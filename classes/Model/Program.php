<?php
class Model_Program extends ORM
{
    protected $_table_name = 'programs';
		
		protected $_has_many = array(
		    'courses' => array(
		        'model'       => 'Course',
        		'through' => 'program_course',
        		'foreign_key' => 'program_id',
		    ),
		);
}