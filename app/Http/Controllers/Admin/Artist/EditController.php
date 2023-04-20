<?php

namespace App\Http\Controllers\Admin\Artist;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Country;

class EditController extends Controller
{
    public function __invoke(Artist $artist)
    {
        $countries = Country::all();

        return view('artist.edit', compact('artist', 'countries'));
    }
}