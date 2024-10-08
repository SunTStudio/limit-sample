@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

@endsection
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Activity</strong></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <strong href="index.html">Activity Guest</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <!-- Optional: You can add buttons or other controls here if needed -->
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center m-3">
        <div class="col bg-white p-3">
            <table id="activity" class="display ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIK/Tanda Pengenal</th>
                        <th>Kunjungan Terakhir</th>
                        <th>Jumlah Kunjungan</th>
                        <!-- Remove Action column -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#activity').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('guests.datatables') }}", // Ensure this route points to your DataTable data
                columns: [
                    { data: 'id', name: 'id', className: 'text-center', orderable: false },
                    { data: 'guest_name', name: 'guest_name', className: 'text-center' }, // Adjust based on your actual data column
                    { data: 'login_date', name: 'login_date', className: 'text-center' }, // Adjust based on your actual data column
                    { data: 'count_visit', name: 'count_visit', className: 'text-center' },
                ]
            });
        });
    </script>
@endsection
