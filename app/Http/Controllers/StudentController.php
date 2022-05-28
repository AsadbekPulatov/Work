<?php

namespace App\Http\Controllers;

use App\Models\Bino;
use App\Models\Fakultet;
use App\Models\Floor;
use App\Models\Group;
use App\Models\Room;
use App\Models\Student;
use App\Models\University;
use App\Models\User;
use App\Rules\PassportNumber;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StudentController
{

    public function index()
    {
        $university_id = Auth::user()->university_id;
//        dd($university_id);
        $user = User::where('role', 'student')->where('university_id', $university_id)->get();

        return view('admin.users.index2')->with('users', $user);
    }

    public function create()
    {
        $university_id = Auth::user()->university_id;
        $universities = University::where('id', $university_id)->get();
        $faculties = Fakultet::all();
        $groups = Group::all();
        return view('admin.users.create2', [
            'universities' => $universities,
            'faculties' => $faculties,
            'groups' => $groups,
        ]);
    }
    public function store(Request $request)
    {

        return redirect(route('admin.students.index'))->with('success', 'Muvaffaqqiyatli yaratildi');
    }

    public function edit($id)
    {   $user=User::find($id);
        $universities = University::all();
        $faculties = Fakultet::all();
        $groups = Group::all();
        $current_group=Group::find($user->group_id);

        $current_faculty=Fakultet::find($current_group->faculty_id);
        $current_university=University::find($current_faculty->university_id);

        return view('admin.users.edit2', [
            'user'=>$user,
            'universities' => $universities,
            'faculties' => $faculties,
            'groups' => $groups,
            'current_group'=>$current_group,
            'current_faculty'=>$current_faculty,
            'current_university'=>$current_university
        ]);
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
