@extends('layouts.user')

@section('content')
    <?php
    // dd($posts);
    ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

           
$(document).ready(function() {
    // Thêm bình luận mới
    $('.comment-form').on('submit', function(e) {
        e.preventDefault(); // Ngăn chặn làm mới trang

        var form = $(this); // Lưu form để sử dụng sau
        var postId = form.find('input[name="post_id"]').val();
        var commentContent = form.find('input[name="comment"]').val();

        $.ajax({
            type: 'POST',
            url: '{{ url('/comment') }}', // URL của route để thêm bình luận
            data: {
                _token: '{{ csrf_token() }}', // CSRF token
                post_id: postId,
                comment: commentContent
            },
            success: function(response) {
                // Thêm bình luận vào danh sách
                var commentHtml = `
                    <div class="text-white" id="comment-${response.comment.id}" style="margin: 0; border-radius: 0;">
                        <div class="panel-body row">
                            <div class="col-sm-2 profile-photo">
                                <img src="{{ Auth::user()->avatar }}">
                            </div>
                            <div class="col-sm-10">
                                <span>
                                    <p>{{ Auth::user()->name }}: &nbsp; ${response.comment.content}</p>
                                    <button class="delete-comment-btn" data-comment-id="${response.comment.id}">Delete</button>
                                </span>
                            </div>
                        </div>
                    </div>`;
                
                // Thêm bình luận mới vào phần bình luận
                $('.feed[data-postid="' + postId + '"] .comments').append(commentHtml);

                // Xóa giá trị trong ô nhập
                form.find('input[name="comment"]').val('');
            },
            error: function(xhr) {
                alert("Đã xảy ra lỗi. Vui lòng thử lại.");
            }
        });
    });

    // Xóa bình luận
    $(document).on('click', '.delete-comment-btn', function() {
        var commentId = $(this).data('comment-id');
        var commentDiv = $('#comment-' + commentId); // Lấy div của bình luận

        $.ajax({
            type: 'DELETE',
            url: '{{ route("comments.destroy") }}', // URL để xóa bình luận
            data: {
                _token: '{{ csrf_token() }}', // CSRF token
                comment_id: commentId
            },
            success: function(response) {
                // Xóa bình luận khỏi danh sách
                commentDiv.remove();
            },
            error: function(xhr) {
                alert("Đã xảy ra lỗi. Vui lòng thử lại.");
            }
        });
    });
});

</script>




    <style>
        .left .sidebar .activeup {
            background: var(--color-light);
        }

        #menu-home h3 {
            color: var(--color-primary);
        }

        .left .sidebar #menu-home::before {
            content: "";
            display: block;
            width: 0.5rem;
            height: 100%;
            position: absolute;
            background: var(--color-primary);
            border-radius: 100% 0% 0% 0% / 0.5rem 0% 10% 0%;
        }

        .left .sidebar .menu-item:first-child #menu-home {
            border-top-left-radius: var(--card-border-radius);
            overflow: hidden;
        }

        .left .sidebar .menu-item:last-child #menu-home {
            border-bottom-left-radius: var(--card-border-radius);
            overflow: hidden;
        }
    </style>
    <div class="middle">
        <livewire:add-posts />
        <livewire:fetch-posts />
    </div>
@endsection
