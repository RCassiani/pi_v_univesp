<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|void
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (auth()->user()->id != $id) {
            return abort('403');
        }

        return view('auth.passwords.change', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'new_password' => 'required|confirmed|min:8',
        ]);

        try {
            $user = User::find($id);
            if(!$user){
                alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.find'));
                return redirect()->route('home');
            }

            $data = $request->all();
            $user->password = Hash::make($data['new_password']);
            $user->save();

            toast()->success(trans('passwords.reset'))->width('25rem');

            return redirect()->route('home');
        } catch (Exception $e) {
            alert()->error(trans('sys.msg.alert-error'), trans('sys.msg.error.update'));
            return back()->withInput();
        }
    }
}
