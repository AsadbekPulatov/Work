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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{route('admin.facultets.update',$post->id)}}" method="POST" id="myForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="description_ru">Fakultet</label>
                            <input type="text" name="name" class="form-control" id="header_ru" placeholder="Fakultet"
                                   value="{{$post->name}}">
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
            var value = $('#header_ru').val();
            if (facultets.length == 0) $('#myForm').submit();
            for (let i = 0; i < facultets.length; i++) {
                if (value == facultets[i].name && value != @json($post->name)) {
                    cnt++;
                }
            }
            if (cnt > 0) {
                swal({
                    icon: 'error',
                    title: 'Xatolik',
                    text: 'Bu fakultet oldin kiritilgan',
                    confirmButtonText: 'Continue',
                })
                $('#header_ru').val(@json($post->name));
            } else $('#myForm').submit();
        });
    </script>
@endsection
