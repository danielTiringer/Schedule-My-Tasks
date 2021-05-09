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
			'status' => [
				'type' => 'ENUM',
				'constraint' => ['not started', 'in progress', 'completed', 'deleted'],
				'default' => 'not started',
			],
			'users_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
			],
			'created_at DATETIME default CURRENT_TIMESTAMP',
			'updated_at DATETIME default null ON UPDATE CURRENT_TIMESTAMP',
			'completed_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'deleted_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
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
