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
                </div>
            </div>


                <div class="card-body">
                    <form action="{{route('admin.replace.update',$data->id)}}" method="POST" accept-charset="UTF-8"                    >
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="tbr">Talaba joylashgan xona</label>
                            <select name="room_id" class="form-select form-control form-select-lg mb-3" id="tbr"
                                    aria-label=".form-select-lg example">
                                <option value="{{$room_old->id}}" selected>{{$room_old->room_number}}</option>
                                <option value="0" >Talabani joriy xonadan chiqarish</option>

                            @foreach($rooms as $room)
                                    @if($room->id==$room_old->id)
                                        @continue
                                    @endif
                                    <option value="{{$room->id}}">{{$room->room_number}}</option>
                                @endforeach
                            </select>
                        </div>



                        <button type="submit" id="alert" class="btn btn-primary">Saqlash</button>
                        <input type="reset" class="btn btn-danger" value="Tozalash">
                    </form>
                </div>
                </div>
            </div>
@endsection
@section('script')
    <script>

        let errors =@json($errors->all());
        @if($errors->any())
        console.log(errors);

        let msg = '';
        for (let i = 0; i < errors.length; i++) {
            msg += (i + 1) + '-xatolik ' + errors[i] + '\n';
        }
        console.log(msg);
        if (msg != '') {
            swal({
                icon: 'error',
                title: 'Xatolik',
                text: msg,
                confirmButtonText: 'Continue',
            })

        }
        @endif


    </script>
@endsection


