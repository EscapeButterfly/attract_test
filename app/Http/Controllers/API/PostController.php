<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\CreatePostRequest;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function create(CreatePostRequest $request): JsonResponse
    {
        $post = $this->postService->create($request->validated());
        return response()->json([
            'data' => $post
        ], 201);
    }

    public function hot(): JsonResponse
    {
        $posts = $this->postService->getMostCommentedPosts();
        return response()->json(['data' => $posts]);
    }

    public function addComment(AddCommentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->postService->addComment($data);
        return response()->json([
            'message' => 'OK'
        ], 201);
    }

    public function getComments($post_id): JsonResponse
    {
        $comments = $this->postService->getComments($post_id);
        return response()->json(['data' => $comments]);
    }
}
