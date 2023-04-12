<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class CreateController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */

    public function __invoke()
    {
        $user = new User();

        $roles = $user->getRoles();

        return view('users.create', compact('roles'));
    }
}