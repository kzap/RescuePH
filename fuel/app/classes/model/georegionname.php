<?php
use Orm\Model;

class Model_GeoRegionName extends Model
{
	protected static $_properties = array(
		'country_code',
		'region_id',
		'region_name',
	);

	protected static $_primary_key = array('country_code', 'region_id');
	
	protected static $_has_many = array(
		'GeoCityNames' => array(
			'key_from' => array('country_code', 'region_id'),
			'key_to' => array('country_code', 'region_id'),
		),
	);
	
	protected static $_belongs_to = array(
		'GeoCountryNames' => array(
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
