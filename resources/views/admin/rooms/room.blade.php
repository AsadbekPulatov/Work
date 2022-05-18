@extends('admin.master')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9"><h1 class="card-title">Xonalar</h1></div>
                    <div class="col-md-1">
                        <a class="btn btn-primary" href="{{route('admin.rooms.create')}}">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Xona qo'shing
                        </a>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Xona raqami</th>
                            <th scope="col">Joylar soni</th>
                            <th scope="col">Bandlik xolati</th>
                            <th scope="col" class="w-25">Talabalar</th>
                            <th scope="col">Bino</th>
                            <th scope="col">Qavati</th>
                            <th scope="col" class="w-25">Ammallar</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $ind=>$post)
                            @foreach($floors as $floor)
                                @if( $post['floor_id']==$floor['id'] )
                                    <tr>
                                        <th scope="row" class="col-1"> {{$ind+1}} </th>
                                        <td>{{$post->room_number}}</td>
                                        <td>{{$post->count}}</td>
                                        <td>{{$post->busy}}</td>
                                        <td>
                                            @foreach($students["$post->id"] as $student)
                                                <a title="Ko'rish"  href="{{route('admin.students.show',$student->id)}}">
                                                    {{$student->surname}}
                                                    {{$student->name}}
                                                </a>
                                            @endforeach


                                        </td>
                                        <td>{{ $floor->bino['name'] }}</td>
                                        <td>{{$floor->floor}}</td>
                                        <td class="col-2">
                                            <form action="{{ route('admin.rooms.destroy',$post->id) }}" method="POST">


                                                <a class="btn btn-warning btn-sm"
                                                   href="{{ route('admin.rooms.edit',$post->id) }}">
                                                <span class="btn-label">
                                                    <i class="fa fa-pen"></i>
                                                </span>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger btn-flat show_confirm"
                                                        data-toggle="tooltip">
                                                    <span class="btn-label">
                                                        <i class="fa fa-trash"></i>
                                                    </span>
                                                </button>

                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach

                        </tbody>
                    </table>
                    <section class="content12 cid-t34gh8nW7r" id="content12-2s">

                        {{--                        <div class="container">--}}
                        {{--                            <div class="row justify-content-center">--}}
                        {{--                                @if ($data->links())--}}
                        {{--                                    <div class="mt-4 p-4 box has-text-centered">--}}
                        {{--                                        {{ $data->links() }}--}}
                        {{--                                    </div>--}}
                        {{--                                @endif--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @if(session('success'))

        <script>
            swal({
                icon: 'success',
                text: 'Muvaffaqqiyatli bajarildi',
                confirmButtonText: 'Continue',
            })
        </script>
    @endif
    <script>
        $('.show_confirm').click(function (event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Haqiqatan ham bu yozuvni oʻchirib tashlamoqchimisiz?`,
                text: "Agar siz buni o'chirib tashlasangiz, u abadiy yo'qoladi.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ['Yo`q', 'Ha']
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    </script>
@endsection



