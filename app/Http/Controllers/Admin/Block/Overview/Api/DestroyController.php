<?php

namespace App\Http\Controllers\Admin\Block\Overview\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockShema;
use App\Models\User;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class DestroyController extends Controller
{
    public function __invoke(BlockShema $block, User $user)
    {
        $block->delete();

        $audit =  Audit::latest()->first();

        $audit->update(['user_type' => 'App\Model\User', 'user_id' => $user->id]);

        return response([]);
    }
}
