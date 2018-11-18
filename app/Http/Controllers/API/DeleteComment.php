<?php

namespace App\Http\Controllers\API;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteComment extends Controller
{
    public function __invoke(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
    }
}
