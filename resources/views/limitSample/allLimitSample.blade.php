@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet" />

    <style>
        .product-imitation {
            height: 15rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-imitation img {
            width: 100%;
            height: 15rem;
            object-fit: contain;
        }
    </style>
@endsection
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2> <strong>All Limit Sample</strong></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <strong href="index.html">All Data Limit Sample</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <!-- Optional: You can add buttons or other controls here if needed -->
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center m-1" id="filterAllData">
        <div class="col-lg-2 col-4 text-center p-0" id="btnfilterDropDown">
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" id="headDropdown">All Filter</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" id="filterAll" onclick="allSearch()">All Filter</a></li>
                    <li><a class="dropdown-item" id="filterModel" onclick="modelSearch()">Model</a></li>
                    <li><a class="dropdown-item" id="filterPart" onclick="partSearch()" class="font-bold">Part</a></li>
                    <li><a class="dropdown-item" id="filterAreaPart" onclick="areaPartSearch()">Limit Sample</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-5 col-8 rounded  mb-3" id="searchForm">
            <div class="autocomplete-container position-relative">
                <form action="{{ route('limitSample.Allsearch') }}" method="GET" id="formUrlSearch">
                    <div class="input-group">
                        <input placeholder="Search data" autocomplete="off" id="search" type="text" name="search"
                            class="form-control form-control-sm">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                    <ul id="autocomplete-results" class="list-group bg-white" style="list-style: none;"></ul>
                </form>
            </div>
        </div>
        <div class="col-lg-2 col-4 p-0 text-center">
            <button type="button" onclick="listModel()" class="btn btn-white"><i class="fa fa-list"></i></button>
            <button type="button" onclick="cardModel()" class="btn btn-white"><i class="fa fa-window-restore"></i></button>
        </div>
    </div>
    <div class="row justify-content-center m-3" id="contentAll">
        @foreach ($combinedDatas as $combinedData)
            <div class="col-lg-3 col-11 cardDisplay">
                <div class="ibox">
                    <div class="ibox-content product-box">
                        @if ($combinedData->filter == 'Model')
                            <div class="product-imitation">
                                <a href="{{ url("/limit-sample/model/$combinedData->id/part") }}"><img
                                        src="{{ asset("img/model/$combinedData->foto") }}" class="img-fluid"
                                        alt=""></a>
                            </div>
                            <div class="product-desc">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="product-name"> {{ $combinedData->name }}</a>
                                    <button type="button" class="btn btn-info mb-1">{{ $combinedData->filter }}</button>
                                </div>
                                <div class="m-t text-right d-flex justify-content-between">
                                    <div>

                                        <a href="{{ url("/limit-sample/model/$combinedData->id/part") }}"
                                            class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                class="fa fa-long-arrow-right"></i> </a>
                                        @hasRole('AdminLS')
                                            <a href="{{ url("/limit-sample/model/edit/$combinedData->id") }}"
                                                class="btn btn-xs btn-outline btn-primary mr-1">Edit <i class="fa fa-edit"></i>
                                            </a>
                                        @endhasRole
                                    </div>
                                    @hasRole('AdminLS')
                                        <div class="d-flex">

                                            <form action="{{ url("/limit-sample/model/delete/$combinedData->id") }}"
                                                method="POST"
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
                        @elseif ($combinedData->filter == 'Part')
                            <div class="product-imitation">
                                <a href="{{ url("/limit-sample/part/$combinedData->id") }}"><img
                                        src="{{ asset("img/part/$combinedData->foto") }}" class="img-fluid"
                                        alt=""></a>
                            </div>
                            <div class="product-desc">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="product-name"> {{ $combinedData->name }}</a>
                                    <button type="button"
                                        class="btn btn-primary mb-1">{{ $combinedData->filter }}</button>
                                </div>
                                <div class="m-t text-right d-flex justify-content-between">
                                    <div>

                                        <a href="{{ url("/limit-sample/part/$combinedData->id") }}"
                                            class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                class="fa fa-long-arrow-right"></i> </a>
                                        @hasRole('AdminLS')
                                            <a href="{{ url("/limit-sample/part/edit/$combinedData->id") }}"
                                                class="btn btn-xs btn-outline btn-primary mr-1">Edit <i
                                                    class="fa fa-edit"></i>
                                            </a>
                                        @endhasRole
                                    </div>
                                </div>
                            </div>
                        @elseif ($combinedData->filter == 'Limit Sample')
                            <div class="product-imitation">
                                <a href="{{ url("/limit-sample/model/$combinedData->id/part") }}"><img
                                        src="{{ asset("img/areaPart/$combinedData->foto") }}" class="img-fluid"
                                        alt=""></a>
                            </div>
                            <div class="product-desc">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="product-name"> {{ $combinedData->name }}</a>
                                    <button type="button"
                                        class="btn btn-success mb-1">{{ $combinedData->filter }}</button>
                                </div>
                                <div>
                                    <p style="font-size:0.7rem;">No.Doc : {{ $combinedData->document_number }}</p>
                                </div>
                                <div class="m-t text-right d-flex justify-content-between">
                                    <div>
                                        <a data-toggle="modal" data-target="#{{ $combinedData->id }}"
                                            class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                class="fa fa-long-arrow-right"></i> </a>
                                        @hasRole('AdminLS')
                                            <a href="{{ url("/limit-sample/area-part/edit/$combinedData->id") }}"
                                                class="btn btn-xs btn-outline btn-primary mr-1">Edit <i
                                                    class="fa fa-edit"></i>
                                            </a>
                                        @endhasRole
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        @endforeach
        <div class=" col-lg-10 col bg-white p-3" id="listDisplay" style="display: none;">
            <table id="listModel" class="display ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>No.Dokumen</th>
                        <th>Created_at</th>
                        <th>Filter</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <section id="modalAreaPart">

    </section>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
    <script>
        let listCount = 0;

        function listModel() {
            var dataRoles = "{{ implode(',', session('roles', [])) }}";
            let searchForm = document.getElementById('searchForm').style.display = 'none';
            let btnfilterDropDown = document.getElementById('btnfilterDropDown').style.display = 'none';
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
                    ajax: "{{ route('allLimitSample.allList') }}",
                    columns: [{
                            data: null,
                            className: 'text-center',
                            orderable: false,
                            render: function(data, type, row, meta) {
                                var pageInfo = table.page
                                    .info(); // Use the `table` variable to get the page info
                                return pageInfo.start + meta.row +
                                    1; // Adjusts the row number based on the start index of the current page
                            }
                        },
                        {
                            data: 'name',
                            name: 'name',
                            className: 'text-center'
                        },
                        {
                            data: 'document_number',
                            name: 'document_number',
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
                            data: 'filter',
                            name: 'filter',
                            className: 'text-center',
                        },
                        {
                            data: 'filter',
                            name: 'filter',
                            className: 'text-center',
                            orderable: false,
                            render: function(data, type, row) {
                                return `
                                <div class="d-flex justify-content-center">
                                    ${data == 'Model' ? `
                                                 <a href="{{ url('/limit-sample/model/') }}/${row.id}/part"
                                                 class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                 class="fa fa-long-arrow-right"></i> </a>
                                                `:''}
                                    ${data == 'Part' ? `
                                                 <a href="{{ url('/limit-sample/part/') }}/${row.id}"
                                                                    class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                                        class="fa fa-long-arrow-right"></i> </a>
                                                `:''}
                                    ${data == 'Limit Sample' ? `
                                                 <a data-toggle="modal" data-target="#${row.id}"
                                                                    class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                                        class="fa fa-long-arrow-right"></i> </a>
                                                `:''}

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
            let btnfilterDropDown = document.getElementById('btnfilterDropDown').style.display = 'block';
            let searchForm = document.getElementById('searchForm').style.display = 'block';
            for (let i = 0; i < cardDisplay.length; i++) {
                cardDisplay[i].style.display = 'block';
            }
            let listDisplay = document.getElementById('listDisplay');
            listDisplay.style.display = 'none'
        }
    </script>
    <script>
        let headDropdown = document.getElementById('headDropdown');
        let formUrlSearch = document.getElementById('formUrlSearch');
        let search = document.getElementById('search');
        const dataRoles = @json(session('roles'));
        let csrf_token = '{{ csrf_token() }}';

        function allSearch() {
            formUrlSearch.setAttribute('action', '{{ route('limitSample.Allsearch') }}');
            search.placeholder = "Search All Data";
            headDropdown.innerText = "All Filter";
            $.ajax({
                url: "{{ route('limitSample.Allsearch') }}",
                type: "GET",
                success: function(data) {

                    // Clear existing model cards
                    $('#contentAll').empty();

                    // Append new model cards
                    $.each(data, function(index, combinedData) {
                        $('#contentAll').append(`
                        <div class="col-lg-3 col-11 cardDisplay">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                        <div class="product-imitation">
                                            ${combinedData.filter == 'Model' ? `
                                                            <a href="{{ url('/limit-sample/model/') }}/${combinedData.id}/part"><img
                                                                    src="{{ asset('img/model/') }}/${combinedData.foto}" class="img-fluid"
                                                                    alt=""></a>
                                                            `:''}
                                            ${combinedData.filter == 'Part' ? `
                                                            <a href="{{ url('/limit-sample/part/') }}/${combinedData.id}"><img
                                                            src="{{ asset('img/part/') }}/${combinedData.foto}" class="img-fluid"
                                                            alt=""></a>
                                                            `:''}
                                            ${combinedData.filter == 'Limit Sample' ? `
                                                            <img
                                                            src="{{ asset('img/areaPart/') }}/${combinedData.foto}" class="img-fluid"
                                                            alt="">
                                                            `:''}


                                        </div>
                                        <div class="product-desc">
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="product-name"> ${ combinedData.name }</a>
                                                <button type="button" class="btn btn-info mb-1">${combinedData.filter}</button>
                                            </div>
                                            ${combinedData.filter == 'Model' ? `
                                                        <div class="m-t text-right d-flex justify-content-between">
                                                            <div>


                                                                <a href="{{ url('/limit-sample/model/') }}/${combinedData.id}/part"
                                                                    class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                                        class="fa fa-long-arrow-right"></i> </a>
                                                                ${dataRoles == 'AdminLS' ? `
                                                                <a href="{{ url('/limit-sample/model/edit/') }}/${combinedData.id}"
                                                                    class="btn btn-xs btn-outline btn-primary mr-1">Edit <i class="fa fa-edit"></i>
                                                                </a>` : ''
                                                                    }
                                                            </div>
                                                            ${dataRoles == 'AdminLS' ? `
                                                            <div class="d-flex">

                                                                <form action="{{ url('/limit-sample/model/delete/') }}/${combinedData.id}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus Model ini?');">
                                                                    <input type="hidden" name="_token" value="${csrf_token}">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                                                                    <button type="submit" class="btn btn-xs btn-outline btn-danger">Hapus <i
                                                                            class="fa fa-trash"></i></button>
                                                                </form>
                                                            </div>` : ''
                                                            }
                                                        </div>
                                                        `:''}
                                            ${combinedData.filter == 'Part' ? `
                                                        <div class="m-t text-right d-flex justify-content-between">
                                                            <div>

                                                                <a href="{{ url('/limit-sample/part/') }}/${combinedData.id}"
                                                                    class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                                        class="fa fa-long-arrow-right"></i> </a>
                                                                ${dataRoles == 'AdminLS'?`
                                                        <a href="{{ url('/limit-sample/part/edit/') }}/${combinedData.id}"
                                                            class="btn btn-xs btn-outline btn-primary mr-1">Edit <i
                                                                class="fa fa-edit"></i>
                                                        </a>
                                                    `:''}
                                                            </div>
                                                        </div>
                                                        `:''}
                                            ${combinedData.filter == 'Limit Sample' ? `
                                                        <div>
                                                            <p style="font-size:0.7rem;">No.Doc :  ${combinedData.document_number} </p>
                                                        </div>
                                                        <div class="m-t text-right d-flex justify-content-between">
                                                            <div>
                                                                <a data-toggle="modal" data-target="#${combinedData.id}"
                                                                    class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                                        class="fa fa-long-arrow-right"></i> </a>
                                                                ${dataRoles == "Admin"? `
                                                        <a href="{{ url('/limit-sample/area-part/edit/') }}/${combinedData.id}"
                                                            class="btn btn-xs btn-outline btn-primary mr-1">Edit <i
                                                                class="fa fa-edit"></i>
                                                        </a>
                                                    ` : ''}
                                                            </div>
                                                        </div>
                                                        `:''}

                                        </div>
                                </div>
                            </div>
                        </div>
                        `);
                    });

                    $('#contentAll').append(`
                        <div class=" col-lg-10 col bg-white p-3" id="listDisplay" style="display: none;">
                            <table id="listModel" class="display ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                        <th>No.Dokumen</th>
                                        <th>Created_at</th>
                                        <th>Filter</th>
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
        }

        function modelSearch() {
            formUrlSearch.setAttribute('action', '{{ route('AllLimitSample.modelSearch') }}');
            search.placeholder = "Search All Model";
            headDropdown.innerText = "Model";
            $.ajax({
                url: "{{ route('AllLimitSample.modelSearch') }}",
                type: "GET",
                success: function(data) {
                    $('#contentAll').empty();
                    $.each(data, function(index, combinedData) {
                        $('#contentAll').append(`
                        <div class="col-lg-3 col-11 cardDisplay">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                        <div class="product-imitation">
                                            <a href="{{ url('/limit-sample/model/') }}/${combinedData.id}/part"><img
                                                    src="{{ asset('img/model/') }}/${combinedData.foto}" class="img-fluid"
                                                    alt=""></a>
                                        </div>
                                        <div class="product-desc">
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="product-name"> ${ combinedData.name }</a>
                                                <button type="button" class="btn btn-info mb-1">${combinedData.filter}</button>
                                            </div>
                                            <div class="m-t text-right d-flex justify-content-between">
                                                <div>

                                                    <a href="{{ url('/limit-sample/model/') }}/${combinedData.id}/part"
                                                        class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                            class="fa fa-long-arrow-right"></i> </a>
                                                    ${dataRoles == 'AdminLS' ? `
                                                                            <a href="{{ url('/limit-sample/model/edit/') }}/${combinedData.id}"
                                                                                class="btn btn-xs btn-outline btn-primary mr-1">Edit <i class="fa fa-edit"></i>
                                                                            </a>` : ''
                                                        }
                                                </div>
                                                ${dataRoles == 'AdminLS' ? `
                                                                        <div class="d-flex">

                                                                            <form action="{{ url('/limit-sample/model/delete/') }}/${combinedData.id}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus Model ini?');">
                                                                                <input type="hidden" name="_token" value="${csrf_token}">
                                                                                <input type="hidden" name="_method" value="DELETE">
                                                                                <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                                                                                <button type="submit" class="btn btn-xs btn-outline btn-danger">Hapus <i
                                                                                        class="fa fa-trash"></i></button>
                                                                            </form>
                                                                        </div>` : ''
                                                }
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        `);
                    });

                    $('#contentAll').append(`
                        <div class=" col-lg-10 col bg-white p-3" id="listDisplay" style="display: none;">
                            <table id="listModel" class="display ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                        <th>No.Dokumen</th>
                                        <th>Created_at</th>
                                        <th>Filter</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        `);
                    listCount = 0;

                }
            });
        }

        function partSearch() {
            formUrlSearch.setAttribute('action', '{{ route('AllLimitSample.partSearch') }}');
            search.placeholder = "Search All Part";
            headDropdown.innerText = "Part";
            $.ajax({
                url: "{{ route('AllLimitSample.partSearch') }}",
                type: "GET",
                success: function(data) {
                    $('#contentAll').empty();
                    $.each(data, function(index, combinedData) {
                        $('#contentAll').append(`
                        <div class="col-lg-3 col-11 cardDisplay">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                        <div class="product-imitation">
                                            <a href="{{ url('/limit-sample/part/') }}/${combinedData.id}"><img
                                                src="{{ asset('img/part/') }}/${combinedData.foto}" class="img-fluid"
                                                alt=""></a>
                                        </div>
                                        <div class="product-desc">
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="product-name"> ${ combinedData.name }</a>
                                                <button type="button" class="btn btn-info mb-1">${combinedData.filter}</button>
                                            </div>
                                            <div class="m-t text-right d-flex justify-content-between">
                                                <div>

                                                    <a href="{{ url('/limit-sample/part/') }}/${combinedData.id}"
                                                        class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                            class="fa fa-long-arrow-right"></i> </a>
                                                    ${dataRoles == 'AdminLS'?`
                                                                    <a href="{{ url('/limit-sample/part/edit/') }}/${combinedData.id}"
                                                                        class="btn btn-xs btn-outline btn-primary mr-1">Edit <i
                                                                            class="fa fa-edit"></i>
                                                                    </a>
                                                                `:''}
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        `);
                    });

                    $('#contentAll').append(`
                        <div class=" col-lg-10 col bg-white p-3" id="listDisplay" style="display: none;">
                            <table id="listModel" class="display ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                        <th>No.Dokumen</th>
                                        <th>Created_at</th>
                                        <th>Filter</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        `);
                    listCount = 0;

                }
            });
        }

        function areaPartSearch() {
            formUrlSearch.setAttribute('action', '{{ route('AllLimitSample.areaPartSearch') }}');
            search.placeholder = "Search All Limit Sample";
            headDropdown.innerText = "Limit Sample";
            $.ajax({
                url: "{{ route('AllLimitSample.areaPartSearch') }}",
                type: "GET",
                success: function(data) {
                    $('#contentAll').empty();
                    $.each(data, function(index, combinedData) {
                        $('#contentAll').append(`
                        <div class="col-lg-3 col-11 cardDisplay">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                        <div class="product-imitation">
                                            <img
                                                src="{{ asset('img/areaPart/') }}/${combinedData.foto}" class="img-fluid"
                                                alt="">
                                        </div>
                                        <div class="product-desc">
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="product-name"> ${ combinedData.name }</a>
                                                <button type="button" class="btn btn-info mb-1">${combinedData.filter}</button>
                                            </div>
                                            <div>
                                                    <p style="font-size:0.7rem;">No.Doc :  ${combinedData.document_number} </p>
                                                </div>
                                            <div class="m-t text-right d-flex justify-content-between">
                                                <div>
                                                    <a data-toggle="modal" data-target="#${combinedData.id}"
                                                        class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                            class="fa fa-long-arrow-right"></i> </a>
                                                    ${dataRoles == "Admin"? `
                                                                    <a href="{{ url('/limit-sample/area-part/edit/') }}/${combinedData.id}"
                                                                        class="btn btn-xs btn-outline btn-primary mr-1">Edit <i
                                                                            class="fa fa-edit"></i>
                                                                    </a>
                                                                ` : ''}
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        `);
                    });

                    $('#contentAll').append(`
                        <div class=" col-lg-10 col bg-white p-3" id="listDisplay" style="display: none;">
                            <table id="listModel" class="display ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                        <th>No.Dokumen</th>
                                        <th>Created_at</th>
                                        <th>Filter</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        `);
                    listCount = 0;

                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            //get modal data
            const dataRoles = @json(session('roles'));
            const userAll = @json(session('all_users'));
            // Ambil nilai dari sesi (ini bisa berbeda tergantung bagaimana sesi diakses di aplikasi Anda)
            let userDetailDeptId = @json(session('user')['detail_dept_id']);
            let allDetailDepts = @json(session('all_detail_dept', []));

            // Buat array dengan kolom 'id' dari setiap objek dalam allDetailDepts
            let detailDeptColumn = allDetailDepts.map(dept => dept.id);
            let searchDetailDeptId;


            $.ajax({
                url: "{{ route('limitSample.allLimitSampleModal') }}",
                type: "GET",
                success: function(data) {
                    $.each(data, function(index, item) {
                        // Cari indeks dari userDetailDeptId dalam detailDeptColumn
                        searchDetailDeptId = detailDeptColumn.indexOf(parseInt(item.penolak_id,
                            10));

                        // Pastikan nilai yang ditemukan adalah indeks yang valid
                        let penolakDetailDeptName = searchDetailDeptId !== -1 ? allDetailDepts[
                            searchDetailDeptId].name : null;

                        // untuk mencari data penolak dari session all_user dengan penolak_id
                        let userIndex = userAll.map(user => user.id).indexOf(Number(item
                            .penolak_id));
                        $('#modalAreaPart').append(`
                                <div class="modal inmodal" id="${item.id}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content animated fadeIn">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                        aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title">Arsip Limit Sample</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row d-flex text-center border border-dark m-0 p-0 align-items-center"
                                                    style="background-color: #002060; border-width: 4px;">
                                                    <div class="col-2 p-3 m-0" style="background-color: #ffffff;">
                                                        <img src="{{ asset('img/limitSample/logoLimitSample.png') }}" class="img-fluid" alt="">
                                                    </div>
                                                    <div class="col-8" style="background-color: #002060;">
                                                        <p class="m-0" style="color: yellow;" id="CopHeading"><strong> LIMIT SAMPLE </strong></p>
                                                    </div>
                                                    <div class="col-2" style="background-color: #002060;">
                                                        <p class="m-0 pr-3" style="color: yellow;" id="CopSubHeading">${item.model_part.name}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row text-left bg-white text-dark">
                                                            <div class="col-6 border border-dark p-2"><strong>Part Name</strong>: ${item.name}</div>
                                                            <div class="col-6 border border-dark p-2"><strong>Doc.No</strong>: ${item.document_number}</div>
                                                            <div class="col-6 border border-dark p-2"><strong>Part Number</strong>: ${item.part_number}</div>
                                                            <div class="col-6 border border-dark p-2"><strong>Effective Date</strong>: ${item.effective_date}</div>
                                                            <div class="col-6 border border-dark p-2"><strong>Characteristic</strong>: ${item.characteristics}</div>
                                                            <div class="col-6 border border-dark p-2">
                                                                <strong>Expired Date</strong>:
                                                                <span style="color:${item.expired_date < new Date().toISOString().split('T')[0] ? 'red' : 'inherit'};">
                                                                    ${item.expired_date}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row bg-white">
                                                            <div class="col-6 p-3 border border-dark ">
                                                                <a href="{{ asset('img/areaPart/') }}/${item.foto_ke_satu}"
                                                        data-lightbox="foto${item.id}" data-title="Foto 1">
                                                                <img src="{{ asset('img/areaPart/') }}/${item.foto_ke_satu}" alt="" class="fotoLimitSample">
                                                                </a>
                                                                </div>
                                                            <div class="col-6 p-3 border border-dark ">
                                                                <a href="{{ asset('img/areaPart/') }}/${item.foto_ke_dua}"
                                                        data-lightbox="foto${item.id}" data-title="Foto 2">
                                                                <img src="{{ asset('img/areaPart/') }}/${item.foto_ke_dua}" alt="" class="fotoLimitSample">
                                                                </a>
                                                                </div>
                                                            <div class="col-6 p-3 border border-dark ">
                                                                <a href="{{ asset('img/areaPart/') }}/${item.foto_ke_tiga}"
                                                            data-lightbox="foto${item.id}" data-title="Foto 3">
                                                                <img src="{{ asset('img/areaPart/') }}/${item.foto_ke_tiga}" alt="" class="fotoLimitSample">
                                                                </a>
                                                                </div>
                                                            <div class="col-6 p-3 border border-dark ">
                                                            <a href="{{ asset('img/areaPart/') }}/${item.foto_ke_empat}"
                                                            data-lightbox="foto${item.id}" data-title="Foto 4">
                                                                <img src="{{ asset('img/areaPart/') }}/${item.foto_ke_empat}" alt="" class="fotoLimitSample">
                                                                </a>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-left p-2 border border-dark text-dark" style="background-color: #ffffff;">
                                                        <p> <strong> A.Detail</strong></p>
                                                        <p>${item.deskripsi}</p>
                                                        <div class="detail pl-3">
                                                            <p><span><strong>1. Appearance </strong>:</span>${item.appearance}</p>
                                                            <p><span><strong>2. Dimension </strong>: </span>${item.dimension}</p>
                                                            <p><span><strong>3. Jumlah </strong>: </span>${item.jumlah}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-left p-2 border border-dark text-dark" style="background-color: #ffffff;">
                                                        <p> <strong> B.Metode Pengecekan</strong></p>
                                                        <div class="metodePengecekan pl-3">
                                                            <p>${item.metode_pengecekan}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-dark">
                                                        <div class="row bg-white">
                                                            <div class="col-3 p-1 border border-dark ">
                                                                <p><strong>Approval</strong></p>
                                                                <br>
                                                                ${item.sec_head_approval_date1 ? `
                                                                                                                                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove </strong></p>
                                                                                                                                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Pada ${item.sec_head_approval_date2} </strong></p>
                                                                                                                                ` : ``}

                                                                ${item.status == 'tolak' && penolakDetailDeptName == 'Quality Control' && item.penolak_posisi == 'Supervisor' ? `
                                                                                                                                    <p style="color: red;" class="p-0 m-0"><strong> Ditolak </strong></p>
                                                                                                                                ` : ``}
                                                                <br>
                                                                <p><strong>Section Head 1</strong></p>
                                                            </div>
                                                            <div class="col-3 p-1 border border-dark ">
                                                                <p><strong>Approval</strong></p>
                                                                <br>
                                                                ${item.sec_head_approval_date2 ? `
                                                                                                                                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove </strong></p>
                                                                                                                                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Pada ${item.sec_head_approval_date1} </strong></p>
                                                                                                                                ` : ``}

                                                                ${item.status == 'tolak' && penolakDetailDeptName == 'Quality Assurance' && item.penolak_posisi == 'Supervisor' ? `
                                                                                                                                    <p style="color: red;" class="p-0 m-0"><strong> Ditolak </strong></p>
                                                                                                                                ` : ``}
                                                                <br>
                                                                <p><strong>Section Head 2</strong></p>
                                                            </div>
                                                            <div class="col-6 p-1 border border-dark ">
                                                                <p><strong>Approval</strong></p>
                                                                <br>
                                                                ${item.dept_head_approval_date ? `
                                                                                                                                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove </strong></p>
                                                                                                                                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Pada ${item.dept_head_approval_date} </strong></p>
                                                                                                                                ` : ` `}
                                                                ${item.status == 'tolak' && item.penolak_posisi == 'Department Head' ? `
                                                                                                                                    <p style="color: red;" class="p-0 m-0"><strong> Ditolak </strong></p>
                                                                                                                                ` : ``}
                                                                <br>
                                                                <p><strong>Departemen Head</strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ${item.status == 'tolak'?
                                                    `<div class="col-12 bg-white text-left p-2 border border-dark text-dark">
                                                                                                                    <p> <strong> Informasi Penolakan</strong></p>
                                                                                                                    <p>  Tanggal Penolakan :<strong> ${item.penolakan_date}</strong></p>
                                                                                                                    <p>  Catatan Penolakan :<strong> ${item.penolakan}</strong></p>
                                                                                                                    <br>

                                                                                                                </div>`
                                                    :` `}
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="display: flex; justify-content: center;">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Kembali</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ', status, error);
                }
            });
        });
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
            $('#autocomplete-results').show();
            if (query.length >= 0) {
                $.ajax({
                    url: formUrlSearch.action,
                    type: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#autocomplete-results').empty();
                        $.each(data, function(index, item) {
                            if (item.column == 'characteristics') {
                                $('#autocomplete-results').append(
                                    '<li class="p-2 border" onclick="replaceSearch(\'' +
                                    item.characteristics + '\')">' + item.characteristics + '</li>'
                                );
                            } else {

                                $('#autocomplete-results').append(
                                    '<li class="p-2 border" onclick="replaceSearch(\'' +
                                    item.name + '\')">' + item.name + '</li>'
                                );
                            }
                        });

                        // Clear existing model cards
                        $('#contentAll').empty();

                        // Append new model cards
                        $.each(data, function(index, combinedData) {
                            $('#contentAll').append(`
                        <div class="col-lg-3 col-11 cardDisplay">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                        <div class="product-imitation">
                                            ${combinedData.filter == 'Model' ? `
                                                            <a href="{{ url('/limit-sample/model/') }}/${combinedData.id}/part"><img
                                                                    src="{{ asset('img/model/') }}/${combinedData.foto}" class="img-fluid"
                                                                    alt=""></a>
                                                            `:''}
                                            ${combinedData.filter == 'Part' ? `
                                                            <a href="{{ url('/limit-sample/part/') }}/${combinedData.id}"><img
                                                            src="{{ asset('img/part/') }}/${combinedData.foto}" class="img-fluid"
                                                            alt=""></a>
                                                            `:''}
                                            ${combinedData.filter == 'Limit Sample' ? `
                                                            <img
                                                            src="{{ asset('img/areaPart/') }}/${combinedData.foto}" class="img-fluid"
                                                            alt="">
                                                            `:''}


                                        </div>
                                        <div class="product-desc">
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="product-name"> ${ combinedData.name }</a>
                                                <button type="button" class="btn btn-info mb-1">${combinedData.filter}</button>
                                            </div>
                                            ${combinedData.filter == 'Model' ? `
                                                        <div class="m-t text-right d-flex justify-content-between">
                                                            <div>


                                                                <a href="{{ url('/limit-sample/model/') }}/${combinedData.id}/part"
                                                                    class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                                        class="fa fa-long-arrow-right"></i> </a>
                                                                ${dataRoles == 'AdminLS' ? `
                                                                <a href="{{ url('/limit-sample/model/edit/') }}/${combinedData.id}"
                                                                    class="btn btn-xs btn-outline btn-primary mr-1">Edit <i class="fa fa-edit"></i>
                                                                </a>` : ''
                                                                    }
                                                            </div>
                                                            ${dataRoles == 'AdminLS' ? `
                                                            <div class="d-flex">

                                                                <form action="{{ url('/limit-sample/model/delete/') }}/${combinedData.id}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus Model ini?');">
                                                                    <input type="hidden" name="_token" value="${csrf_token}">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                                                                    <button type="submit" class="btn btn-xs btn-outline btn-danger">Hapus <i
                                                                            class="fa fa-trash"></i></button>
                                                                </form>
                                                            </div>` : ''
                                                            }
                                                        </div>
                                                        `:''}
                                            ${combinedData.filter == 'Part' ? `
                                                        <div class="m-t text-right d-flex justify-content-between">
                                                            <div>

                                                                <a href="{{ url('/limit-sample/part/') }}/${combinedData.id}"
                                                                    class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                                        class="fa fa-long-arrow-right"></i> </a>
                                                                ${dataRoles == 'AdminLS'?`
                                                        <a href="{{ url('/limit-sample/part/edit/') }}/${combinedData.id}"
                                                            class="btn btn-xs btn-outline btn-primary mr-1">Edit <i
                                                                class="fa fa-edit"></i>
                                                        </a>
                                                    `:''}
                                                            </div>
                                                        </div>
                                                        `:''}
                                            ${combinedData.filter == 'Limit Sample' ? `
                                                        <div>
                                                            <p style="font-size:0.7rem;">No.Doc :  ${combinedData.document_number} </p>
                                                        </div>
                                                        <div class="m-t text-right d-flex justify-content-between">
                                                            <div>
                                                                <a data-toggle="modal" data-target="#${combinedData.id}"
                                                                    class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                                        class="fa fa-long-arrow-right"></i> </a>
                                                                ${dataRoles == "Admin"? `
                                                        <a href="{{ url('/limit-sample/area-part/edit/') }}/${combinedData.id}"
                                                            class="btn btn-xs btn-outline btn-primary mr-1">Edit <i
                                                                class="fa fa-edit"></i>
                                                        </a>
                                                    ` : ''}
                                                            </div>
                                                        </div>
                                                        `:''}

                                        </div>
                                </div>
                            </div>
                        </div>
                        `);
                        });
                        $('#contentAll').append(`
                        <div class=" col-lg-10 col bg-white p-3" id="listDisplay" style="display: none;">
                            <table id="listModel" class="display ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                        <th>No.Dokumen</th>
                                        <th>Created_at</th>
                                        <th>Filter</th>
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
            if (!$(event.target).closest('#filterAllData').length) {
                $('#autocomplete-results').hide();
            }
        });
    </script>
@endsection
