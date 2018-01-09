<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class SignUp
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $password;
    public $fullname;
    public $phone;

    /**
     * Create a new event instance.
     * @param $email
     * @param string $password
     * @param string $fullname
     * @param string $phone
     */
    public function __construct($email, $password = '', $fullname = '', $phone = '')
    {
        $this->email = $email;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->phone = $phone;

        Log::info('[EVENT] SignUp');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
