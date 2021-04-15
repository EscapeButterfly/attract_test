<?php


namespace App\Services;


use App\Models\User;
use App\Models\UserSubscriber;


class UserService
{
    public function create(array $data)
    {
        return User::query()->create($data);
    }

    public function verifyUser(int $user_id)
    {
        $user = User::query()->findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    }

    public function getProfile(int $user_id)
    {
        return User::query()->withCount(['subscribers', 'posts'])->find($user_id);
    }

    public function subscribe(array $data)
    {
        $user                          = auth()->user();
        $userSubscriber                = new UserSubscriber();
        $userSubscriber->user_id       = $user->id;
        $userSubscriber->subscribed_id = $data['user_id'];
    }
}
