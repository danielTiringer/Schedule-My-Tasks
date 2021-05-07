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

		echo view('templates/header', $data);
		echo view('users/register');
		echo view('templates/footer');
	}
}
