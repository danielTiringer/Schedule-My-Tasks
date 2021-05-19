<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;
use DateTime;
use DateTimeZone;

class DailyTasksController extends BaseController
{
	protected $helpers = ['form'];

	public function index()
	{
		$data = [];

		echo view('templates/header', $data);
		echo view('dailytasks/index');
		echo view('templates/footer');
	}

	public function generate()
	{
		$model = model('DailyTasks', false);

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
			$model->insert($data);
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
