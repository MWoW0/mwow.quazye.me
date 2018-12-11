<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\GameAccountResource;
use App\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ListGameAccounts extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $this->validate($request, [
            'player_id' => 'required|exists:users,id',
            'page' => 'nullable|integer|min:0',
            'perPage' => 'nullable|integer|min:1|max:50',
            'pageName' => 'nullable|string'
        ]);

        /** @var User $user */
        $user = User::query()->find($validated['player_id']);

        $this->authorize('view', $user);

        $accounts = QueryBuilder::for($user->gameAccounts()->getQuery(), $request)
            ->paginate(
                $validated['perPage'] ?? 15,
                ['*'],
                $validated['pageName'] ?? 'page',
                $validated['page'] ?? 0
            );

        return GameAccountResource::collection($accounts);
    }
}
