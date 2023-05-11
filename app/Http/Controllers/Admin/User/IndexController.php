<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
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

        // $res = preg_replace('/\/{2,}/', '', 'dsdfsdfsd//dfsdfsdf///dfdfsdf/fsdfsd');
        $res = preg_replace('/(\/)(?=\1)/', '', 'dsdfsdfsd//dfsdfsdf///dfdfsdf/fsdfsd');




        dd($res);

        return view('users.index', compact('users'));
    }
}