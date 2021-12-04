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

        if (isset($comment->parent_id)) {
            $reply = Comment::find($comment->parent_id);
            if ($reply->user_id != $comment->user_id) {
                $user = User::find($reply->user_id);
                $user->notify(new NewCommentPost($comment));
            }
        }elseif ($post->user_id != $comment->user_id) {
            $user = User::find($post->user_id);
            $user->notify(new NewCommentPost($comment));
        }

        toast()->success(trans('sys.msg.success.comment.insert'))->width('25rem');

        return redirect("/posts/{$post->id}");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'body' => 'required',
        ]);

        try {
            $comment = Comment::find($id);
            $post_id = $comment->post_id;
            $comment = $comment->update(['body' => $request->body]);
            toast()->success(trans('sys.msg.success.update'))->width('25rem');

            return redirect()->route('posts.show', $post_id);
        } catch (\Exception $e) {
            alert()->error(trans('sys.msg.alert-error'), $e);
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $child_comments = Comment::where('parent_id', $id);
            $child_comments->delete();
            $comment = Comment::find($id);
            $comment->delete();

            toast()->success(trans('sys.msg.success.delete'))->width('25rem');

            return redirect()->route('posts.show', $comment->post_id);
        } catch (\Exception $e) {

            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.delete'));
            return back()->withInput();
        }
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

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            return response()->json([
                'message' => 'Image uploaded successfully',
                'url' => asset('images/' . $fileName),
            ]);
        }
    }
}
