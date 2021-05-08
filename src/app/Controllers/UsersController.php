<?php

namespace App\Controllers;

use App\Models\Users;

class UsersController extends BaseController
{
	protected $helpers = ['form'];

	public function login()
	{
		$data = [];

		if ($this->request->getMethod() === 'post') {
			$rules = [
				'email' => 'required|min_length[6]|max_length[100]|valid_email',
				'password' => 'required|min_length[8]|max_length[100]|validateUser[email,password]',
			];

			$errors = [
				'password' => [
					'validateUser' => 'Email and password combination don\'t match',
				],
			];

			if ($this->validate($rules, $errors)) {
				$model = new Users();

				$user = $model->where('email', $this->request->getVar('email'))->first();

				if ($user) {
					$this->setUserSession($user);

					return redirect()->to('/');
				}
			}

			$data['validation'] = $this->validator;
		}

		echo view('templates/header', $data);
		echo view('users/login');
		echo view('templates/footer');
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to('/login');
	}

	public function register()
	{
		$data = [];

		if ($this->request->getMethod() === 'post') {
			$rules = [
				'first_name' => 'required|min_length[3]|max_length[50]',
				'last_name' => 'required|min_length[3]|max_length[50]',
				'email' => 'required|min_length[6]|max_length[100]|valid_email|is_unique[users.email]',
				'password' => 'required|min_length[8]|max_length[100]',
				'password_confirm' => 'matches[password]',
			];

			if ($this->validate($rules)) {
				$model = new Users();

				$sanitizedData = [
					'first_name' => $this->request->getVar('first_name'),
					'last_name' => $this->request->getVar('last_name'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
				];
				$model->save($sanitizedData);

				session()->setFlashData('success', 'Successfully registered');

				return redirect()->to('/login');
			}

			$data['validation'] = $this->validator;
		}

		echo view('templates/header', $data);
		echo view('users/register');
		echo view('templates/footer');
	}

	public function profile()
	{
		$data = [];
		$model = new Users();

		if ($this->request->getMethod() === 'post') {
			$rules = [
				'first_name' => 'required|min_length[3]|max_length[50]',
				'last_name' => 'required|min_length[3]|max_length[50]',
			];

			if ($this->request->getPost('password') != '') {
				$rules['password'] = 'required|min_length[8]|max_length[100]';
				$rules['password_confirm'] = 'matches[password]';
			}

			if ($this->validate($rules)) {

				$sanitizedData = [
					'id' => session()->get('id'),
					'first_name' => $this->request->getVar('first_name'),
					'last_name' => $this->request->getVar('last_name'),
				];
				if ($this->request->getPost('password') != '') {
					$sanitizedData['password'] = $this->request->getVar('password');
				}

				$model->save($sanitizedData);

				session()->setFlashData('success', 'Successfully updated');

				return redirect()->to('/profile');
			}

			$data['validation'] = $this->validator;
		}

		$data['user'] = $model->where('id', session()->get('id'))->first();

		echo view('templates/header', $data);
		echo view('users/profile');
		echo view('templates/footer');
	}

	private function setUserSession(array $user)
	{
		$data = [
			'id' => $user['id'],
			'first_name' => $user['first_name'],
			'last_name' => $user['last_name'],
			'email' => $user['email'],
			'isLoggedIn' => true,
		];
		session()->set($data);
	}
}
