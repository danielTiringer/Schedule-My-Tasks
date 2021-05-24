<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ErrorsController extends BaseController
{
    public function show404()
    {
        $data = [];

        echo view('templates/header', $data);
        echo view('errors/html/error_404');
        echo view('templates/footer');
    }
}
