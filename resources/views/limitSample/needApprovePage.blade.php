@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">
@endsection
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Need Approve</strong></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <strong href="index.html">Need Approve Limit Sample</strong>
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
            <table id="needApprove" class="display ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Model Part</th>
                        <th>Part</th>
                        <th>Part Area</th>
                        <th>Name</th>
                        <th>No Part</th>
                        <th>No Document</th>
                        <th>Expired Date</th>
                        <th >Opsi</th>
                        <!-- Remove Action column -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script> --}}
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap.min.js"></script>

    <script>
        var dataRoles = "{{ implode(',', session('roles', [])) }}";
        $(document).ready(function() {
            var table = $('#needApprove').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('limitSample.needApprovePage') }}", // Ensure this route points to your DataTable data
                columns: [
                    // {
                    //     data: 'id',
                    //     name: 'id',
                    //     className: 'text-center',
                    //     orderable: false
                    // },
                    {
                        data: null,
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Nomor urut sederhana
                        }
                    },
                    {
                        data: 'modelpart',
                        name: 'modelpart.name',
                        className: 'text-center',
                        render: function(data) {
                            return data ? data.name : 'No Model Part';
                        }
                    },
                    {
                        data: 'parts',
                        name: 'parts.name',
                        render: function(data) {
                            return data ? data.name : 'No Part';
                        }
                    },
                    {
                        data: 'partarea',
                        name: 'partarea.nameArea',
                        render: function(data) {
                            return data ? data.nameArea : 'No Part Area';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'part_number',
                        name: 'part_number',
                    },
                    {
                        data: 'document_number',
                        name: 'document_number',
                    },
                    {
                        data: 'expired_date',
                        name: 'expired_date',
                    },
                    {
                        data: 'id',
                        name: 'id',
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex justify-content-center">
                                <a href="{{ url('/limit-sample/area-part/') }}/${row.part_area_id}" class="btn btn-sm btn-primary m-1">
                                    See Detail
                                </a>
                                ${dataRoles == 'AdminLS' ? `
                                <a href="{{ url('/limit-sample/area-part/edit/') }}/${data}" class="btn btn-sm btn-primary m-1">
                                    Edit
                                </a>`: ''}
                            </div>`;
                        }
                    }
                ]
            });
            new $.fn.dataTable.FixedHeader(table);
        });
    </script>
@endsection
