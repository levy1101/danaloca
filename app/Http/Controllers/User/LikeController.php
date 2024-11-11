<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\User;

class LikeController extends Controller
{
    // Phương thức thêm hoặc cập nhật Like
    public function index(Request $request)
    {
        $like = Like::where('user_id', Auth::id())
                    ->where('post_id', $request->post_id)
                    ->first();

        if (!$like) {
            // Nếu chưa có bản ghi Like, tạo mới
            $like = new Like();
            $like->user_id = Auth::id();
            $like->post_id = $request->post_id;
            $like->like = $request->isLike;
            $like->save();
        } else {
            // Nếu đã có bản ghi Like, cập nhật
            $like->like = $request->isLike;
            $like->save();
        }

        return response()->json([
            'post_id' => $request->post_id
        ]);
    }

    // Phương thức xử lý Like hoặc Unlike
    public function like(Request $request)
    {
        $post_id = $request->postId;
        $is_like = filter_var($request->isLike, FILTER_VALIDATE_BOOLEAN);
        $post = Post::find($post_id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();

        if ($like) {
            if ($like->like == $is_like) {
                // Nếu đã like hoặc unlike rồi thì xóa bản ghi
                $like->delete();
                return response()->json(['message' => 'Like removed'], 200);
            } else {
                // Nếu có sự khác biệt, cập nhật like
                $like->like = $is_like;
                $like->save();
                return response()->json(['message' => 'Like updated'], 200);
            }
        } else {
            // Nếu chưa có bản ghi, tạo mới
            $newLike = new Like();
            $newLike->like = $is_like;
            $newLike->user_id = $user->id;
            $newLike->post_id = $post_id;
            $newLike->save();

            return response()->json(['message' => 'Like added'], 201);
        }
    }
}
