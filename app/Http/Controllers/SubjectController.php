<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    private $subject;

    function __construct(Subject $subject)
    {
        $this->subject = $subject;
        $this->middleware('permission:subject-list|subject-create|subject-edit|subject-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:subject-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subject-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subject-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param int $class_id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request, $class_id = 0)
    {
        $class = Classes::find($class_id);

        if ($request->ajax()) {
            $data = $this->subject->with('classe')
                ->when($class_id, function ($query, $class_id) {
                    return $query->where('class_id', $class_id);
                })->orderBy('name');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('year_class', function ($row) {
                    return $row->year_class;
                })
                ->addColumn('action', function ($row) use ($class_id) {

                    if ($class_id) {
                        $btn = "<a href='" . route('posts.indexList', $row->id) . "' class='btn btn-primary'>Conteúdos</a>";
                    } else {
                        $btn = btnEdit(route('subjects.edit', $row->id), 'subject-edit');
                        $btn .= btnDelete(route('subjects.destroy', $row->id), 'subject-delete');
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('subjects.index', compact('class_id', 'class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Classes::get()->pluck('year_class', 'id');
        return view('subjects.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => "required|unique:subjects,name,NULL,id,class_id,$request->class_id",
            'class_id' => 'required',
        ]);

        try {
            $subject = $this->subject->create($request->all());
            toast()->success(trans('sys.msg.success.save'))->width('25rem');

            return redirect()->route('subjects.index');
        } catch (\Exception $e) {
            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.save'));
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = $this->subject->find($id);
        $classes = Classes::get()->pluck('year_class', 'id');
        return view('subjects.edit', compact('subject', 'classes'));
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
        $this->validate($request, [
            'name' => "required|unique:subjects,name,$id,id,class_id,$request->class_id",
            'class_id' => 'required',
        ]);

        try {
            $subject = $this->subject->find($id);
            $subject = $subject->update($request->all());
            toast()->success(trans('sys.msg.success.update'))->width('25rem');

            return redirect()->route('subjects.index');
        } catch (\Exception $e) {
            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.update'));
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
            $class = $this->subject->find($id);
            $class->delete();

            toast()->success(trans('sys.msg.success.delete'))->width('25rem');

            return redirect()->route('subjects.index');
        } catch (\Exception $e) {

            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.delete'));
            return back()->withInput();
        }
    }

    public function getClasseSubjects($class_id)
    {
        $subjects = $this->subject->select('id', 'name')->where('class_id', $class_id)->get();

        return response()->json($subjects);
    }
}
