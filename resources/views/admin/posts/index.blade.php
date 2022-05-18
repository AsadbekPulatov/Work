@extends('admin.master')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9"><h1 class="card-title">Yangiliklar</h1></div>
                    <div class="col-md-1">
                        <a class="btn btn-primary" href="{{route('admin.posts.create')}}">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Yangilik qo'shing
                        </a>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                        <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Sarlavha</th>
                            <th scope="col">Matn</th>
                            <th scope="col">Vaqt</th>
                            <th scope="col">Ko'rildi</th>
                            <th scope="col">Harakat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <th scope="row" class="col-1">{{$post->id}}</th>
                            <td>{{$post->header_ru}}</td>
                            <td>{{$post->description_ru}}</td>
                            <td>{{$post->created_at}}</td>
                            <td>{{$post->viewed}}</td>
                            <td class="col-2">
                                <form action="{{ route('admin.posts.destroy',$post->id) }}" method="POST">
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.posts.edit',$post->id) }}">
                                    <span class="btn-label">
                                        <i class="fa fa-pen"></i>
                                    </span>

                                </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><span class="btn-label">
                                        <i class="fa fa-trash"></i>
                                    </span></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
