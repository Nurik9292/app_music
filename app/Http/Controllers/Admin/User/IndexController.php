<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\BlockShema;
use App\Models\Track;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $users = User::all();

        $track = Track::where('id', 50)->get();

        return view('users.index', compact('users'));
    }
}
