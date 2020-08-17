<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $model;

    public function __constructor(User $user)
    {
        $this->model = $user;
    }
    public function getUsers()
    {
        return User::all();
    }

    public function getUser($user_id)
    {
        return User::findById($user_id)->first();
    }
}
