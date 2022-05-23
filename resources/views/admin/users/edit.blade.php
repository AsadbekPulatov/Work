@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Tahrirlash</h1></div>
                </div>
                <hr>
                <div class="card-body">




                    <form action="{{route('admin.users.update',$user)}}" method="POST" accept-charset="UTF-8">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="header_ru">Ism</label>
                            <input type="text" name="name" required class="form-control" id="header_ru"
                                   value="{{$user->user_infos->name}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="header_ru">Familya</label>
                            <input type="text" name="surname" required class="form-control" id="header_ru"
                                   value="{{$user->user_infos->surname}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="header_ru">Sharif</label>
                            <input type="text" name="father_name" required class="form-control" id="header_ru"
                                   value="{{$user->user_infos->father_name}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="header_ru">Tug'ilgan sana</label>
                            <input type="date" name="sana" required class="form-control" id="header_ru"
                                   value="{{$user->user_infos->birthdate}}" >
                        </div>
                        <div class="form-group">
                            <label for="header_ru">Passport seriyasi va raqami</label>
                            <input type="text" name="passport" required class="form-control" id="header_ru"
                                   value="{{$user->user_infos->passport}}" placeholder="AA0001122">
                        </div>
                        <div class="form-group">
                            <label for="header_ru">Telefon raqami</label>
                            <input type="text" name="phone" required class="form-control" id="header_ru"
                                   value="{{$user->user_infos->phone}}" placeholder="+998001112233">
                        </div>
                        <div class="form-group">
                            <label for="header_ru">Manzil</label>
                            <input type="text" name="address" required class="form-control" id="header_ru"
                                   value="{{$user->user_infos->address}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="header_ru">Email</label>
                            <input type="email" name="email" required class="form-control" id="header_ru"
                                   value="{{$user->email}}" placeholder="user@example.com">
                        </div>
                        <div class="form-group">
                            <label for="header_ru">Parol o'rnating</label>
                            <input type="password" name="password" required class="form-control" id="myInput1"
                                   placeholder="password">
                        </div>
                        <div class="form-group">
                            <label for="header_ru">Parolni takrorlang</label>
                            <input type="password" name="password_confirm" required class="form-control" id="myInput2"
                                   placeholder="password">
                            <input type="checkbox" onclick="myFunction1()" id="chb">
                            <label for="chb">Parolni ko'rsatish</label>
                        </div>
                        <input type="hidden" name="turi" value="user">
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

        function myFunction1() {
            var x = document.getElementById("myInput1");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            var x = document.getElementById("myInput2");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
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
