<?php

namespace App\Events;

use App\Models\Order;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Memakai BroadcastNow
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $order;
    public $user;

    // Pastikan constructor menerima 2 parameter sesuai pendaftaran di Controller
    public function __construct(Order $order, User $user = null)
    {
        $this->order = $order;
        $this->user = $user ?? auth()->user();
    }

    public function broadcastOn(): array
    {
        // Pastikan menembak ke ID User yang sedang login / menerima notif
        return [
            new PrivateChannel('user.' . $this->user->id),
        ];
    }

    // Nama alias event (opsional agar nama event di Echo bersih)
    public function broadcastAs(): string
    {
        return 'OrderPlaced';
    }
}