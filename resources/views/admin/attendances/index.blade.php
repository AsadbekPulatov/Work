@extends('admin.master')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9"><h1 class="card-title">Davomat</h1></div>
                    <div class="col-md-1">
                        @if(\Illuminate\Support\Facades\Auth::user()->role != 'admin')
                            <a class="btn btn-primary" href="{{route('admin.attendances.create')}}">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                                Davomat olish
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
                            <th scope="col">Talaba</th>
                            <th scope="col">Xona</th>
                            <th scope="col">Tekshirish</th>
                            <th scope="col">Sana</th>
                            {{--                            <th scope="col">Amallar</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attendances as $key => $attendance)
                            @if($attendance->check == 1)
                                <tr>
                                    <th scope="row" class="col-1">{{ $key+1 }}</th>
                                    <td>@if(isset($attendance->student->name)) {{$attendance->student->name}} @endif </td>
                                    <td> @if(isset($attendance->room->room_number)) {{$attendance->room->room_number}} @endif </td>
                                    @if($attendance->check == 1)
                                        <td> Yo'q</td>
                                    @endif
                                    <td>{{ $attendance->created_at }}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <div class="container">
                        <div class="row justify-content-center">


                            @if ($attendances->links())
                                <div class="mt-4 p-4 box has-text-centered">
                                    {{ $attendances->links() }}
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
@endsection
