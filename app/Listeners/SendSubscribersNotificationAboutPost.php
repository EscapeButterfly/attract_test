<?php

namespace App\Listeners;

use App\Mail\NewPost;
use App\Events\PostCreated;
use App\Models\UserSubscriber;
use Illuminate\Support\Facades\Mail;

class SendSubscribersNotificationAboutPost
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PostCreated $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        UserSubscriber::query()
            ->where('subscribed_id', $event->userPost->user_id)
            ->chunkById(50, function ($userSubscribers) use ($event) {
                foreach ($userSubscribers as $userSubscriber) {
                    $user = $userSubscriber->user;
                    Mail::to($user)->queue(new NewPost($user, $event));
                }
            });
    }
}
