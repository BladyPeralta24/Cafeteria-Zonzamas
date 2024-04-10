<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->createUser($request->all());
        return redirect()->route('users.index');
    }

    public function index()
    {
        $users = (new User())->getUsers();
        return view('users.index', ['users' => $users]);
    }
}
