<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download($id){
//        dd($id);
        $work = Work::where('student_id', $id)->first();
        if ($work == NULL) abort(404);
        $file_name = $work->document;
        $file_path = public_path('assets/documents/'.$file_name);
        return response()->download($file_path);
    }
}
