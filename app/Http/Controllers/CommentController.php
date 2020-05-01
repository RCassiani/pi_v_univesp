<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentPost;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $post = Post::findOrFail($request->post_id);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        $comment = Comment::create($input);

        if ($post->user_id != $comment->user_id) {
            $user = User::find($post->user_id);
            $user->notify(new NewCommentPost($comment));
        }

        if (isset($comment->parent_id)) {
            $reply = Comment::find($comment->parent_id);
            if ($reply->user_id != $comment->user_id) {
                $user = User::find($reply->user_id);
                $user->notify(new NewCommentPost($comment));
            }
        }

        toast()->success(trans('sys.msg.success.save'))->width('25rem');

        return back();
    }

    public function markNotifAsRead(Request $request)
    {
        $notificationid = $request->notif_id;
        $notification = auth()->user()->notifications()->find($notificationid);
        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json([
            'success' => true,
            'notification' => $notification
        ]);
    }
}
