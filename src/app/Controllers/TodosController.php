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

		$model = model('Todos', false);

		$data['validation'] = $this->validator;
		$data['todos'] = $model->getAllTodosOfUser(session()->get('id'));
		$data['interval_options'] = $model->getAvailableIntervals();

		echo view('templates/header', $data);
		echo view('todos/index');
		echo view('templates/footer');
	}

	public function store()
	{
		$model = model('Todos', false);

		$rules = [
			'description' => 'required|min_length[6]|max_length[100]',
			'interval' => 'required',
		];

		if ($this->validate($rules)) {
			$sanitizedData = [
				'description' => $this->request->getVar('description'),
				'interval' => $this->request->getVar('interval'),
				'users_id' => session()->get('id'),
			];

			$model->save($sanitizedData);

			session()->setFlashData('success', 'Todo successfully added');
		}

		return redirect()->to('/todos');
	}

	public function edit(int $id = null)
	{
		$data = [];

		$model = model('Todos', false);
		$data['interval_options'] = $model->getAvailableIntervals();

		$todo = $model->find($id);
		$data['todo'] = $todo;

		echo view('templates/header', $data);
		echo view('todos/edit');
		echo view('templates/footer');
	}

	public function update(int $id = null)
	{

	}

	public function destroy(int $id = null)
	{
		$model = model('Todos', false);

		if ($todo = $model->where('id', $id)->delete()) {
			session()->setFlashData('success', 'Todo successfully deleted');
		}

		return redirect()->to('/todos');
	}
}
