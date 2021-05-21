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
			$newTodo = [
				'description' => $this->request->getVar('description'),
				'interval' => $this->request->getVar('interval'),
				'users_id' => session()->get('id'),
			];

			if ($model->save($newTodo)) {
				session()->setFlashData('success', 'Todo successfully added');

				return redirect()->to('/todos');
			}

			$data['errors'] = $model->errors();
		}

		$data['todos'] = $model->getAllTodosOfUser(session()->get('id'));
		$data['interval_options'] = $model->getAvailableIntervals();

		echo view('templates/header', $data);
		echo view('todos/index');
		echo view('templates/footer');
	}

	public function edit(int $id = null)
	{
		$data = [];

		$model = model('Todos', false);

		$todo = $model->find($id);

		if ($this->request->getMethod() === 'put') {
			$updatedTodo = [
				'id' => $id,
				'description' => $this->request->getVar('description'),
				'interval' => $this->request->getVar('interval'),
				'status' => $this->request->getVar('status'),
			];

			if ($model->save($updatedTodo)) {
				session()->setFlashData('success', 'Successfully updated');

				return redirect()->to('/todos');
			}

			$data['errors'] = $model->errors();
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

		if ($model->where('id', $id)->delete()) {
			session()->setFlashData('success', 'Todo successfully deleted');
		}

		return redirect()->to('/todos');
	}
}
