@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Universitetni yangilash</h1></div>
                </div>
                <hr>
                <div class="card-body">


                    <form action="{{route('admin.universities.update',$university->id)}}" method="POST" accept-charset="UTF-8" id="myForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="number"> Universititet Nomi </label>
                            <input type="text" name="name" class="form-control"  placeholder="" id="name" value="{{$university->name}}" required>
                        </div>

                        <div class="form-group">
                            <label for="header_ru"> Universitet Manzili </label>
                            <input type="text" name="address" class="form-control" placeholder="" id="address" value="{{$university->address}}" required>
                        </div>
                        <div class="form-group">
                            <label for="header_ru"> Telefon Nomeri </label>
                            <input type="text" name="phone" class="form-control" placeholder="" id="phone" value="{{$university->phone}}" required>
                        </div>
                        <div class="form-group">
                            <label for="header_ru"> Email Manzili </label>
                            <input type="text" name="email" class="form-control" placeholder="" id="email" value="{{$university->email}}" required>
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
        let universities = @json($universities);
        // console.log(universities);
        // $('#myForm').validate();
        $(document).on('click', '#alert', function (e) {
            e.preventDefault();
            let cnt = 0;
            var name = $('#name').val();
            var email = $('#email').val();
            if (universities.length == 0) $('#myForm').submit();
            for (let i = 0; i < universities.length; i++) {
                if ((name == universities[i].name && name != @json($university->name)) || (email == universities[i].email && email != @json($university->email))) {
                    cnt++;
                    break;
                }
            }
            if (cnt > 0) {
                swal({
                    icon: 'error',
                    title: 'Xatolik',
                    text: 'Universitet oldin kiritilgan',
                    confirmButtonText: 'Continue',
                })
                $('#header_ru').val(@json($university->name));
                $('#address').val(@json($university->address));
                $('#phone').val(@json($university->phone));
                $('#email').val(@json($university->email));
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
