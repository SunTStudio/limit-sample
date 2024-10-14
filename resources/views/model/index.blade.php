@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">
@endsection

@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Model</strong> </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <strong href="index.html">Model</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
@endsection

@section('content')
    <section id="model">
        <div class="row justify-content-center m-1">
            <div class="col-lg-2 col-3 p-0 text-center">
                <button type="button" onclick="listModel()" class="btn btn-white"><i class="fa fa-list"></i></button>
                <button type="button" onclick="cardModel()" class="btn btn-white"><i
                        class="fa fa-window-restore"></i></button>
            </div>
            <div class="col-lg-5 col-8 rounded  mb-3" id="searchForm">
                <div class="autocomplete-container position-relative">
                    <form action="{{ route('model.search') }}" method="GET">
                        <div class="input-group">
                            <input placeholder="Search Models" autocomplete="off" id="search" type="text"
                                name="searchModel" class="form-control form-control-sm">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <ul id="autocomplete-results" class="list-group bg-white" style="list-style: none;"></ul>
                    </form>
                </div>
            </div>
            @hasRole('Admin')
                <div class="col-lg-2 col-10 text-center  mb-3">
                    <a href="{{ url('/limit-sample/model/create') }}" class="btn btn-secondary ">Tambah Model <i
                            class="fa fa-plus"></i></a>
                </div>
            @endhasRole()
        </div>

        <div class="row justify-content-center" id="modelCard">
            @foreach ($models as $model)
                <div class="col-lg-6 col-11 cardDisplay">
                    <div class="ibox">
                        <div class="ibox-content product-box">


                            <div class="product-imitation">
                                <a href="{{ url("/limit-sample/model/$model->id/part") }}"><img
                                        src="{{ asset("img/model/$model->foto_model") }}" class="img-fluid"
                                        alt=""></a>
                            </div>
                            <div class="product-desc">
                                <a href="#" class="product-name"> {{ $model->name }}</a>
                                <div class="m-t text-right d-flex justify-content-between">
                                    <div>

                                        <a href="{{ url("/limit-sample/model/$model->id/part") }}"
                                            class="btn btn-xs btn-outline btn-primary">See Detail <i
                                                class="fa fa-long-arrow-right"></i> </a>
                                        @hasRole('Admin')
                                            <a href="{{ url("/limit-sample/model/edit/$model->id") }}"
                                                class="btn btn-xs btn-outline btn-primary mr-1">Edit <i class="fa fa-edit"></i>
                                            </a>
                                        @endhasRole
                                    </div>
                                    @hasRole('Admin')
                                        <div class="d-flex">

                                            <form action="{{ url("/limit-sample/model/delete/$model->id") }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus Model ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                                                <button type="submit" class="btn btn-xs btn-outline btn-danger">Hapus <i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    @endhasRole
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class=" col-lg-10 col bg-white p-3" id="listDisplay" style="display: none;">
                <table id="listModel" class="display ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Model</th>
                            <th>Created_at</th>
                            <th>Opsi</th>
                            <!-- Remove Action column -->
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="text-center mb-5">
            {{ $models->links() }}
        </div>
    </section>
@endsection



@section('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script> --}}
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap.min.js"></script>
    <script>
        let listCount = 0;

        function listModel() {
            var dataRoles = "{{ implode(',', session('roles', [])) }}";
            let searchForm = document.getElementById('searchForm').style.display = 'none';
            let cardDisplay = document.getElementsByClassName('cardDisplay');
            for (let i = 0; i < cardDisplay.length; i++) {
                cardDisplay[i].style.display = 'none';
            }
            let listDisplay = document.getElementById('listDisplay');
            listDisplay.style.display = 'block'
            if (listCount == 0) {
                var table = $('#listModel').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('limitSample.listModel') }}",
                    columns: [{
                            data: null,
                            className: 'text-center',
                            orderable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + 1; // Nomor urut sederhana
                            }
                        },
                        {
                            data: 'name',
                            name: 'name',
                            className: 'text-center'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            className: 'text-center',
                            render: function(data, type, row) {
                                let dateOnly = data.substring(0, 10);
                                return dateOnly;
                            }
                        },
                        {
                            data: 'id',
                            name: 'id',
                            className: 'text-center',
                            orderable: false,
                            render: function(data, type, row) {
                                return `
                                <div class="d-flex justify-content-center">
                                    <a href="{{ url('/limit-sample/model/') }}/${data}/part" class="btn btn-sm btn-primary m-1">
                                        See Detail
                                    </a>
                                    ${dataRoles == 'Admin' ? `
                                                <a href="{{ url('/limit-sample/model/edit/') }}/${data}" class="btn btn-sm btn-primary m-1">
                                                    Edit
                                                </a>
                                                <div class="d-flex align-items-center">

                                                            <form action="{{ url('/limit-sample/model/delete/') }}/${data}" method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus Model ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                                                                <button type="submit" class="btn p-1 btn-danger">Hapus <i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                `: ''}
                                </div>`;
                            }
                        }
                    ]
                });
                new $.fn.dataTable.FixedHeader(table);
                listCount++;
            }


        }

        function cardModel() {
            let cardDisplay = document.getElementsByClassName('cardDisplay');
            let searchForm = document.getElementById('searchForm').style.display = 'block';
            for (let i = 0; i < cardDisplay.length; i++) {
                cardDisplay[i].style.display = 'block';
            }
            let listDisplay = document.getElementById('listDisplay');
            listDisplay.style.display = 'none'
        }
    </script>

    <script>
        function replaceSearch(searchValue) {
            let search = document.getElementById('search');
            search.value = searchValue; // Set the input value
            search.focus(); // Set focus back to the input
            $('#autocomplete-results').empty();
            let click = true; // Clear autocomplete results
            performSearch(searchValue, click);
        }

        function performSearch(query, click) {

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('model.search') }}",
                    type: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#autocomplete-results').empty();
                        $.each(data, function(index, item) {
                            $('#autocomplete-results').append(
                                '<li class="p-2 border" onclick="replaceSearch(\'' +
                                item.name + '\')">' + item.name + '</li>'
                            );
                        });

                        // Clear existing model cards
                        $('#modelCard').empty();

                        // Append new model cards
                        $.each(data, function(index, item) {
                            $('#modelCard').append(`
                                <div class="col-lg-6 col-11 mb-4 cardDisplay">
                                    <div class="ibox">
                                        <div class="ibox-content product-box">
                                            <div class="product-imitation">
                                                <img src="{{ asset('img/model/') }}/${item.foto_model}" class="img-fluid" alt="">
                                            </div>
                                            <div class="product-desc">
                                                <a href="#" class="product-name">${item.name}</a>
                                                <div class="m-t text-right d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <a href="{{ url('/limit-sample/model/') }}/${item.id}/part" class="btn btn-xs btn-outline btn-primary">See Detail <i class="fa fa-long-arrow-right"></i></a>
                                                                    @hasRole('Admin')

                                                            <a href="{{ url('/limit-sample/model/edit/') }}/${item.id}" class="btn btn-xs btn-outline btn-primary mr-1">Edit <i class="fa fa-edit"></i></a>
                                                        @endhasRole
                                                    </div>
                                                                @hasRole('Admin')

                                                        <div>
                                                            <form action="{{ url('/limit-sample/model/delete/') }}/${item.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Model ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-xs btn-outline btn-danger">Hapus <i class="fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    @endhasRole
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            `);
                        });
                        $('#modelCard').append(`
                                <div class=" col-lg-10 col bg-white p-3" id="listDisplay" style="display: none;">
                                    <table id="listModel" class="display ">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Model</th>
                                                <th>Created_at</th>
                                                <th>Opsi</th>
                                                <!-- Remove Action column -->
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                        `);
                        if (click == true) {
                            $('#autocomplete-results').empty();
                        }
                        listCount = 0;
                    }
                });
            } else {
                $('#autocomplete-results').empty();
            }
        }

        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let click = false;
                var query = $(this).val();
                performSearch(query, click); // Call performSearch on keyup
            });
        });
        $(document).click(function(event) {
            if (!$(event.target).closest('#autocomplete-results').length) {
                $('#autocomplete-results').hide();
            }
        });
    </script>
@endsection
