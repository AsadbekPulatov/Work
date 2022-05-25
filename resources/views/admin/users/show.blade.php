@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{route('admin.home')}}" class="btn btn-primary">Admin panelga qaytish</a>
                <div class="row container mt-4">
                    <table class=" table table-bordered border-primary ">
                        <tr>
                            <th>Ismi</th>
                            <td>{{$data->user_infos->name}}</td>
                        </tr>
                        <tr>
                            <th>Familyasi</th>
                            <td>{{$data->user_infos->surname}}</td>
                        </tr>
                        <tr>
                            <th>Sharifi</th>
                            <td>{{$data->user_infos->father_name}}</td>
                        </tr>
                        <tr>
                            <th>Telefon raqami</th>
                            <td>{{$data->user_infos->phone}}</td>
                        </tr>
                        <tr>
                            <th>Pasport seriyasi va raqami</th>
                            <td>{{$data->user_infos->passport}}</td>
                        </tr>
                        <tr>
                            <th>Manzili</th>
                            <td>{{$data->user_infos->address}}</td>
                        </tr>
{{--                        <tr>--}}
{{--                            <th>Fakulteti</th>--}}
{{--                            <td>{{$fakultet->name}}</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <th>Xona raqami</th>--}}
{{--                            <td>{{$room->room_number}}</td>--}}
{{--                        </tr>--}}
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
