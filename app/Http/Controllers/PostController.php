<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Post;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $subject_id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $subject_id = 0)
    {
        $subject = Subject::find($subject_id);

        if ($request->ajax()) {
            $data = Post::with('subject')
                ->when($subject, function ($query, $subject) {
                    return $query->where('subject_id', $subject->id);
                })
                ->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('year_class_subject', function ($row) {
                    return $row->subject->year_class . " - " . $row->subject->name;
                })
                ->addColumn('action', function ($row) use ($subject_id) {

                    if ($subject_id) {
                        $btn = "<a href='" . route('posts.show', $row->id) . "' class='btn btn-primary'>Visualizar</a>";
                    } else {
                        $btn = btnEdit(route('posts.edit', $row->id), 'post-edit');
                        $btn .= btnDelete(route('posts.destroy', $row->id), 'post-delete');
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('posts.index', compact('subject', 'subject_id'));
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
        $post = Post::with('subject')->find($id);

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
