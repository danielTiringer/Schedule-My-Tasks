<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'first_name' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
			],
			'last_name' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'unique' => true,
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
			],
			'created_at DATETIME default CURRENT_TIMESTAMP',
			'updated_at DATETIME default null ON UPDATE CURRENT_TIMESTAMP',
		]);
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
