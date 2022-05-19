@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Fakultet qo'shing</h1></div>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{route('admin.facultets.store')}}" method="POST" accept-charset="UTF-8" id="myForm">
                        @csrf
                        <div class="form-group">
                            <label for="header_ru">Universitet nomi</label>
                            <select name="university_id" id="university_id" class="form-select form-control">
                                <option value="">Universitetni tanlang</option>
                                @foreach($universities as $university)
                                    <option value="{{ $university->id }}">{{ $university->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="header_ru">Fakultet nomi</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Fakultet nomi">
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
        $(document).on('click', '#alert', function (e) {
            e.preventDefault();
            let cnt = 0;
            var value = $('#name').val();
            var id = $('#university_id').val();
            if (facultets.length == 0) $('#myForm').submit();
            for (let i = 0; i < facultets.length; i++) {
                if (value == facultets[i].name && id == facultets[i].university_id) {
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
                $('#name').val('');
            } else
                $('#myForm').submit();
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
