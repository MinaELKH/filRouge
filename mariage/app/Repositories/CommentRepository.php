<?php


namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\contracts\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function getById(int $id): ?Comment
    {
        return Comment::find($id);
    }

    public function getByService(int $serviceId)
    {
        return Comment::where('service_id', $serviceId)->get();
    }

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(Comment $comment, array $data): bool
    {
        return $comment->update($data);
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}
