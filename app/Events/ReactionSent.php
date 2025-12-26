<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReactionSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $type; // Сюда запишем 'heart', 'fire' и т.д.

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function broadcastOn(): array
    {
        // Используем отдельный канал для реакций
        return [
            new Channel('reactions'),
        ];
    }
}
