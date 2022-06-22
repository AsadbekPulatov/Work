<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Fakultet;
use App\Models\Group;
use App\Models\University;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::OrderBy('id', 'DESC')->paginate(10);
        return view('admin.groups.index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universities = University::all();
        $faculties = Fakultet::all();
        $groups = Group::all();
        return view('admin.groups.create', [
            'universities' => $universities,
            'faculties' => $faculties,
            'groups' => $groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request, Group $group)
    {
//        dd($request->validated());
        $group->create([
            'name' => $request['name'],
            'faculty_id' => $request['faculty_id'],
            'university_id' => $request['university_id'],
//            'employee_id' => 1,
        ]);
        return redirect()->route('admin.groups.index')->with('success', 'created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $groups = Group::where('faculty_id', $group->faculty_id)->get();
        return view('admin.groups.edit',[
            'data' => $group,
            'groups' => $groups,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        $group['name'] = $data['name'];
        $group->save();
        return redirect()->route('admin.groups.index')->with('success', 'created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'created');
    }
}
