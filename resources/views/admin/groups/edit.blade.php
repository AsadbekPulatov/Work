@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Guruhni yangilash</h1></div>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{route('admin.groups.update',$data->id)}}" method="POST" accept-charset="UTF-8" id="myForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="header_ru">Guruh nomi</label>
                            <input type="text" required name="name" class="form-control" id="header_ru" placeholder="" value="{{$data->name}}">
                        </div>

                        <button type="submit" class="btn btn-primary" id="alert">Saqlash</button>
                        <input type="reset" class="btn btn-danger" value="Tozalash">
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        let groups = @json($groups);
        // console.log(groups);
        $(document).on('click', '#alert', function (e) {
            e.preventDefault();
            let cnt = 0;
            var value = $('#header_ru').val();
            if (groups.length == 0) $('#myForm').submit();
            for (let i = 0; i < groups.length; i++) {
                if (value == groups[i].name && value != @json($data->name)) {
                    cnt++;
                    break;
                }
            }
            if (cnt > 0) {
                swal({
                    icon: 'error',
                    title: 'Xatolik',
                    text: 'Guruh oldin kiritilgan',
                    confirmButtonText: 'Continue',
                })
                $('#header_ru').val(@json($data->room_number));
            } else  $('#myForm').submit();
        });
    </script>
    <script>
        let errors = @json($errors->all());
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
