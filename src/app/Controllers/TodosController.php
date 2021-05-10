<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Todos;

class TodosController extends BaseController
{
	protected $helpers = ['form'];

	public function index()
	{
		$data = [];

		$model = new Todos();
		$data['interval_options'] = $model->getAvailableIntervals();

		echo view('templates/header', $data);
		echo view('todos/index');
		echo view('templates/footer');
	}
}
