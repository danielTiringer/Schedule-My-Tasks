<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
	public function login()
	{
		$data = [];
		helper(['form']);

		echo view('templates/header', $data);
		echo view('users/login');
		echo view('templates/footer');
	}

	public function register()
	{
		$data = [];
		helper(['form']);

		if ($this->request->getMethod() === 'post') {
			$rules = [
				'first_name' => 'required|min_length[3]|max_length[50]',
				'last_name' => 'required|min_length[3]|max_length[50]',
				'email' => 'required|min_length[6]|max_length[100]|valid_email|is_unique[users.email]',
				'password' => 'required|min_length[8]|max_length[100]',
				'password_confirm' => 'matches[password]',
			];

			if ($this->validate($rules)) {
				$model = new UserModel();

				$sanitizedData = [
					'first_name' => $this->request->getVar('first_name'),
					'last_name' => $this->request->getVar('last_name'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
				];
				$model->save($sanitizedData);

				$session = session();
				$session->setFlashData('success', 'Successfully registered');

				return redirect()->to('/login');
			}

			$data['validation'] = $this->validator;
		}

		echo view('templates/header', $data);
		echo view('users/register');
		echo view('templates/footer');
	}
}
