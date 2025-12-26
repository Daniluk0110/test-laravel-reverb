<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    // Принимаем сообщение при создании события
    public function __construct($message)
    {
        $this->message = $message;
    }

    // Определяем канал. Пусть это будет публичный канал 'public-chat'
    public function broadcastOn(): array
    {
        return [
            new Channel('public-chat'),
        ];
    }
}
