<?php
use Orm\Model;

class Model_GeoCountryName extends Model
{
	protected static $_properties = array(
		'country_code',
		'country_name',
	);
	
	protected static $_primary_key = array('country_code');
	
	protected static $_has_many = array(
		'GeoRegionNames' => array(
			'key_from' => 'country_code',
			'key_to' => 'country_code',
		),
	);

	public static function validate($factory)
	{
/*
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');

		return $val;
*/
	}

}
