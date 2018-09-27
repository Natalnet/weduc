<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserCollection;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $users = User::all();

        return new UserCollection($users);
    }
}
