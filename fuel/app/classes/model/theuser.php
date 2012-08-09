<?php
use Orm\Model;

class Model_Theuser extends Model
{
	protected static $_properties = array(
		'id',
		'username',
		'password',
		'name',
	);


	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('username', 'Username', 'required|max_length[255]');
		$val->add_field('password', 'Password', 'required|max_length[255]');
		$val->add_field('name', 'Name', 'required|max_length[255]');

		return $val;
	}

}
