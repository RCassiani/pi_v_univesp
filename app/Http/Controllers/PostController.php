<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $subject_id
     * @return \Illuminate\Http\Response
     */
    public function index($subject_id = 0)
    {
        $subject = Subject::find($subject_id);

        $posts = Post::with('subject')
            ->when($subject, function ($query, $subject) {
                return $query->where('subject_id', $subject->id);
            })
            ->latest()
            ->get();

        return view('posts.index', compact('posts', 'subject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $years = Year::pluck('name', 'id')->all();
        return view('posts.create', compact('years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        Post::create($input);

        toast()->success(trans('sys.msg.success.save'))->width('25rem');

        return redirect()->route('posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        $notifications = auth()->user()->notifications()->get();
        foreach ($notifications as $notification) {
            if ($notification->data["post"]["id"] == $id) {
                $notification->markAsRead();
            }
        }

        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $classes = Classes::pluck('name', 'id')->all();
        $years = Year::pluck('name', 'id')->all();
        return view('posts.create', compact('post', 'classes', 'years'));
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images/posts'), $fileName);

            return response()->json([
                'message' => 'Image uploaded successfully',
                'url' => asset('images/posts/' . $fileName),
            ]);
        }
    }
}
