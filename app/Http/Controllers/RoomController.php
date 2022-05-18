<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Bino;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use function Sodium\increment;

class RoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = $this->auth_id();
        $users = [];
        $users_id = Room::all();
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


        $students=[];
        foreach ($rooms as $room){

            $id=$room['id'];

            $st=Student::all()->where('room_id',$id);
            $n=count($st);
            $students["$id"]=$st;
        }


        $data = (object)$rooms;
//        $data->paginate(5);

        $floors = Floor::all();

        return view('admin.rooms.room', [
            'data' => $data,
            'floors' => $floors,
            "students"=>$students
        ]);

    }
    public function show($id){
        $data = Room::find($id);
        $students=Student::all()->where('room_id',$id);
        return view('admin.rooms.show',
        [
            "students"=>$students,
            "data"=>$data
        ]
        );
    }

    public function create()
    {
        $id = $this->auth_id();
        $binos = Bino::where('user_id', $id)->get();
        $floors = Floor::all();
        $rooms = Room::all();
//        $data->find(1)->floor->bino;
//        dd($rooms);
        return view('admin.rooms.addroom', [
            'floors' => $floors,
            'binos' => $binos,
            'rooms' => $rooms,
        ]);
    }


    public function store(RoomRequest $request)
    {
        $data = new Room();
        $data->room_number = $request->number;
        $data->count = $request->count;
        $data->floor_id = $request->floor_id;
        $data->save();

        return redirect(route('admin.rooms.index'))->with('success', 'Xona yaratildi.');
    }


    public function edit($id)
    {

        $data = Room::find($id);
        $floor_id = Floor::find($data->floor_id)->id;
        $rooms = Room::where('floor_id', $floor_id)->get();
//        $isfloor = Floor::find($data->floor_id);
//        $floors = Floor::all();

//        dd($rooms);
        return view('admin.rooms.edit', [
            'data' => $data,
//            'isfloor' => $isfloor,
//            'floors' => $floors,
            'rooms' => $rooms,
        ]);
    }


    public function update(Request $request, $id)
    {

        $data = Room::find($id);
//        dd($data->floor_id);
        $busy=$data->busy;
        if($request->count<$busy){
            return Redirect::back()->withErrors("Bu xonada $busy ta ijarachi bor. O'rinlar soni $busy dan kam bo'lishi mumkin emas");
        }
        if($request->count==0){
            return Redirect::back()->withErrors("O'rinlar soni nol bo'lishi mumkin emas");
        }
        $data->room_number = $request->number;
        $data->count = $request->count;
        $data->floor_id = $data->floor_id;
        $data->save();

        return redirect(route('admin.rooms.index'))->with('success', 'Xona yaratildi.');


    }

    public function destroy($id)
    {

        $data = Room::find($id);
        $data->delete();

        return redirect(route('admin.rooms.index'))->with('success', 'Xona o\'chirildi.');

    }

    public function auth_id()
    {
        $role = Auth::user()->role;
        if ($role == 'admin')
            $id = Auth::user()->id;
        elseif ($role == 'user')
            $id = Auth::user()->user_id;
        return $id;
    }
}
