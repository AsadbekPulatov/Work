<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    public function index(Request $request){
//        $id = Auth::user()->id;
        $id = $request->id;
        $university_id = Auth::user()->university_id;
        $groups = Group::where('university_id', $university_id)->get();
        if ($id == NULL)
        $all = User::where('role', 'student')->where('university_id', $university_id)->get();
        else $all = User::where('group_id', $id)->get();
        $users = [];
        foreach ($all as $value)
            array_push($users, $value->graduate_id);
        $n1 = Graduate::whereIn('id', $users)->where('status', 1)->get();
        $n2 = Graduate::whereIn('id', $users)->where('status', 2)->get();
//        $n3 = Graduate::whereIn('id', $users)->where('status', 3)->get();
        $n4 = Graduate::whereIn('id', $users)->where('status', 4)->get();
        $n5 = Graduate::whereIn('id', $users)->where('status', 5)->get();
        return view('admin.statistic',[
            'students' => $all,
            'groups' => $groups,
            'n1' => $n1,
            'n2' => $n2,
//            'n3' => $n3,
            'n4' => $n4,
            'n5' => $n5,
        ]);
    }
}
