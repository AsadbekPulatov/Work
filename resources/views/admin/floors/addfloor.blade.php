@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Qavat qo'shing</h1></div>
                </div>
                <hr>
                <div class="card-body">

{{--                    @if ($errors->any())--}}
{{--                        <div class="alert alert-danger">--}}
{{--                            <strong>Whoops! </strong> <br><br>--}}
{{--                            <ul>--}}
{{--                                @foreach ($errors->all() as $error)--}}
{{--                                    <li>{{ $error }}</li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    @endif--}}


                    <form action="{{route('admin.floors.store')}}" method="POST" accept-charset="UTF-8" id="myForm">
                        @csrf
                        <div class="form-group">
                            <label for="header_ru"> Binoni tanlang</label>
                            <select class="form-control" name="bino_id" id="building">
                                <option value="0">Binoni tanlang</option>
                                @foreach($buildings as $building)
                                <option value="{{$building->id}}">{{$building->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="header_ru"> Qavat raqami </label>
                            <input type="text" name="floor" class="form-control"  id="floor" placeholder="0-etaj">
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
        let facultets = @json($floors);
        let floors = new Array();
        $('#building').on('change', function () {
            facultets = @json($floors);
            floors = new Array();
            var value = $(this).val();
            for (let i = 0; i < facultets.length; i++) {
                if (value == facultets[i].bino_id) {
                    floors.push(facultets[i].id)
                }
            }
            // alert(floors);
        });

        $(document).on('click', '#alert', function (e) {
            e.preventDefault();
            let cnt = 0;
            var value = $('#floor').val();
            var building = $('#building').val();
            if (facultets.length == 0) $('#myForm').submit();
            for (let i = 0; i < facultets.length; i++) {
                if (value == facultets[i].floor && building == facultets[i].bino_id) {
                    cnt++;
                }
            }
            if (cnt > 0) {
                swal({
                    icon: 'error',
                    title: 'Xatolik',
                    text: 'Bu qavat oldin kiritilgan',
                    confirmButtonText: 'Continue',
                })
                $('#floor').val('');
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
