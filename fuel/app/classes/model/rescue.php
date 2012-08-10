<?php
use Orm\Model;

class Model_Rescue extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'address',
		'city_id',
		'specifics',
		'reporter',
		'source',
		'status_id',
		'theuser_id',
		'lat',
		'lng'
	);

	protected static $_belongs_to = array(
		'GeoCityNames' => array(
			'key_from' => array('city_id'),
			'key_to' => array('city_id'),
		),
		'status', 
		'theuser'
	);


	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		// $val->add_field('name', 'Name', 'required|max_length[255]');
		$val->add_field('address', 'Address', 'required');
		$val->add_field('city_id', 'City Id', 'required|valid_string[numeric]');
		$val->add_field('specifics', 'Specifics', 'required|max_length[255]');
		// $val->add_field('reporter', 'Reporter', 'required|max_length[255]');
		// $val->add_field('source', 'Source', 'required|max_length[255]');
		$val->add_field('status_id', 'Status Id', 'required|valid_string[numeric]');

		return $val;
	}

}
