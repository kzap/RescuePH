<?php
use Orm\Model;

class Model_Status extends Model
{
	protected static $_properties = array(
		'id',
		'name',
	);


	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');

		return $val;
	}

}
