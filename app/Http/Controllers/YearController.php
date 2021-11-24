<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class YearController extends Controller
{
    private $year;

    function __construct(Year $year)
    {
        $this->year = $year;
        $this->middleware('permission:year-list|year-create|year-edit|year-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:year-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:year-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:year-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->year->orderBy('name');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = btnEdit(route('years.edit', $row->id), 'year-edit');
                    $btn .= btnDelete(route('years.destroy', $row->id), 'year-delete');

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('years.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('years.create');
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
            'name' => 'required|unique:years,name',
            'image' => 'required',
        ]);

        try {
            $year = $this->year->create($request->all());
            toast()->success(trans('sys.msg.success.save'))->width('25rem');

            return redirect()->route('years.index');
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $year = $this->year->find($id);
        return view('years.edit', compact('year'));
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
            'name' => "required|unique:years,name,$id",
            'image' => 'required',
        ]);

        try {
            $year = $this->year->find($id);
            $year = $year->update($request->all());
            toast()->success(trans('sys.msg.success.update'))->width('25rem');

            return redirect()->route('years.index');
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
            $year = $this->year->find($id);
            $year->delete();

            toast()->success(trans('sys.msg.success.delete'))->width('25rem');

            return redirect()->route('years.index');
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

            $request->file('upload')->move(public_path('images/years'), $fileName);

            return response()->json([
                'message' => 'Image uploaded successfully',
                'url' => asset('images/years/'.$fileName),
            ]);
        }
    }
}
