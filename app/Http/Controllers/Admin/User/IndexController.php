<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\BlockShema;
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


        if (count(BlockShema::where('order_number', '2')->get()) > 0)
            $blocks = BlockShema::where('order_number', '>=', 2)->get();

        // foreach ($blocks as $block) $block->increment("order_number");

        dd($blocks);

        return view('users.index', compact('users'));
    }
}