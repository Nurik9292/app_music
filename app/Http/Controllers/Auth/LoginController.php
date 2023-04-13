<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) return redirect()->route('main');

        return view('auth.login');
    }

    public function login(Request $request)
    {
        dd($request->only('email', 'password'));
    }
}