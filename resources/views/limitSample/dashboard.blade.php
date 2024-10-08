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
    <div class="row  m-3 ">
        <div class="col-sm-7 col-12">
            <div class="row justify-content-between" id="rekapA">
                <div class="col-4">
                    <div class="text-center bg-white p-2">
                        <p class="m-0"> <strong> Expired </strong></p>
                        <hr class="m-1">
                        <p class="h3 m-0">{{ $expired }}</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center bg-white p-2">
                        <p class="m-0"> <strong> Will Expired </strong></p>
                        <hr class="m-1">
                        <p class="h3 m-0">{{ $willExpired }}</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center bg-white p-2">
                        <p class="m-0"> <strong> Today Visitor  </strong></p>
                        <hr class="m-1">
                        <p class="h3 m-0">{{ $TodayVisitWeb }}</p>
                    </div>
                </div>
            </div>
            <div class="row" id="rekapB">
                <div class="col mt-3 mr-3 ml-3 p-3 bg-white">
                    <div id="chartContainer" style="height: 250px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-12 bg-white p-3" id="rekapC">

            <h3 class="text-center">Top Visiting Page</h3>
            <div class="tables-container">
                <!-- Tabel Model -->
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Model</th>
                        </tr>
                    </thead>
                    <tbody>
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
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Part</th>
                        </tr>
                    </thead>
                    <tbody>
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
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Area Part</th>
                        </tr>
                    </thead>
                    <tbody>
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
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Menggunakan AJAX untuk mengambil data
        $.ajax({
            url: '/visits-data', // URL endpoint API
            type: 'GET', // Tipe request
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
</script>
@endsection
