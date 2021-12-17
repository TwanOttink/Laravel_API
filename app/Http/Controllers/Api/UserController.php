<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getAllUsers() {
        $users = User::get()->toJson(JSON_PRETTY_PRINT);
        return response($users, 200);
    }

    public function getUser($id) {
        $users = User::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($users, 200);
    }
}
