<?php
class Model_Vote extends ORM
{
    protected $_table_name = 'votes';
		

		protected $_belongs_to = array(
		    'nominee' => array(
		        'model'       => 'Nominee',
		        'foreign_key' => 'nominee',
		    ),
		    'student' => array(
		        'model'       => 'Student',
		        'foreign_key' => 'student',
		    ),
		);
}