<?php

namespace App\Events;

use App\Models\UserPost;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PostCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public UserPost $userPost;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserPost $userPost)
    {
        $this->userPost = $userPost;
    }
}
