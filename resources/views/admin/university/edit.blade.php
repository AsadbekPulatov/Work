@extends('admin.master')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10"><h1 class="card-title">Universitet Qo'shing</h1></div>
                </div>
                <hr>
                <div class="card-body">


                    <form action="{{route('admin.universities.update',$university->id)}}" method="POST" accept-charset="UTF-8" id="myForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="number"> Universititet Nomi </label>
                            <input type="text" name="name" class="form-control"  placeholder="" id="number" value="{{$university->name}}">
                        </div>


                        <div class="form-group">
                            <label for="header_ru"> Universitet Manzili </label>
                            <input type="text" name="address" class="form-control" placeholder="" value="{{$university->address}}">
                        </div>
                        <div class="form-group">
                            <label for="header_ru"> Telefon Nomeri </label>
                            <input type="text" name="phone" class="form-control" placeholder="" value="{{$university->phone}}">
                        </div>
                        <div class="form-group">
                            <label for="header_ru"> Email Manzili </label>
                            <input type="text" name="email" class="form-control" placeholder="" value="{{$university->email}}">
                        </div>



                        <button type="submit" id="alert" class="btn btn-primary">Saqlash</button>
                        <input type="reset" class="btn btn-danger" value="Tozalash">

                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
