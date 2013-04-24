<?php
class Model_Nominee extends ORM
{
    protected $_table_name = 'nominees';
		
		protected $_has_many = array(
		    'courses' => array(
		        'model'       => 'Course',
        		'through' => 'course_nominee',
		    ),
		    'votes' => array(
		        'model'       => 'Vote',
		        'foreign_key' => 'nominee',
		    ),
		);
}