@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9"><h1 class="card-title">Korxona</h1></div>
                    <div class="col-md-1">
                        <a class="btn btn-primary" href="{{route('admin.works.create')}}">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Korxona Qo'shish
                        </a>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table table-bordered text-uppercase">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Buyruq</th>
                            <th scope="col">Nomi</th>
                            <th scope="col">Manzili</th>
                            <th scope="col">Telefon</th>
                            {{--                            <th scope="col">Yil</th>--}}
                            {{--                            <th scope="col">Hujjat</th>--}}
                            <th scope="col">Amal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($works as $key => $work)
                            <tr>
                                <td class="col-1">{{$key+1}}</td>
                                <td class="col-2">{{$work->command}}</td>
                                <td class="col-2">{{$work->firm_name}}</td>
                                <td class="col-2">{{$work->firm_address}}</td>
                                <td class="col-2">{{$work->firm_phone}}</td>
                                {{--                                <td class="col-2">{{$work->firm_year}}</td>--}}
                                {{--                                <td class="col-2">{{$work->document}}</td>--}}
                                <td class="col-2">

                                    <form action="{{ route('admin.works.destroy',$work->id) }}" method="POST">
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('admin.works.show',$work->id) }}">
                                            <span class="btn-label">
                                                <i class="fa fa-download"></i>
                                            </span>
                                        </a>
                                        <a class="btn btn-warning btn-sm"
                                           href="{{ route('admin.works.edit',$work->id) }}">
                                            <span class="btn-label">
                                                <i class="fa fa-pen"></i>
                                            </span>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                                                data-toggle="tooltip">
                                            <span class="btn-label">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="container">
                        <div class="row justify-content-center">
                            @if ($works->links())
                                <div class="mt-4 p-4 box has-text-centered">
                                    {{ $works->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
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

