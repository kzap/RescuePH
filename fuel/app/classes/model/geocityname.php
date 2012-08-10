<?php
use Orm\Model;

class Model_GeoCityName extends Model
{
	protected static $_properties = array(
		'city_id',
		'country_code',
		'region_id',
		'city_name',
		'postal_code',
		'latitude',
		'longitude',
		'metro_code',
		'area_code',
		'city_region_name',
	);
	
	protected static $_primary_key = array('city_id');
	
	protected static $_belongs_to = array(
		'GeoRegionNames' => array(
			'key_from' => array('country_code', 'region_id'),
			'key_to' => array('country_code', 'region_id'),
		),
	);
	
	protected static $_has_many = array(
		'Rescues' => array(
			'key_from' => array('city_id'),
			'key_to' => array('city_id'),
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
