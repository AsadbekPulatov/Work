@extends('admin.master')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9"><h1 class="card-title">Talabalar</h1></div>
                    <div class="col-md-1">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'user')
                            <a class="btn btn-primary" href="{{route('admin.students.create', ['id' => $id])}}">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                                Talaba qo'shing
                            </a>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ism Familya</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefon raqami</th>
                            <th scope="col">Status</th>
                            <th scope="col">Harakat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <th scope="row" class="col-1">{{ $key+1 }}</th>
                                <td>{{$user->user_infos->name}} {{$user->user_infos->surname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->user_infos->phone}}</td>
                                <td>
{{--                                    {{ $user->grad->id }}--}}
                                    <form action="{{ route('admin.graduate.status', ['id' => $user->group_id]) }}" method="post" id="form">
                                        @csrf
                                        <input type="hidden" value="{{ $user->grad->id }}" name="grad_id">
                                        <div class="d-flex justify-content-between">
                                            <select name="status" id="status" class="form-select form-control">
                                                <option value="1" @if($user->grad->status == 1) selected @endif>Ishga kirdi</option>
                                                <option value="2" @if($user->grad->status == 2) selected @endif>Ishga kirmadi</option>
{{--                                                <option value="3" @if($user->grad->status == 3) selected @endif>Ish izlayapti</option>--}}
                                                <option value="4" @if($user->grad->status == 4) selected @endif>Imtixondan o'tmadi</option>
                                                <option value="5" @if($user->grad->status == 5) selected @endif>BMI topshirmagan</option>
                                            </select>
                                            <button type="submit" class="btn-success"><i class="fa fa-check"></i></button>
                                        </div>
                                    </form>
                                </td>
                                <td class="">
<div class="d-flex justify-content-center">
                                        <a class="btn btn-warning btn-sm"
                                           href="{{ route('admin.students.edit',$user->id) }}">
                                            <span class="btn-label">
                                                <i class="fa fa-pen"></i>
                                            </span>
                                        </a>

                                        <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm show_confirm">
                                                <span class="btn-label">
                                                    <i class="fa fa-trash"></i>
                                                </span>
                                            </button>
                                        </form>
</div>

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
