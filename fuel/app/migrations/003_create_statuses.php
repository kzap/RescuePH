<?php

namespace Fuel\Migrations;

class Create_statuses
{
	public function up()
	{
		\DBUtil::create_table('statuses', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('statuses');
	}
}