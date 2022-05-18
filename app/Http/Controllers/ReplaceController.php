<?php

namespace App\Http\Controllers;

use App\Models\Fakultet;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ReplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function auth_id(){
        $role = Auth::user()->role;
        if ($role == 'admin')
            $id = Auth::user()->id;
        elseif ($role == 'user')
            $id = Auth::user()->user_id;
        return $id;
    }
    public function edit($id)
    {
        $data = Student::find($id);
        $room_old = Room::find($data->room_id);
        $fak_old = Fakultet::find($data->fak_id);


        $id = $this->auth_id();

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


          $rooms = (object)$rooms;

        return view('admin.students.replace', [
            "room_old" => $room_old,
            "data" => $data ,
            "rooms"=>$rooms
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $student=Student::find($id);
        if($student->room_id != $request->room_id){
            if($request->room_id !=0){
                $room = Room::find($student->room_id);
                $room->busy -= 1;
                $room->save();

                $room = Room::find($request->room_id);
                $room->busy += 1;
                $room->save();
                $student->room_id = $request->room_id;
                $student->save();
            } else{
                $data = Student::find($id);
                $room = Room::find($data->room_id);
                $room->busy -= 1;
                $room->save();
                $data->delete();
            }
        }

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Muvaffaqqiyatli yangilandi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
