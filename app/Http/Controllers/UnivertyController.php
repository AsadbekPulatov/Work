<?php

namespace App\Http\Controllers;

use App\Http\Requests\UniversityRequest;
use App\Models\University;
use Illuminate\Http\Request;

class UnivertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universities = University::OrderBy('name')->paginate(10);
        return view('admin.university.index',[
            'universities' => $universities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.university.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UniversityRequest $request,University $university)
    {
        $university->create($request->validated());
        return redirect()->route('admin.universities.index')->with('success', 'created');
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
    public function edit(University $university)
    {
        return view('admin.university.edit',[
            'university'=>$university
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UniversityRequest $request, University $university)
    {
        $university->update($request->validated());
        return redirect()->route('admin.universities.index')->with('success', 'edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->route('admin.universities.index')->with('success', 'deleted');
    }
}
