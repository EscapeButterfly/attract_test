<?php

namespace App\Mail;

use App\Events\PostCreated;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPost extends Mailable
{
    use Queueable, SerializesModels;

    private User $user;
    private PostCreated $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, PostCreated $event)
    {
        $this->user  = $user;
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //TODO build email with view or whatever you need
        return $this;
    }
}
