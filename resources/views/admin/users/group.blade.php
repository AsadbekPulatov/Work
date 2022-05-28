@extends('admin.master')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9"><h1 class="card-title">Guruhlar</h1></div>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table table-bordered text-uppercase">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nomi</th>
                            <th scope="col">Faculty</th>
                            <th scope="col">University</th>
                            <th scope="col" class="w-25">Ammallar</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($groups as $ind=>$group)
                            <tr>
                                <th scope="row" class="col-1"> {{$ind+1}} </th>
                                <td>
                                    <a href="{{ route('admin.students.index', ['id' => $group->id]) }}" class="page-link">
                                        {{ $group->name }}
                                    </a>
                                </td>
                                <td>{{ $group->faculty->name }}</td>
                                <td>{{ $group->faculty->university->name }}</td>
                                <td class="col-2">
                                    <form action="{{ route('admin.groups.destroy',$group->id) }}" method="POST">


                                        <a class="btn btn-warning btn-sm"
                                           href="{{ route('admin.groups.edit',$group->id) }}">
                                                <span class="btn-label">
                                                    <i class="fa fa-pen"></i>
                                                </span>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger btn-flat show_confirm"
                                                data-toggle="tooltip">
                                                    <span class="btn-label">
                                                        <i class="fa fa-trash"></i>
                                                    </span>
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <section class="content12 cid-t34gh8nW7r" id="content12-2s">

                        <div class="container">
                            <div class="row justify-content-center">
                                @if ($groups->links())
                                    <div class="mt-4 p-4 box has-text-centered">
                                        {{ $groups->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection
