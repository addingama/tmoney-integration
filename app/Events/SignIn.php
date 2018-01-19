<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignIn {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $email;
	public $password;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($email, $password) {
		$this->email = $email;
		$this->password = $password;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn() {
		return new PrivateChannel('channel-name');
	}
}
