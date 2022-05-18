<?php

namespace App\Http\Controllers;

use App\Http\Requests\FloorRequest;
use App\Models\Bino;
use App\Models\Floor;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FloorController extends Controller
{


    public function index()
    {
        $id = $this->auth_id();
        $buildings = [];
        $data = Bino::where('user_id', $id)->get();
        if ($data != NULL)
            foreach ($data as $value)
                array_push($buildings, $value['id']);
        $data = Floor::whereIn('bino_id', $buildings)->paginate(5);
        return view('admin.floors.floor', ['data' => $data]);
    }

    public function create()
    {
        $id = $this->auth_id();
        $buildings = Bino::where('user_id', $id)->get();
        $floors = [];
        if ($buildings != NULL)
            foreach ($buildings as $value)
                array_push($floors, $value['id']);
        $floors = Floor::whereIn('bino_id', $floors)->get();
//        dd($floors);
        return view('admin.floors.addfloor', [
            'buildings' => $buildings,
            'floors' => $floors
        ]);
    }

    public function store(FloorRequest $request)
    {
        Floor::create($request->all());
        return redirect(route('admin.floors.index'))->with('success', 'Qavat yaratildi.');
    }

    public function edit(Floor $floor)
    {
        $auth_id = $this->auth_id();
        $floors = Floor::where('bino_id', $floor->bino_id)->get();
//        dd($floors);
        $data = Floor::find($floor->id);
        return view('admin.floors.editfloor', compact('data', 'floors'));
    }


    public function update(Request $request, $id)
    {

        $data = Floor::find($id);
        $data->floor = $request->floor;
        $data->save();

        return redirect(route('admin.floors.index'))->with('success', 'Qavat yaratildi.');


    }

    public function destroy($id)
    {

        $data = Floor::find($id);
//        dd($id);
        Room::where('floor_id', $id)->delete();
        $data->delete();

        return redirect(route('admin.floors.index'))->with('success', 'Qavat yaratildi.');

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
