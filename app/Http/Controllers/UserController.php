<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Fakultet;
use App\Models\Graduate;
use App\Models\Group;
use App\Models\University;
use App\Models\User;
use App\Models\UserInfo;
use App\Rules\PassportNumber;
use App\Rules\PhoneNumber;
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
            $user = User::where('role', '!=', 'student')->get();
        if ($role == 'user')
//            abort(404);
            $user = User::where('user_id', $id)->orwhere('id', $id)->get();

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
        if ($role == 'student')
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
       $user_info = new UserInfo();
       $user_info->name=$request->name;
       $user_info->surname=$request->surname;
       $user_info->father_name=$request->father_name;
       $user_info->birthdate=$request->sana;
       $user_info->passport=$request->passport;
       $user_info->address=$request->address;
       $user_info->phone=$request->phone;
       $user_info->save();
        $g=new Graduate();
        $g->status=5;
        $g->save();
        $user = new User();
        $user->info_id=$user_info->id;

        if($request->turi=='student'){
            $user->group_id=$request->group_id;

        }
        $user->role=$request->turi;

        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($role == 'super_admin') {
            $user->user_id = 1;
        }
        if ($role == 'user') {
            $user->user_id = $id;
            $user->graduate_id = $g->id;
        }
        $user->status=Auth::user()->status;
        $user->save();
        if($request->turi=='student'){
            return redirect()->route('admin.students.index')
                ->with('success', 'Muvaffaqqiyatli yaratildi');
        }else{
            return redirect()->route('admin.users.index')
                ->with('success', 'Muvaffaqqiyatli yaratildi');
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
        $user = User::find($id);
        return view('admin.users.show', [
            'data' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)

    {
        $role=Auth::user()->role;
        $id = Auth::user()->id;
        if ($user->id != $id && $role != 'super_admin')
            abort(403);
        return view('admin.users.edit', [
            'user'=>$user
        ]);
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
        $t=User::all()->where('email',$request->email);
        if(count($t)>0) {
            if ($t->first()->id != $user->id) {
                return redirect()->back()->withErrors('Bu email foydalanilgan !');
            }
        }

        $request->validate([
            'name'=>'required',
            'email'=>'required |email',
            'password'=>'required | min:8',
            'password_confirm'=>'required_with:password|same:password',
            'phone'=>['required',new PhoneNumber()],
            'address'=>'required',
            'passport'=>['required',new PassportNumber()],
            'surname'=>'required',
            'father_name'=>'required',
            'sana'=>'required'
        ]);
        $user_info=UserInfo::find($user->info_id);
        $user_info->name=$request->name;
        $user_info->surname=$request->surname;
        $user_info->father_name=$request->father_name;
        $user_info->birthdate=$request->sana;
        $user_info->passport=$request->passport;
        $user_info->address=$request->address;
        $user_info->phone=$request->phone;
        $user_info->save();

        $user->update([
            'info_id'=>$user_info->id,
            'email' => $request->email,
            'group_id' => $request->group_id,
            'password' => Hash::make($request->password)
        ]);

        if($request->turi=='student'){
            return redirect()->route('admin.students.index')
                ->with('success', 'Muvaffaqqiyatli yangilandi');
        }else{
            return redirect()->route('admin.users.index')
                ->with('success', 'Muvaffaqqiyatli yangilandi');
        }
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
//        dd($user->group_id);
        if ($user->id == $id)
            abort(403);
        if ($role == 'super_admin')
            $user->delete();
        else if ($role == 'user')
            $user->delete();
        else abort(403);
        if($user->group_id > 0){
            return redirect()->route('admin.students.index')
                ->with('success', 'Muvaffaqqiyatli yangilandi');
        }else{
            return redirect()->route('admin.users.index')
                ->with('success', 'Muvaffaqqiyatli yangilandi');
        }

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
