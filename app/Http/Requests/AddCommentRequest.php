<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_id'   => 'required|exists:user_posts,id',
            'comment'   => 'required|string',
            'parent_id' => 'exists:post_comments,id|hierarchy_lvl'
        ];
    }
}
