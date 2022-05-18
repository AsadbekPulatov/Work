<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $role = Auth::user()->role;
        $id = Auth::user()->id;
        if ($role == 'super_admin')
            $user = User::where('role', '!=', 'user')->get();
        if ($role == 'admin')
            $user = User::where('user_id', $id)->orwhere('id', $id)->get();
        if ($role == 'user')
            $user = User::where('id', $id)->get();
        return view('admin.users.index')->with('users', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Auth::user()->role;
        if ($role == 'user')
            abort(404);
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $role = Auth::user()->role;
        $id = Auth::user()->id;
        if ($role == 'user')
            abort(404);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($role == 'super_admin') {
            $user->role = 'admin';
            $user->user_id = 1;
        }
        if ($role == 'admin') {
            $user->user_id = $id;
        }
        $user->status=Auth::user()->status;
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Muvaffaqqiyatli yaratildi');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $id = Auth::user()->id;
        if ($user->id != $id)
            abort(403);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $role = Auth::user()->role;
        $id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('admin.users.index')
            ->with('success', 'Muvaffaqqiyatli yangilandi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $role = Auth::user()->role;
        $id = Auth::user()->id;
        if ($user->id == $id)
            abort(403);
        if ($role == 'super_admin')
            $user->delete();
        else if ($role == 'admin' && $user->user_id == $id)
            $user->delete();
        else abort(403);
        return redirect()->route('admin.users.index')
            ->with('success', 'Muvaffaqqiyatli o`chirildi');

    }

    public function status(User $user)
    {
        if ($user->status == 0) $status = 1;
        else $status = 0;
        $users = User::Where('user_id', $user->id)->update([
            'status' => $status
        ]);
        $users = User::Where('id', $user->id)->update([
            'status' => $status
        ]);
        return redirect()->route('admin.users.index');
    }

    /*public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }*/
}
