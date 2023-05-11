<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\User;
use Owenoj\LaravelGetId3\GetId3;
use UConverter;

// use getID3;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }
}