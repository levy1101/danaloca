<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div id="commentsList">
@foreach($post->comments as $comment)
        <div class="comment" id="comment-{{ $comment->id }}">
            <strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
            <br><small>{{ $comment->created_at->diffForHumans() }}</small>
            @if($comment->user_id === Auth::id())
                <button class="delete-comment-btn" data-comment-id="{{ $comment->id }}">Delete</button>
            @endif
        </div>
    @endforeach
</div>

<form id="commentForm">
    @csrf
    <input type="hidden" id="post_id" value="{{ $post->id }}">
    <textarea id="content" name="content" required></textarea>
    <button type="submit">Add Comment</button>
</form>

<script>
    $(document).ready(function() {
        // Thêm bình luận mới
        $('#commentForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '{{ route("comments.store") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    post_id: $('#post_id').val(),
                    content: $('#content').val()
                },
                success: function(response) {
                    // Thêm bình luận vào danh sách
                    $('#commentsList').append(`
                        <div class="comment" id="comment-${response.comment.id}">
                            <strong>${response.comment.user}</strong>: ${response.comment.content}
                            <br><small>${response.comment.created_at}</small>
                            <button onclick="deleteComment(${response.comment.id})">Delete</button>
                        </div>
                    `);
                    $('#content').val(''); // Xóa nội dung nhập sau khi gửi
                },
                error: function(xhr) {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });

    // Xóa bình luận
    function deleteComment(commentId) {
        $.ajax({
            type: 'DELETE',
            url: '{{ route("comments.destroy") }}',
            data: {
                _token: '{{ csrf_token() }}',
                comment_id: commentId
            },
            success: function(response) {
                // Xóa bình luận khỏi danh sách
                $('#comment-' + response.comment_id).remove();
            },
            error: function(xhr) {
                alert("An error occurred. Please try again.");
            }
        });
    }
</script>

</body>
</html>
