<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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
		$model->generateDailyTasks();
	}
}
