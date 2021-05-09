<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDailyTasks extends Migration
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
			'status' => [
				'type' => 'ENUM',
				'constraint' => ['not_started', 'complete', 'cancelled'],
				'default' => 'not_started',
			],
			'todos_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
			],
			'created_at DATETIME default CURRENT_TIMESTAMP',
			'updated_at DATETIME default null ON UPDATE CURRENT_TIMESTAMP',
		]);
		$this->forge->addForeignKey('todos_id', 'todos', 'id');
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('daily_tasks');
	}

	public function down()
	{
		$this->forge->dropTable('daily_tasks');
	}
}
