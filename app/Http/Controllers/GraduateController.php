<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use Illuminate\Http\Request;

class GraduateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $id = $request['grad_id'];
        $data = Graduate::find($id);
        $data['status'] = $request['status'];
        $data->save();
        return redirect()->route('admin.students.index')
            ->with('success', 'Muvaffaqqiyatli yaratildi');
    }
}
