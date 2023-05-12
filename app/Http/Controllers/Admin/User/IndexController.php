<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;

// use getID3;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $users = User::all();

        $data = ['d', '2', '1', '2'];

        return view('users.index', compact('users'));
    }
}