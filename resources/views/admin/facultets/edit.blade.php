@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Fakultetni yangilash</h1></div>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{route('admin.facultets.update',$post->id)}}" method="POST" id="myForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="description_ru">Fakultet</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Fakultet"
                                   value="{{$post->name}}" required>
                        </div>
                        <button type="submit" id="alert" class="btn btn-primary">Saqlash</button>
                        <input type="reset" class="btn btn-danger" value="Tozalash">
                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        let facultets = @json($facultets);
        // $('#myForm').validate();
        $(document).on('click', '#alert', function (e) {
            e.preventDefault();
            let cnt = 0;
            var value = $('#name').val();
            if (facultets.length == 0) $('#myForm').submit();
            for (let i = 0; i < facultets.length; i++) {
                if (value == facultets[i].name && value != @json($post->name) && @json($post->university_id) == facultets[i].university_id) {
                    cnt++;
                    break;
                }
            }
            if (cnt > 0) {
                swal({
                    icon: 'error',
                    title: 'Xatolik',
                    text: 'Fakultet oldin kiritilgan',
                    confirmButtonText: 'Continue',
                })
                $('#header_ru').val(@json($post->name));
            } else $('#myForm').submit();
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
