<?php

namespace App\Http\Controllers;

use App\Http\Requests\FakultetRequest;
use App\Models\Fakultet;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacultetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $id = Auth::user()->id;
        $posts=Fakultet::where('user_id', $id)->paginate(5);
        return view('admin.facultets.index',[
            'posts'=>$posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $id = Auth::user()->id;
        $facultets = Fakultet::where('user_id', $id)->get();
        return view('admin.facultets.create',[
            'facultets' => $facultets
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FakultetRequest $request)
    {
        $id = Auth::user()->id;
        $data=new Fakultet();
        $data->name=$request->name;
        $data->user_id=$id;
        $data->save();
        return redirect(route('admin.facultets.index'))->with('success', 'Fakultet yaratildi.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentInfo  $studentinfo
     * @return \Illuminate\Http\Response
     */
    public function show(StudentInfo $studentinfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentInfo  $studentinfo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auth_id = Auth::user()->id;
        $facultets = Fakultet::where('user_id', $auth_id)->get();
        $post=Fakultet::find($id);
        return view('admin.facultets.edit',[
            'post'=>$post,
            'facultets' => $facultets
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentInfo  $studentinfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $post=Fakultet::find($id);
        $post->id=$id;
        $post->name=$request->name;
        $post->save();
        return redirect()->route('admin.facultets.index')->with('success', 'Fakultet yaratildi.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentInfo  $studentinfo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=Fakultet::find($id);
        $data->delete();
        return redirect(route('admin.facultets.index'))->with('success', 'Fakultet yaratildi.');
    }
}
