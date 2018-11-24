<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class GameAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'account' => $this->whenLoaded('account', function () {
                return new AccountResource($this->resource->account);
            }),
            'realm' => $this->whenLoaded('realm', function () {
                return new RealmResource($this->resource->realm);
            })
        ];
    }
}
