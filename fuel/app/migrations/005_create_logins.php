<?php

namespace Fuel\Migrations;

class Create_logins
{
	public function up()
	{
		\DBUtil::create_table('logins', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'username' => array('constraint' => 255, 'type' => 'varchar'),
			'password' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('logins');
	}
}