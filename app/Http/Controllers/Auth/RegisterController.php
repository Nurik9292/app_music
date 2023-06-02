<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {

        return view('auth.register');
    }

    public function register(Request $request)
    {

        $data = $request->validate([
            'name' => ['required', 'string', 'max:64'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:system_users'],
            'password' => ['required', 'string', 'min:6', 'max:16'],
            'role' => ['required', 'numeric'],
        ]);

        User::create($data);

        return redirect()->route('user.index');
    }
}
