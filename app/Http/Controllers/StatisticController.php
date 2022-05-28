<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    public function index(){
//        $id = Auth::user()->id;
        $all = User::where('role', 'student')->get();
        $users = [];
        foreach ($all as $value)
            array_push($users, $value->graduate_id);
//        dd($users);
        $n1 = Graduate::whereIn('id', $users)->where('status', 1)->get();
        $n2 = Graduate::whereIn('id', $users)->where('status', 2)->get();
        $n3 = Graduate::whereIn('id', $users)->where('status', 3)->get();
        $n4 = Graduate::whereIn('id', $users)->where('status', 4)->get();
        $n5 = Graduate::whereIn('id', $users)->where('status', 5)->get();
        return view('admin.statistic',[
            'students' => $all,
            'n1' => $n1,
            'n2' => $n2,
            'n3' => $n3,
            'n4' => $n4,
            'n5' => $n5,
        ]);
    }
}
