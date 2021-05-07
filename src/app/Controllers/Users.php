<?php

namespace App\Controllers;

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
				'firstname' => 'required|min_length[3]|max_length[50]',
				'lastname' => 'required|min_length[3]|max_length[50]',
				'email' => 'required|min_length[6]|max_length[100]|valid_email|is_unique[users.email]',
				'password' => 'required|min_length[8]|max_length[100]',
				'password_confirm' => 'matches[password]',
			];

			if ($this->validate($rules)) {

			}

			$data['validation'] = $this->validator;
		}

		echo view('templates/header', $data);
		echo view('users/register');
		echo view('templates/footer');
	}
}
