<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Profile extends BaseController
{
    public function index()
    {
        // Example: get user info from session or model
        $user = session('user');
        return view('profile/index', ['user' => $user]);
    }
}
