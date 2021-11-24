<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Year;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class ClassController extends Controller
{

    private $class;

    function __construct(Classes $class)
    {
        $this->class = $class;
        $this->middleware('permission:class-list|class-create|class-edit|class-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:class-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:class-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:class-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param int $year_id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request, $year_id = 0)
    {
        $year = Classes::find($year_id);

        if ($request->ajax()) {
            $data = $this->class->with(['year'])->orderBy('name');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = btnEdit(route('classes.edit', $row->id), 'class-edit');
                    $btn .= btnDelete(route('classes.destroy', $row->id), 'class-delete');

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('classes.index', compact('year', 'year_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $years = Year::pluck('name', 'id')->all();
        return view('classes.create', compact('years'));
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
            'name' => 'required|unique:classes,name',
            'image' => 'required',
            'year_id' => 'required',
        ]);

        try {
            $class = $this->class->create($request->all());
            toast()->success(trans('sys.msg.success.save'))->width('25rem');

            return redirect()->route('classes.index');
        } catch (\Exception $e) {
            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.save'));
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($year_id)
    {
        $classes = Classes::where('year_id', $year_id)->get();
        $year = Year::find($year_id);
        return view('classes.show', compact('classes', 'year'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = $this->class->with('year')->find($id);
        $years = Year::pluck('name', 'id')->all();
        $year = Year::find($class->year_id);
        return view('classes.edit', compact('class', 'years'));
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
            'name' => "required|unique:classes,name,$id",
            'image' => 'required',
        ]);

        try {
            $class = $this->class->find($id);
            $class = $class->update($request->all());
            toast()->success(trans('sys.msg.success.update'))->width('25rem');

            return redirect()->route('classes.index');
        } catch (\Exception $e) {
            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.update'));
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $class = $this->class->find($id);
            $class->delete();

            toast()->success(trans('sys.msg.success.delete'))->width('25rem');

            return redirect()->route('classes.index');
        } catch (\Exception $e) {

            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.delete'));
            return back()->withInput();
        }
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            Storage::disk('local')->put('public/images/classes/' . $fileName, file_get_contents($request->file('upload')));

            return response()->json([
                'message' => 'Image uploaded successfully',
                'url' => asset('storage/images/classes/' . $fileName),
            ]);
        }
    }

    public function getYearClasses($year_id)
    {
        $classes = $this->class->select('id', 'name')->where('year_id', $year_id)->get();

        return response()->json($classes);
    }
}
