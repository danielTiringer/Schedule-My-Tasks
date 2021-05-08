<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TodosController extends BaseController
{
	protected $helpers = ['form'];

	public function index()
	{
		$data = [];

		echo view('templates/header', $data);
		echo view('todos/index');
		echo view('templates/footer');
	}
}
