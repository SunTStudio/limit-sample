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
            <h2>Limit Sample - <strong>Part D26A</strong> </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/limit-sample/model') }}">Model</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Part</strong>
                </li>
                {{-- <li class="breadcrumb-item ">
                <strong>Grid Opons</strong>
            </li> --}}
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
@endsection

@section('content')
    <section id="part">
        <div class="row justify-content-center m-1">
            <div class="col-lg-2 col-3 p-0 text-center">
                <button type="button" onclick="listModel()" class="btn btn-white"><i class="fa fa-list"></i></button>
                <button type="button" onclick="cardModel()" class="btn btn-white"><i
                        class="fa fa-window-restore"></i></button>
            </div>
            <div class="col-lg-5 col-8 rounded  mb-3" id="searchForm">
                <div class="autocomplete-container position-relative">
                    <form action="{{ route('part.search', ['id' => $model->id]) }}" method="GET">
                        <div class="input-group">
                            <input placeholder="Search Part" id="search" autocomplete="off" type="text"
                                name="searchPart" class="form-control form-control-sm">
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
                    <a href="{{ url("limit-sample/model/$model->id/part/create") }}" class="btn btn-secondary ">Tambah Part
                        <i class="fa fa-plus"></i></a>
                </div>
            @endhasRole
        </div>
        <div class="row justify-content-center" id="partCard">
            @foreach ($parts as $part)
                <div class="col-lg-6 col-12 p-2 cardDisplay">
                    <div class="ibox">
                        <div class="ibox-content product-box">


                            <div class="product-imitation">
                                <a href="{{ url("/limit-sample/part/$part->id") }}"><img
                                        src="{{ asset("img/part/$part->foto_part") }}" class="img-fluid" alt=""></a>
                            </div>
                            <div class="product-desc p-3">
                                <a href="#" class="product-name"> {{ $part->name }}</a>
                                <div class="m-t text-right">

                                    <a href="{{ url("/limit-sample/part/$part->id") }}"
                                        class="btn btn-xs btn-outline btn-primary">Lihat <i
                                            class="fa fa-long-arrow-right"></i> </a>
                                    @hasRole('Admin')
                                        <a href="{{ url("/limit-sample/part/edit/$part->id") }}"
                                            class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
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
                            <th>Part</th>
                            <th>Created_at</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="text-center">
            {{ $parts->links() }}
            <br>
            <a href="{{ url('/limit-sample/model') }}" class="btn btn-secondary mb-5">Kembali</a>
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
                    ajax: "{{ route('part.listPart', ['id' => $model->id]) }}",
                    columns: [
                        {
                            data: null,
                            className: 'text-center',
                            orderable: false,
                            render: function(data, type, row, meta) {
                                var pageInfo = table.page.info(); // Use the `table` variable to get the page info
                                return pageInfo.start + meta.row + 1; // Adjusts the row number based on the start index of the current page
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
                                    <a href="{{ url('/limit-sample/part/') }}/${data}" class="btn btn-sm btn-primary m-1">
                                        See Detail
                                    </a>
                                    ${dataRoles == 'Admin' ? `
                                                <a href="{{ url('/limit-sample/part/edit/') }}/${data}" class="btn btn-sm btn-primary m-1">
                                                    Edit
                                                </a>
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
        // Pass the model ID from the backend to JavaScript
        var modelId = {{ $model->id }};

        function replaceSearch(searchValue) {
            let search = document.getElementById('search');
            search.value = searchValue; // Set the input value
            search.focus(); // Set focus back to the input
            $('#autocomplete-results').empty(); // Clear autocomplete results
            let click = true;
            // Manually trigger the search AJAX call
            performSearch(searchValue, click);
        }

        function performSearch(query, click) {
            if (query.length >= 0) {
                $.ajax({
                    url: "{{ route('part.search', ['id' => $model->id]) }}",
                    type: "GET",
                    data: {
                        query: query,
                        id: modelId // Send model ID in the request data if needed
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
                        $('#partCard').empty();

                        // Append new model cards
                        $.each(data, function(index, item) {
                            $('#partCard').append(`
                            <div class="col-lg-6 col-12 p-2 cardDisplay">
                                <div class="ibox">
                                    <div class="ibox-content product-box">
                                        <div class="product-imitation">
                                            <img src="{{ asset('img/part/') }}/${item.foto_part}" class="img-fluid" alt="">
                                        </div>
                                        <div class="product-desc p-3">
                                            <a href="#" class="product-name">${item.name}</a>
                                            <div class="m-t text-right">
                                                <a href="{{ url('/limit-sample/part/') }}/${item.id}" class="btn btn-xs btn-outline btn-primary">Lihat <i class="fa fa-long-arrow-right"></i> </a>
                                                @hasRole('Admin')
                                                    <a href="{{ url('/limit-sample/part/edit/') }}/${item.id}" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                                                @endhasRole
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                        });

                        $('#partCard').append(`
                        <div class=" col-lg-10 col bg-white p-3" id="listDisplay" style="display: none;">
                            <table id="listModel" class="display ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Part</th>
                                        <th>Created_at</th>
                                        <th>Opsi</th>
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
                $('#partCard').empty(); // Clear parts if query is empty
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
