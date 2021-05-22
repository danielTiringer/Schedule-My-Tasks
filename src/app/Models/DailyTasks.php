<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;
use DateTime;
use DateTimeZone;

class DailyTasks extends Model
{
	private const TIMEZONE = 'Europe/Budapest';

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

	public function getTodaysTasks(): array
	{
		$today = $this->getCurrentTime()->format('Y-m-d');
		$weekStart = $this->getWeekStart()->format('Y-m-d');
		$monthStart = $this->getMonthStart()->format('Y-m-d');

		$db = Database::connect();
		$builder = $db->table('daily_tasks')
					->select('daily_tasks.id, daily_tasks.status, todos.description')
					->join('todos', 'todos.id = daily_tasks.todos_id')
					->groupStart()
						->where([
							'todos.interval' => 'daily',
							'DATE(daily_tasks.created_at)' => $today,
						])
					->groupEnd()
					->orGroupStart()
						->where([
							'todos.interval' => 'weekly',
							'DATE(daily_tasks.created_at) >=' => $weekStart,
						])
					->groupEnd()
					->orGroupStart()
						->where([
							'todos.interval' => 'monthly',
							'DATE(daily_tasks.created_at) >=' => $monthStart,
						])
					->groupEnd()
				 ;
		$query = $builder->get();
		$result = $query->getResultArray();

		return $this->formatStatusText($result);
	}

	public function setStatus(int $id, string $status)
	{
		$this->update($id, [
			'status' => $status,
		]);
	}

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

	private function formatStatusText(array $results): array
	{
		return array_map([$this, 'replaceUnderscoreAndCapitalize'], $results);
	}

	private function replaceUnderscoreAndCapitalize(array $result): array
	{
		$result['status'] = ucwords(str_replace('_', ' ', $result['status']));
		return $result;
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
		$timeZone = new DateTimeZone(self::TIMEZONE);

		return new DateTime('now', $timeZone);
	}

	private function getWeekStart(): DateTime
	{
		return new DateTime('monday this week');
	}

	private function getMonthStart(): DateTime
	{
		return new DateTime('first day of this month');
	}
}
