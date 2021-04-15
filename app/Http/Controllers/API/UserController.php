<?php

namespace App\Http\Controllers\API;


use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\SubscribeRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile($user_id): UserResource
    {
        return new UserResource($this->userService->getProfile($user_id));
    }

    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->userService->subscribe($data);
        return response()->json([
            'message' => 'OK'
        ], 201);
    }
}
