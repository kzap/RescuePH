<?php

namespace Fuel\Migrations;

class Create_rescues
{
	public function up()
	{
		\DBUtil::create_table('rescues', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'address' => array('type' => 'text'),
			'city_id' => array('constraint' => 11, 'type' => 'int'),
			'specifics' => array('constraint' => 255, 'type' => 'varchar'),
			'reporter' => array('constraint' => 255, 'type' => 'varchar'),
			'source' => array('constraint' => 255, 'type' => 'varchar'),
			'status_id' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('rescues');
	}
}