<?php
namespace Models\App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Vinkla\Pusher\PusherManager;

class Pushmanager extends Authenticatable
{
    protected $pusher;

    public function __construct(PusherManager $pusher)
    {
        $this->pusher = $pusher;
    }

    public function bar()
    {
        $this->pusher->trigger('my-channel', 'my-event', ['message' => $message]);
    }
}
