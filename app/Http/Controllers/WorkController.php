<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkRequest;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $works = Work::where('student_id', $id)->paginate(10);
        return view('admin.work.index', [
            'works' => $works,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $works = Work::all();
        return view('admin.work.create', [
            'works' => $works,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkRequest $request, Work $work)
    {
        $id = Auth::user()->id;
        $path = 'assets/documents/';
        $file = time().'.pdf';
        $works = Work::where('student_id', $id)->get();
//        dd($works->count());
        if ($works->count() == 0){
//            dd(1);
            $request->document->move($path, $file);
            $work->create([
                'student_id' => $id,
                'command' => $request['command'],
                'firm_name' => $request['firm_name'],
                'firm_address' => $request['firm_address'],
                'firm_phone' => $request['firm_phone'],
                'firm_year' => $request['firm_year'],
                'document' => $file,
            ]);
        }
        else{
//            dd(0);
            $document = $works[0]->document;
//            dd($document);
            if (File::exists(public_path('/assets/img/documents/'.$document))){
                File::delete(public_path('/assets/img/documents/'.$document));
            }
            $request->document->move($path, $file);
            $works[0]->update([
                'command' => $request['command'],
                'firm_name' => $request['firm_name'],
                'firm_address' => $request['firm_address'],
                'firm_phone' => $request['firm_phone'],
                'firm_year' => $request['firm_year'],
                'document' => $file,
            ]);
        }
        return redirect()->route('admin.works.index')->with('success', 'created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        //download
        $file_name = $work->document;
        $file_path = public_path('assets/documents/'.$file_name);
        return response()->download($file_path);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        $works = Work::all();
        return view('admin.work.edit', [
            'work' => $work,
            'works' => $works,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Work $work)
    {
//        dd($request);
        if ($request['document'] != NULL){
            if (File::exists(public_path('/assets/img/documents/'.$work->document))){
                File::delete(public_path('/assets/img/documents/'.$work->document));
            }
            $id = Auth::user()->id;
            $path = 'assets/documents/';
            $file = time().'.pdf';
            $request->document->move($path, $file);
            $work->update([
                'command' => $request['command'],
                'firm_name' => $request['firm_name'],
                'firm_address' => $request['firm_address'],
                'firm_phone' => $request['firm_phone'],
                'firm_year' => $request['firm_year'],
                'document' => $file,
            ]);

            return redirect()->route('admin.works.index')->with('success', 'created');
        } else {
            $work->update([
                'command' => $request['command'],
                'firm_name' => $request['firm_name'],
                'firm_address' => $request['firm_address'],
                'firm_phone' => $request['firm_phone'],
                'firm_year' => $request['firm_year'],
            ]);
            return redirect()->route('admin.works.index')->with('success', 'created');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        if (File::exists(public_path('/assets/img/documents/'.$work->document))){
            File::delete(public_path('/assets/img/documents/'.$work->document));
        }
        $work->delete();
        return redirect()->route('admin.works.index')->with('success', 'deleted');

    }
}
