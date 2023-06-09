<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\User;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        if (auth()->user()->role !== 1)
            return redirect()->route('main');

        $users = User::all();

        return view('users.index', compact('users'));
    }
}
