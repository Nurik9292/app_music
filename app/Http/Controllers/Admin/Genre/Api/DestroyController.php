<?php

namespace App\Http\Controllers\Admin\Genre\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class DestroyController extends Controller
{
    public function __invoke(Genre $genre, User $user)
    {
        $genre->delete();

        $audit =  Audit::latest()->first();

        // $audit->update(['user_type' => 'App\Model\User', 'user_id' => $user->id]);

        return response([]);
    }
}