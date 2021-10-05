<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    private $types = [
        1 => 'Texto',
        2 => 'Vídeo',
        3 => 'Arquivo',
    ];

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

        $posts = ($subject_id)
            ? Post::where('subject_id', $subject_id)->latest()->get()
            : Post::with('subject')->latest()->get();

        return view('posts.index', compact('posts', 'subject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Classes::pluck('name', 'id')->all();
        $types = $this->types;
        return view('posts.create', compact('classes', 'types'));
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
        return view('posts.create', compact('post', 'classes', 'types'));
    }
}
