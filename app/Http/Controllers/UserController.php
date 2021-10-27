<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->user->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = btnEdit(route('users.edit', $row->id), 'user-edit');
                    $btn .= btnDelete(route('users.destroy', $row->id), 'user-delete');

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all(); //Grupos

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:users|email',
        ]);

        try {

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);

            $user = $this->user->create($input);

            $user->assignRole($request->input('roles'));

            toast()->success(trans('sys.msg.success.save'))->width('25rem');
            return redirect()->route('users.index');

        } catch (\Exception $e) {

            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.save'));
            return back()->withInput();

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:users,email,' . $id . '|email',
        ]);

        try {

            $user = $this->user->find($id);
            $user->update($request->all());

            $user->assignRole($request->input('roles'));

            toast()->success(trans('sys.msg.success.update'))->width('25rem');

            return redirect()->route('users.index');

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
            $user = $this->user->find($id);
            $user->delete();

            toast()->success(trans('sys.msg.success.delete'))->width('25rem');

            return redirect()->route('users.index');

        } catch (\Exception $e) {

            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.delete'));
            return back()->withInput();

        }
    }
}
