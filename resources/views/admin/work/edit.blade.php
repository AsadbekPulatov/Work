@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Korxonani yangilash</h1></div>
                </div>
                <hr>
                <div class="card-body">


                    <form action="{{route('admin.works.update',$work->id)}}" method="POST" accept-charset="UTF-8" id="myForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="header_ru"> Buyruq raqami </label>
                            <input type="text" name="command" class="form-control" placeholder="Buyruq raqami" id="command" required value="{{ $work->command }}">
                        </div>
                        <div class="form-group">
                            <label for="number"> Korxona nomi </label>
                            <input type="text" name="firm_name" class="form-control" placeholder="Korxona nomi" id="name" required value="{{ $work->firm_name }}">
                        </div>
                        <div class="form-group">
                            <label for="header_ru"> Korxona manzili </label>
                            <input type="text" name="firm_address" class="form-control" placeholder="Korxona manzili" id="address" required value="{{ $work->firm_address }}">
                        </div>
                        <div class="form-group">
                            <label for="header_ru"> Telefon nomeri </label>
                            <input type="text" name="firm_phone" class="form-control" placeholder="Telefon nomeri" id="phone" required value="{{ $work->firm_phone }}">
                        </div>
                        <div class="form-group">
                            <label for="header_ru"> Korxona yili </label>
                            <input type="date" name="firm_year" class="form-control" id="year" required value="{{ $work->firm_year }}">
                        </div>
                        <div class="form-group">
                            <label for="header_ru"> Hujjat yuklang </label>
                            <input type="file" name="document" class="form-control-file form-control" accept=".pdf" id="document">
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
        let works = @json($works);
        // console.log(universities);
        // $('#myForm').validate();
        $(document).on('click', '#alert', function (e) {
            e.preventDefault();
            let cnt = 0;
            var name = $('#name').val();
            var phone = $('#phone').val();
            if (works.length == 0) $('#myForm').submit();
            for (let i = 0; i < works.length; i++) {
                if ((name == works[i].firm_name && name != @json($work->firm_name)) || (phone == works[i].firm_phone && phone != @json($work->firm_phone))) {
                    cnt++;
                    break;
                }
            }
            if (cnt > 0) {
                swal({
                    icon: 'error',
                    title: 'Xatolik',
                    text: 'Korxona oldin kiritilgan',
                    confirmButtonText: 'Continue',
                })
                $('#header_ru').val(@json($work->firm_name));
                $('#phone').val(@json($work->firm_phone));
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
