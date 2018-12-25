<?php

namespace App\Http\Controllers;

use App\Realm;
use Illuminate\Http\Request;

class ShowWelcome extends Controller
{
    public function __invoke(Request $request)
    {
        return view('welcome')
            ->with('realms', Realm::query()->get());
    }
}
