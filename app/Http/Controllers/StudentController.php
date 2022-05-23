<?php

namespace App\Http\Controllers;

use App\Models\Bino;
use App\Models\Fakultet;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use App\Rules\PassportNumber;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StudentController
{

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
        return view('admin.users.index2')->with('users', $user);
    }

    public function create()
    {
        return view('admin.users.create2');
    }
    public function store(Request $request)
    {

        return redirect(route('admin.students.index'))->with('success', 'Muvaffaqqiyatli yaratildi');
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $request = $request->validate([
            "name" => 'required ',
            "surname" => 'required ',
            "f_s_name" => 'required ',
            "address" => 'required ',
            "phone" => ['required', new PhoneNumber],
            "passport" => ['required', new PassportNumber],
            "parent_name" => 'required ',
            "parent_phone" => ['required', new PhoneNumber],
            "room_id" => 'required',
            "fak_id" => 'required'
        ]);
        $data = Student::find($id);
        $data->name = $request['name'];
        $data->surname = $request['surname'];
        $data->f_s_name = $request['f_s_name'];
        $data->address = $request['address'];
        $data->phone = $request['phone'];
        $data->passport = $request['passport'];
        $data->parent_name = $request['parent_name'];
        $data->parent_phone = $request['parent_phone'];
        if ($data->room_id != $request['room_id']) {
            $room = Room::find($data->room_id);
            $room->busy -= 1;
            $room->save();

            $room = Room::find($request['room_id']);
            $room->busy += 1;
            $room->save();
            $data->room_id = $request['room_id'];
        }
        $data->fak_id = $request['fak_id'];

        $data->save();

        return redirect(route('admin.students.index'))->with('success', 'Muvaffaqqiyatli yangilandi');
    }

    public function show($id)
    {
        $data = Student::find($id);
        $fak = Fakultet::find($data->fak_id);
        $room = Room::find($data->room_id);
        $sheriklari = Student::all()->where('room_id', '=', $data->room_id);
        return view('admin.students.show', [
            "data" => $data,
            "fakultet" => $fak,
            "room" => $room,
            "sheriklar" => $sheriklari
        ]);
    }

    public function destroy($id)
    {

        $data = Student::find($id);
        $room = Room::find($data->room_id);
        $room->busy -= 1;
        $room->save();
        $data->delete();

        return redirect(route('admin.students.index'))->with('success', 'Muvaffaqqiyatli o\'chirildi');

    }

    public function auth_id(){
        $role = Auth::user()->role;
        if ($role == 'admin')
            $id = Auth::user()->id;
        elseif ($role == 'user')
            $id = Auth::user()->user_id;
        return $id;
    }
}
