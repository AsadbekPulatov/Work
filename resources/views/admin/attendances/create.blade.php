@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Davomat olish</h1></div>
                </div>
                <hr>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{route('admin.attendances.store')}}" method="POST" accept-charset="UTF-8">
                        @csrf
                        <div class="form-group">
                            <label for="building">Bino</label>
                            <select name="building" id="building" class="form-select form-control">
                                <option value="none">Binoni tanlang</option>
                                @foreach($buildings as $building)
                                    <option value="{{$building->id}}">{{$building->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="floor">Qavat</label>
                            <select name="floor" id="floor" class="form-select form-control">
                                <option value="none">Qavatni tanlang</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="room">Xona</label>
                            <select name="room" id="room" class="form-select form-control">
                                <option value="none">Xonani tanlang</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Talabalar</label>
                            <div class="border p-3 d-flex flex-lg-column" id="students">

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                        <input type="reset" class="btn btn-danger" value="Tozalash">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        input[type=checkbox] {
            width: 25px;
            height: 25px;
        }
    </style>

    <script>

        let buildings = @json($buildings);
        let floors = @json($floors);
        let rooms = @json($rooms);
        let students = @json($students);
        $('#building').on('change', function () {
            var value = $(this).val();
            $('#floor').empty();
            $('#floor').append("<option value='none'>Qavatni tanlang</option>")
            for (let i = 0; i < floors.length; i++) {
                if (value == floors[i].bino_id) {
                    var option = document.createElement("option");   // Create with DOM
                    option.innerHTML = floors[i].floor;
                    option.value = floors[i].id;
                    $('#floor').append(option);
                }
            }
        });
        $('#floor').on('change', function () {
            var room_id = $(this).val();
            $('#room').empty();
            $('#room').append("<option value='none'>Xonani tanlang</option>")
            for (let i = 0; i < rooms.length; i++) {
                if (room_id == rooms[i].floor_id) {
                    var option = document.createElement("option");   // Create with DOM
                    option.innerHTML = rooms[i].room_number;
                    option.value = rooms[i].id;
                    $('#room').append(option);
                }
            }
        });
        $('#room').on('change', function () {
            var student_id = $(this).val();
            $('#students').empty();
            for (let i = 0; i < students.length; i++) {
                if (student_id == students[i].room_id) {
                    console.log(students[i]);
                    var label = document.createElement("label"); //Create with DOM
                    label.innerHTML = students[i].name;
                    label.className = "form-control d-flex justify-content-between align-items-center";
                    label.htmlFor = students[i].id;
                    label.id = 'n' + students[i].id;
                    $('#students').append(label);
                    $('#n' + students[i].id).append(`<input type="checkbox" id="${students[i].id}" name="student[]" value="${students[i].id}">`);
                }
            }
        });

    </script>
@endsection
