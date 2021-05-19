<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DailyTasksController extends BaseController
{
	protected $helpers = ['form'];

	public function index()
	{
		$data = [];

		$model = model('DailyTasks', false);

		$data['tasks'] = $model->getTodaysTasks();

		echo view('templates/header', $data);
		echo view('dailytasks/index');
		echo view('templates/footer');
	}

	public function progress(int $id = null)
	{
		$model = model('DailyTasks', false);
		$model->setStatus($id, 'not_started');
		return redirect()->to('/');
	}

	public function complete(int $id = null)
	{
		$model = model('DailyTasks', false);
		$model->setStatus($id, 'complete');
		return redirect()->to('/');
	}

	public function delete(int $id = null)
	{
		$model = model('DailyTasks', false);
		$model->setStatus($id, 'cancelled');
		return redirect()->to('/');
	}

	public function generate()
	{
		$model = model('DailyTasks', false);
		$model->generateDailyTasks();
	}
}
