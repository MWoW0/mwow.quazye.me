<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrentUserResource;
use Illuminate\Http\Request;

class ShowCurrentUser extends Controller
{
    public function __invoke(Request $request)
    {
        CurrentUserResource::withoutWrapping();

        return new CurrentUserResource($request->user());
    }
}
