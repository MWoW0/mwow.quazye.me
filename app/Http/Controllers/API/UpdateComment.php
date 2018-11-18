<?php

namespace App\Http\Controllers\API;

use App\Comment;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateComment extends Controller
{
    public function __invoke(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $this->validate($request, [
            'title' => 'nullable|string|min:3|max:254',
            'body' => 'string|min:3|max:254'
        ]);

        $comment->update($validated);

        return CommentResource::make($comment->loadMissing('author'));
    }
}
