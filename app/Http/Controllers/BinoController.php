<?php

namespace App\Http\Controllers;

use App\Http\Requests\BinoRequest;
use App\Models\Fakultet;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Bino;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BinoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $role = Auth::user()->role;
        $id = Auth::user()->id;
       if ($role == 'admin') {
            $data = Bino::where('user_id', $id)->paginate(5);
        }
        return view('admin.binos.bino', [
            'data' => $data,
        ]);

    }

    public function create()
    {
        $id = Auth::user()->id;
        $facultets = Bino::where('user_id', $id)->get();
        return view('admin.binos.addbino', [
            'facultets' => $facultets
        ]);
    }


    public function store(BinoRequest $request)
    {
        $id = Auth::user()->id;
        $data = new Bino();
        $data->name = $request->name;
        $data->user_id = $id;
        $data->save();

        return redirect(route('admin.binos.index'))->with('success', 'Bino yaratildi.');
    }

    public function edit($id)
    {
        $auth_id = Auth::user()->id;
        $facultets = Bino::where('user_id', $auth_id)->get();

        $data = Bino::find($id);
//        $isUser = User::find($data->user_id);
//        $users = User::all();

        return view('admin.binos.editbino', [
            'data' => $data,
//            'isUser' => $isUser,
//            'users' => $users,
            'facultets' => $facultets
        ]);

    }


    public function update(Request $request, $id)
    {

        $data = Bino::find($id);
        $data->name = $request->name;
        $data->save();

        return redirect(route('admin.binos.index'))->with('success', 'Bino yaratildi.');


    }

    public function destroy($id)
    {

        $data = Bino::find($id);
        $id = $data->id;
        $floor_id = Floor::where('bino_id', $id)->get();
        $floor_ids = [];
        foreach ($floor_id as $value)
            array_push($floor_ids, $value->id);

        $rooms = Room::whereIn('floor_id', $floor_ids)->delete();
        Floor::where('bino_id', $id)->delete();
//        dd($floor_ids);
//        dd($id);
//        $floor_id = Floor::find($id)->id;
//        $floors = Floor::where('bino_id', $id)->delete();
//        $rooms = Room::where('floor_id', $floor_id)->delete();
        $data->delete();

        return redirect(route('admin.binos.index'))->with('success', 'Bino yaratildi.');

    }


}
