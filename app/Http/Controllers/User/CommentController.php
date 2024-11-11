<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'exists:posts,id|numeric',
            'comment' => 'required|max:255'
        ]);
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->post_id;
        $comment->save();

        // Session::flash('success', 'Your comment was succesffuly added');
        return redirect()->back();
    }
    // Phương thức thêm bình luận
    public function store(Request $request)
{
    $request->validate([
        'post_id' => 'required|exists:posts,id',
        'comment' => 'required|string|max:255',
    ]);

    $comment = Comment::create([
        'post_id' => $request->post_id,
        'user_id' => auth()->id(),
        'content' => $request->comment,
    ]);

    return response()->json([
        'comment' => [
            'id' => $comment->id,
            'content' => $comment->content,
            'user' => auth()->user()->name,
            'created_at' => $comment->created_at->diffForHumans(),
        ],
    ]);
}


    // Phương thức xóa bình luận
    public function destroy(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        $comment = Comment::find($request->comment_id);

        // Kiểm tra xem bình luận có thuộc về người dùng hiện tại không
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
            'comment_id' => $request->comment_id,
        ]);
    }
}
