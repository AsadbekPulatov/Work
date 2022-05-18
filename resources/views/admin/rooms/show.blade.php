@extends('admin.master')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <div class="col-md-3">
                        <a class="btn btn-primary float-start" href="{{route('admin.rooms.index')}}">
                            <span class="btn-label">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            Xonalar ro'yhatiga qaytish
                        </a>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-5 "><h1 class="card-title ">{{$data->room_number}} Xonadagi ijarachilar haqida ma'lumot</h1></div>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ijarachi haqida ma'lumot</th>
                            <th scope="col" class="w-25">Amallar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $i=>$s)
                            <td>{{$i+1}}</td>
                            <td>{{$s->surname}} {{$s->name}} {{$s->f_s_name}}</td>
                            <td>
                                <a title="Ko'rish" class="btn btn-primary btn-sm active"
                                   href="{{route('admin.students.show',$s->id)}}">
                                    <span class="btn-label">
                                        <i class="fa fa-eye"></i>
                                    </span>

                                </a>
                            </td>
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

@endsection
