@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{route('admin.students.index')}}" class="btn btn-primary">Talabalar ro'yhatiga qaytish</a>
                <a href="{{route('admin.replace.edit',$data->id)}}" class="btn btn-primary float-end">Talaba joylashgan xonani o'zgartirish</a>
                <div class="row container mt-4">
                    <table class=" table table-bordered border-primary ">
                        <tr>
                            <th>Ismi</th>
                            <td>{{$data->name}}</td>
                        </tr>
                        <tr>
                            <th>Familyasi</th>
                            <td>{{$data->surname}}</td>
                        </tr>
                        <tr>
                            <th>Sharifi</th>
                            <td>{{$data->f_s_name}}</td>
                        </tr>
                        <tr>
                            <th>Telefon raqami</th>
                            <td>{{$data->phone}}</td>
                        </tr>
                        <tr>
                            <th>Pasport seriyasi va raqami</th>
                            <td>{{$data->passport}}</td>
                        </tr>
                        <tr>
                            <th>Manzili</th>
                            <td>{{$data->address}}</td>
                        </tr>
                        <tr>
                            <th>Ota-onasi ma'lumoti</th>
                            <td>{{$data->parent_name}}</td>
                        </tr>
                        <tr>
                            <th>Ota-onasi telefon raqami</th>
                            <td>{{$data->parent_phone}}</td>
                        </tr>
                        <tr>
                            <th>Fakulteti</th>
                            <td>{{$fakultet->name}}</td>
                        </tr>
                        <tr>
                            <th>Xona raqami</th>
                            <td>{{$room->room_number}}</td>
                        </tr>
                        <tr>
                            <th>Xonadoshlari</th>
                            <td>
                                @if(count($sheriklar)>1)
                                    @foreach($sheriklar as $sh)
                                        @if($sh->id==$data->id)
                                            @continue
                                        @endif
                                        <a href="{{route('admin.students.show',$sh->id)}}">{{$sh->surname}} {{$sh->name}} {{ $sh->f_s_name }}</a>
                                        <br>
                                    @endforeach
                                @else
                                    <h3>Yolg'iz turadi</h3>
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
