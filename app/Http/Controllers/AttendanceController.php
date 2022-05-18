<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\Bino;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    public function index()
    {
        $role = Auth::user()->role;
        $creater = Auth::user()->user_id;
        if ($role == 'admin')
            $id = Auth::user()->id;
        elseif ($role == 'user')
            $id = Auth::user()->user_id;
        if ($role == 'user')
            $attendances = Attendance::whereDate('created_at', Carbon::today())
                ->Where('user_id', $id)
                ->OrderBy('id', 'DESC')
                ->paginate(10);
        else
            $attendances = Attendance::Where('user_id', $id)->OrderBy('id', 'DESC')->paginate(10);

        return view('admin.attendances.index', [
            'attendances' => $attendances
        ]);
    }

    public function create()
    {
        $role = Auth::user()->role;
        if ($role == 'admin') abort(404);
        if ($role == 'admin')
            $id = Auth::user()->id;
        elseif ($role == 'user')
            $id = Auth::user()->user_id;
        $floors = Floor::all();
        $buildings = Bino::where('user_id', $id)->get();
        $students = Student::where('user_id', $id)->get();
        $rooms = Room::OrderBy('id')->get();
        return view('admin.attendances.create', [
            'students' => $students,
            'rooms' => $rooms,
            'floors' => $floors,
            'buildings' => $buildings
        ]);
    }

    public function store(AttendanceRequest $request)
    {

        $role = Auth::user()->role;
        if ($role == 'admin') abort(404);
        if ($role == 'admin')
            $id = Auth::user()->id;
        elseif ($role == 'user')
            $id = Auth::user()->user_id;
        $students = Student::where('room_id', $request->room)->get();
        $room_in_students = count($students);
        $students_request = $request->student;

        for ($i = 0; $i < $room_in_students; $i++) {
            $cnt = 0;
            $attendance = new Attendance();
            $attendance['student_id'] = $students[$i]['id'];
            if ($students_request != NULL)
                for ($j = 0; $j < count($students_request); $j++) {
                    if ($students[$i]['id'] == $students_request[$j]) {
                        $cnt++;
                    }
                }
            if ($cnt == 0) $attendance['check'] = 0;
            else $attendance['check'] = 1;
            $attendance['room_id'] = $request['room'];
            $attendance['user_id'] = $id;
            $attendance->save();
        }
        return redirect()->route('admin.attendances.index')->with('success', 'Davomat olindi');
    }
}
