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
        $id = $this->auth_id();
        $post = Student::where('user_id', $id)->paginate(15);
        return view('admin.students.index', ["posts" => $post]);
    }

    public function create()
    {
        $id = $this->auth_id();
        $floors = Floor::all();
        $buildings = Bino::where('user_id', $id)->get();

        $users_id = Room::whereColumn('busy', '<', 'count')->get();
        $users_admin = User::where('user_id', $id)->get();
        $users = [0];
        $rooms = [];
        array_push($users, $id);
        if ($users_admin != NULL)
            foreach ($users_admin as $key => $value)
                $users[$key] = $value['id'];

        foreach ($users_id as $key => $value) {
            for ($j = 0; $j < count($users); $j++) {
                if ($value->floor->bino->user_id == $users[$j]) {
                    array_push($rooms, $value);
                    break;
                }
            }
        }


//        $rooms = (object)$rooms;

//        dd($rooms);

//        $rooms = Room::whereColumn('busy', '<', 'count')->get();
        $fak = Fakultet::where('user_id', $id)->get();

        return view('admin.students.create', [
            "rooms" => $rooms,
            "fakultets" => $fak,
            'buildings' => $buildings,
            'floors' => $floors,
        ]);
    }
    public function store(Request $request)
    {
        $id = $this->auth_id();
        $request = $request->validate([
            "name" => 'required ',
            "surname" => 'required ',
            "f_s_name" => 'required ',
            "address" => 'required ',
            "phone" => ['required','unique:students', new PhoneNumber],
            "passport" => ['required','unique:students', new PassportNumber],
            "parent_name" => 'required ',
            "parent_phone" => ['required', new PhoneNumber],
            "room_id" => 'required',
            "fak_id" => 'required'
        ]);

        $data = new Student();
        $data->name = $request['name'];
        $data->surname = $request['surname'];
        $data->f_s_name = $request['f_s_name'];
        $data->address = $request['address'];
        $data->phone = $request['phone'];
        $data->passport = $request['passport'];
        $data->parent_name = $request['parent_name'];
        $data->parent_phone = $request['parent_phone'];
        $data->room_id = $request['room_id'];
        $data->fak_id = $request['fak_id'];
        $data->user_id = $id;
        $data->save();
        //busy++
        $id = $request['room_id'];
        $d = Room::find($id);
        $d->busy += 1;
        $d->save();
        return redirect(route('admin.students.index'))->with('success', 'Muvaffaqqiyatli yaratildi');
    }

    public function edit($id)
    {
        $data = Student::find($id);
        $room_old = Room::find($data->room_id);
        $fak_old = Fakultet::find($data->fak_id);

        $rooms = Room::whereColumn('busy', '<', 'count')->get();
        $fak = Fakultet::all();

        return view('admin.students.edit', [
            "rooms" => $rooms,
            "fakultets" => $fak,
            "data" => $data,
            "room_old" => $room_old,
            "fak_old" => $fak_old
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
