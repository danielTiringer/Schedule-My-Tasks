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

		if ($this->request->getMethod() === 'post') {
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

				return redirect()->to('/todos');
			}

			$data['validation'] = $this->validator;
		}

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

		$todo = $model->find($id);

		if ($this->request->getMethod() === 'put') {
			$rules = [
				'description' => 'required|min_length[6]|max_length[100]',
				'interval' => 'required',
				'status' => 'required',
			];

			if ($this->validate($rules)) {
				$sanitizedData = [
					'id' => $id,
					'description' => $this->request->getVar('description'),
					'interval' => $this->request->getVar('interval'),
					'status' => $this->request->getVar('status'),
				];

				$model->save($sanitizedData);

				session()->setFlashData('success', 'Successfully updated');

				return redirect()->to('/todos');
			}

			$data['validation'] = $this->validator;
		}

		$data['todo'] = $todo;
		$data['interval_options'] = $model->getAvailableIntervals();
		$data['status_options'] = [
			'active',
			'inactive',
		];

		echo view('templates/header', $data);
		echo view('todos/edit');
		echo view('templates/footer');
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
