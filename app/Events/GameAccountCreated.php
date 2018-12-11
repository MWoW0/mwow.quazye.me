<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameAccountCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameAccount;

    /**
     * GameAccountCreated constructor.
     *
     * @param $gameAccount
     */
    public function __construct($gameAccount)
    {
        $this->gameAccount = $gameAccount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("App.User.{$this->gameAccount->user_id}");
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->gameAccount->id,
            'account' => [
                'id' => $this->gameAccount->account_id,
                'name' => $this->gameAccount->account->username
            ],
            'realm' => [
                'id' => $this->gameAccount->realm_id,
                'name' => $this->gameAccount->realm->name,
                'address' => $this->gameAccount->realm->address,
            ]
        ];
    }
}
