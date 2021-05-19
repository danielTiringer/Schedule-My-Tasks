<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;
use DateTime;
use DateTimeZone;

class DailyTasks extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'daily_tasks';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'status',
		'todos_id',
	];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	public function generateDailyTasks()
	{
		$db = Database::connect();
		$builder = $db->table('todos')
					->select('id')
					->where('status', 'active');

		$intervals = ['daily'];

		if ($this->isItMonday()) {
			$intervals[] = 'weekly';
		}

		if ($this->isItFirstOfTheMonth()) {
			$intervals[] = 'monthly';
		}

		$query = $builder->whereIn('interval', $intervals)->get();

		foreach ($query->getResult() as $result) {
			$data = ['todos_id' => $result->id];
			$this->insert($data);
		}
	}

	private function isItMonday(): bool
	{
		$currentTime = $this->getCurrentTime();

		return $currentTime->format('l') === 'Monday';
	}

	private function isItFirstOfTheMonth(): bool
	{
		$currentTime = $this->getCurrentTime();
		return $currentTime->format('d') === '1';
	}

	private function getCurrentTime(): DateTime
	{
		$timeZone = new DateTimeZone('Europe/Budapest');
		return new DateTime('now', $timeZone);

	}
}
