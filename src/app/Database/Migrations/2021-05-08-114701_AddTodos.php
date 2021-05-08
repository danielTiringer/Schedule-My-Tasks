<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTodos extends Migration
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
			'description' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
			],
			'users_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
			],
			'created_at DATETIME default CURRENT_TIMESTAMP',
			'updated_at DATETIME default null ON UPDATE CURRENT_TIMESTAMP',
		]);
		$this->forge->addForeignKey('users_id', 'users', 'id');
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('todos');
	}

	public function down()
	{
		$this->forge->dropTable('todos');
	}
}
