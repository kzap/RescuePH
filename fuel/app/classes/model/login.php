<?php
use Orm\Model;

class Model_Login extends Model
{
	protected static $_properties = array(
		'id',
		'username',
		'password',
	);

	protected static $_table_name = "theusers";


	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('username', 'Username', 'required|max_length[255]');
		$val->add_field('password', 'Password', 'required|max_length[255]');

		return $val;
	}

}
