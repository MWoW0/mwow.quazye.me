<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'created_at' => $this->created_at->toDayDateTimeString(),
            'updated_at' => $this->updated_at->toDayDateTimeString(),

            'author_id' => $this->author_id,
            'author' => $this->whenLoaded('author'),

            'auth' => [
                'canUpdate' => Gate::forUser($request->user())->allows('update', $this->resource),
                'canDelete' => Gate::forUser($request->user())->allows('delete', $this->resource),
            ]
        ];
    }
}
