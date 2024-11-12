@extends('layouts.app')

@section('css')
    <style>
        .tables-container p {
            font-size: 0.7rem;
            margin: 0;
        }

        .tables-container {
            display: flex;
            justify-content: space-around;
        }

        table {
            width: 30%;
        }
    </style>
@endsection
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Dashboard</strong> </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <strong href="index.html">Dashboard</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
@endsection
@section('content')
    <div class="row  m-2 p-2 " id="tabel-kunjungan">
        <div class="col-sm-6 col-12">
            <div class="row justify-content-between" id="rekapA">
                <div class="col m-0 p-1 pl-3">
                    <div class="text-center bg-white p-2 border">
                        <a href="{{ route('limitSample.allExpired') }}">
                            <p class="m-0 text-danger"> <strong> Sample <br> Expired </strong></p>
                            <hr class="m-1">
                            <p class="h3 m-0 text-danger">{{ $expired }}</p>
                        </a>
                    </div>
                </div>
                <div class="col m-0 p-1">
                    <a href="{{ route('limitSample.willExpired') }}">
                        <div class="text-center bg-white p-2 border">
                            <p class="m-0"> <strong> Will <br> Expired </strong></p>
                            <hr class="m-1">
                            <p class="h3 m-0">{{ $willExpired }}</p>
                        </div>
                    </a>
                </div>
                @if (
                    (auth()->user()->position->position == 'Supervisor' && auth()->user()->id == $secHead1->user_id) ||
                        (auth()->user()->position->position == 'Supervisor' && auth()->user()->id == $secHead2->user_id))
                    <div class="col m-0 p-1 ">
                        <a href="{{ route('limitSample.needApprovePage') }}">
                            <div class="text-center bg-white p-2 border">
                                <p class="m-0"> <strong> Need <br> Approve </strong></p>
                                <hr class="m-1">
                                <p class="h3 m-0">{{ $NeedApproveSecHead }}</p>
                            </div>
                        </a>
                    </div>
                @endif
                @if (auth()->user()->position->position == 'Department Head' && auth()->user()->id == $DeptHead->user_id)
                    <div class="col m-0 p-1">
                        <a href="{{ route('limitSample.needApprovePage') }}">
                            <div class="text-center bg-white p-2 border">
                                <p class="m-0"> <strong> Need <br> Approve </strong></p>
                                <hr class="m-1">
                                <p class="h3 m-0">{{ $NeedApproveDeptHead }}</p>
                            </div>
                        </a>
                    </div>
                @endif
                <div class="col m-0 p-1 pr-3">
                    <a href="{{ route('limitSample.activity') }}">
                        <div class="text-center bg-white p-2 border">
                            <p class="m-0"> <strong> Today <br> Visitor </strong></p>
                            <hr class="m-1">
                            <p class="h3 m-0">{{ $TodayVisitWeb }}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row" id="rekapB">
                <div class="col mt-3 mr-3 ml-3 p-3 bg-white text-center border">
                    <div class="btn-group btn-group-toggle m-2">
                        <label class="btn btn-sm btn-white">
                            <input type="radio" id="VisitWeek" name="options" value="2" autocomplete="off"
                                onclick="VisitWeek()"> Mingguan
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" id="VisitMonth" name="options" value="3" autocomplete="off"
                                onclick="VisitMonth()"> Bulanan
                        </label>
                    </div>
                    <div id="chartContainer" style="height: 250px; width: 100%;"></div>

                    <!-- Tombol untuk mengambil tangkapan layar -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-12 bg-white  text-center border" id="rekapC">

            <h3 class="m-0 p-3">Top Visiting Page</h3>
            {{-- <div class="btn-group btn-group-toggle m-2">
                <label class="btn btn-sm btn-white ">
                    <input type="radio" id="VisitDay" name="options" value="1" autocomplete="off"
                        onclick="VisitPageDay()"> Day
                </label>
                <label class="btn btn-sm btn-white ">
                    <input type="radio" id="VisitWeek" name="options" value="2" autocomplete="off"
                        onclick="VisitPageWeek()"> Week
                </label>
                <label class="btn btn-sm btn-white ">
                    <input type="radio" id="VisitMonth" name="options" value="3" autocomplete="off"
                        onclick="VisitPageMonth()"> Month
                </label>
            </div> --}}
            <div class="tables-container" >
                <!-- Tabel Model -->
                <table class="table table-bordered table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>Model</th>
                        </tr>
                    </thead>
                    <tbody id="modelVisitPage">
                        @foreach ($models as $model)
                            <tr>
                                <td>
                                    <p><strong>{{ $model->name }}</strong></p>
                                    <p>({{ $model->count_visit }} kali)</p>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <!-- Tabel Part -->
                <table class="table table-bordered table-hover table-striped text-center" >
                    <thead>
                        <tr>
                            <th>Part</th>
                        </tr>
                    </thead>
                    <tbody id="partVisitPage">
                        @foreach ($parts as $part)
                            <tr>
                                <td>
                                    <p><strong>{{ $part->name }}</strong></p>
                                    <p>({{ $part->count_visit }} kali)</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Tabel Area Part -->
                <table class="table table-bordered table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>Area Part</th>
                        </tr>
                    </thead>
                    <tbody id="areaPartVisitPage">
                        @foreach ($partAreas as $partArea)
                            <tr>
                                <td>
                                    <p><strong>{{ $partArea->nameArea }}</strong></p>
                                    <p>({{ $partArea->count_visit }} kali)</p>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <!-- Tabel Limit Sample -->
                <table class="table table-bordered table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>Limit Sample</th>
                        </tr>
                    </thead>
                    <tbody id="areaPartVisitPage">
                        @foreach ($AreaParts as $AreaPart)
                            <tr>
                                <td>
                                    <p><strong>{{ $AreaPart->name }}</strong></p>
                                    <p>({{ $AreaPart->count_visit }} kali)</p>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <button id="captureButton" class="btn btn-primary mb-3" onclick="captureScreen()"><i
                    class="fa fa-download"></i></button>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


    <script>
        function captureScreen() {
            // Mengambil elemen dengan ID "rekapB"
            var captureElement = document.getElementById("tabel-kunjungan");

            // Mengambil tangkapan layar dari elemen dengan ID "rekapB"
            html2canvas(captureElement).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                var link = document.createElement('a');
                link.download = 'Rekap.png';
                link.href = imgData;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        }
    </script>
    <script>
        //grafik mingguan
        function VisitWeek() {
            let VisitDay = document.getElementById('VisitWeek');
            $(document).ready(function() {
                // Menggunakan AJAX untuk mengambil data
                $.ajax({
                    url: '{{ url('/visits-data') }}', // URL endpoint API
                    type: 'GET', // Tipe request
                    data: {
                        sort: 'week',
                    },
                    dataType: 'json', // Tipe data yang diharapkan
                    success: function(data) {
                        const dataPoints = data.map(item => ({
                            x: new Date(item.date), // Mengonversi tanggal ke format Date
                            y: item.total // Total kunjungan
                        }));

                        // Buat grafik
                        const chart = new CanvasJS.Chart("chartContainer", {
                            title: {
                                text: "Grafik Kunjungan Website Mingguan"
                            },
                            axisX: {
                                title: "Tanggal",
                                valueFormatString: "DD MMM"
                            },
                            axisY: {
                                title: "Total Kunjungan",
                                includeZero: true
                            },
                            data: [{
                                type: "line", // Tipe grafik
                                dataPoints: dataPoints // Data untuk grafik
                            }]
                        });

                        // Render grafik
                        chart.render();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error); // Menangani kesalahan
                    }
                });
            });

        }

        //grafik Bulanan
        function VisitMonth() {
            let VisitDay = document.getElementById('VisitMonth');
            $(document).ready(function() {
                // Menggunakan AJAX untuk mengambil data
                $.ajax({
                    url: '{{ url('/visits-data') }}', // URL endpoint API
                    type: 'GET', // Tipe request
                    data: {
                        sort: 'month',
                    },
                    dataType: 'json', // Tipe data yang diharapkan
                    success: function(data) {
                        const dataPoints = data.map(item => ({
                            x: new Date(item.date), // Mengonversi tanggal ke format Date
                            y: item.total // Total kunjungan
                        }));

                        // Buat grafik
                        const chart = new CanvasJS.Chart("chartContainer", {
                            title: {
                                text: "Grafik Kunjungan Website Bulanan"
                            },
                            axisX: {
                                title: "Tanggal",
                                valueFormatString: "DD MMM"
                            },
                            axisY: {
                                title: "Total Kunjungan",
                                includeZero: true
                            },
                            data: [{
                                type: "line", // Tipe grafik
                                dataPoints: dataPoints // Data untuk grafik
                            }]
                        });

                        // Render grafik
                        chart.render();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error); // Menangani kesalahan
                    }
                });
            });

        }


        //grafik mingguan default
        $(document).ready(function() {
            // Menggunakan AJAX untuk mengambil data
            VisitWeek();
        });
    </script>
@endsection
