<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $status = Auth::user()->status;
        if ($status == 1)
            return view('admin.dashboard');
        else {
//            abort(404);
            Auth::logout();
            return redirect('/login')->with('warning', 'You have been logged out!');
        }
    }
}
