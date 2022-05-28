@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Guruh qo'shing</h1></div>
                </div>
                <hr>
                <div class="card-body">

                    <form action="{{route('admin.groups.store')}}" method="POST" accept-charset="UTF-8" id="myForm">
                        @csrf

                        <div class="form-group">
                            <label for="university_id"> Universitet </label>
                            <select name="university_id" required class="form-select form-control form-select-lg mb-3"  id="university">
                                <option value="" selected>Universitetni tanlang</option>
                                @foreach($universities as $university)
                                    <option value="{{$university->id}}">{{$university->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="faculty_id"> Fakultet </label>
                            <select name="faculty_id" required class="form-select form-control form-select-lg mb-3"  id="faculty">
                                <option value="" selected>Fakultetni tanlang</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name"> Guruh nomi </label>
                            <input type="text" name="name" class="form-control"  placeholder="" id="name" required>
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
        let faculties = @json($faculties);
        $('#university').on('change', function() {
            var value = $(this).val();
            $('#faculty').empty();
            $('#faculty').append("<option value=''>Fakultetni tanlang</option>")
            for (let i = 0; i < faculties.length; i++) {
                if (value == faculties[i].university_id) {
                    var option = document.createElement("option");   // Create with DOM
                    option.innerHTML = faculties[i].name;
                    option.value = faculties[i].id;
                    $('#faculty').append(option);
                }
            }
        });
        let groups = @json($groups);
        // console.log(groups);
        $(document).on('click', '#alert', function (e) {
            e.preventDefault();
            let cnt = 0;
            var value = $('#name').val();
            var faculty = $('#university').val();
            if (groups.length == 0) $('#myForm').submit();
            for (let i = 0; i < groups.length; i++) {
                if (value == groups[i].name && faculty == groups[i].university_id) {
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
                $('#name').val('');
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
