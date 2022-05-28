@extends('admin.master')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Statistika</b></div>
                <div class="d-flex">
                    <a href="{{ route('admin.statistic') }}" class="page-link">hammasi</a>
                    @foreach($groups as $group)
                        <a href="{{ route('admin.statistic', ['id' => $group->id]) }}" class="page-link">{{ $group->name }}</a>
                    @endforeach
                </div>
                <div class="panel-body">
                    <canvas id="canvas" height="280" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js"
            charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
    <script>
        let students = @json($students);
        let n1 = @json($n1);
        let n2 = @json($n2);
        {{--let n3 = @json($n3);--}}
        let n4 = @json($n4);
        let n5 = @json($n5);
        // console.log(students.length, n1.length, n2.length, n3.length, n4.length, n5.length);
        $(document).ready(function () {
            var ctx = document.getElementById("canvas").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    // labels: Years,
                    datasets: [
                        {
                            label: 'Talabalar',
                            data: [students.length],
                            backgroundColor: ["blue"],
                            borderWidth: 1
                        },
                        {
                            label: 'Ishga kirganlar',
                            data: [n1.length],
                            backgroundColor: ["green"],
                            borderWidth: 1
                        },
                        {
                            label: 'Ishga kirmaganlar',
                            data: [n2.length],
                            // backgroundColor: ["gray"],
                            backgroundColor: ["red"],
                            borderWidth: 1
                        },
                        // {
                        //     label: 'Ish izlayotganlar',
                        //     data: [n3.length],
                        //     backgroundColor: ["orange"],
                        //     borderWidth: 1
                        // },
                        {
                            label: 'Imtixondan o`tmaganlar',
                            data: [n4.length],
                            // backgroundColor: ["red"],
                            backgroundColor: ["gray"],
                            borderWidth: 1
                        },
                        {
                            label: 'BMI topshirmaganlar',
                            data: [n5.length],
                            // backgroundColor: ["yellow"],
                            backgroundColor: ["gray"],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endsection

