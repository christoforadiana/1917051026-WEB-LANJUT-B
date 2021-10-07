<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TemplatingRegister extends BaseController
{
    public function index()
    {
        // $data = ['title' => 'Register'];
        return view('v_register');
    }
}
