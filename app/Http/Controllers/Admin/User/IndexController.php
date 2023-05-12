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

        $stat = 'dfsdfdsf/dfsfsdfsd/fsdsdfsdfsdf/dfsdfsdf/dfsd//';

        $res = preg_replace('/(\/)(?=\1)/', '', $stat);

        dd($res);

        return view('users.index', compact('users'));
    }
}