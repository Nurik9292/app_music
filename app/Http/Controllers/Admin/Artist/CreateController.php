<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CreateController extends Controller
{
    public function __invoke()
    {
        $countries = Country::all();

        return view('artist.create', compact('countries'));
    }
}