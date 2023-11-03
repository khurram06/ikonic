<?php

namespace App\Facades\Project;

use App\Models\Comment;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackService
{
    protected $feedBacks;

    public function __construct()
    {
        $this->feedBacks = Feedback::query();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->feedBacks->with(['user'])
            ->withCount(['votes'])
            ->paginate(5);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
     */
    public function getById($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->feedBacks->with('comments.user') ->withCount(['votes'])->find($id);
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function fill($data): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        return $this->feedBacks->create($data);
    }

    /**
     * @param $data
     * @return Comment
     */
    public function fillComments($data): Comment
    {
        $comment = new Comment();
        $comment->message = $data['message'];
        $comment->feedback_id = $data['feedback']['id'];
        $comment->user_id = Auth::user()->id;
        $comment->save();
        return $comment;
    }
}
