<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CurrentUserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class UpdateCurrentUser extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'string|min:3|max:254',
            'email' => ['email', Rule::unique('users', 'email')->ignoreModel($request->user())],
            'country' => 'string',
            'city' => 'string',
            'zip' => 'string',
            'biography' => 'max:65535',
            'goals' => 'max:65535'
        ]);

        $request->user()->update($validated);

        return new CurrentUserResource($request->user());
    }
}
