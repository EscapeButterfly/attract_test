<?php


namespace App\Services;


use Carbon\Carbon;
use App\Models\UserPost;
use App\Models\PostComment;
use Illuminate\Contracts\Pagination\Paginator;

class PostService
{
    public function create(array $data)
    {
        return UserPost::query()->create([
            'user_id' => auth()->user()->id,
            'topic'   => $data['topic'],
            'body'    => $data['body']
        ]);
    }

    public function getMostCommentedPosts()
    {
        return UserPost::query()
            ->withCount('comments')
            ->whereHas('comments', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subHours(24));
            })
            ->orderBy('comments_count', 'desc')
            ->take(10)
            ->get();
    }

    public function addComment(array $data)
    {
        $postComment          = new PostComment();
        $postComment->post_id = $data['post_id'];
        $postComment->user_id = auth()->user()->id;
        $postComment->comment = $data['comment'];
        if (array_key_exists('parent_id', $data)) $postComment->parent_id = $data['parent_id'];
        $postComment->save();
    }

    public function getComments(int $post_id): Paginator
    {
        return PostComment::query()
            ->where('post_id', $post_id)
            ->whereNull('parent_id')
            ->with('childComments')
            ->simplePaginate(50);
    }
}
