@extends('layouts.app')

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
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (auth()->user()->hasRole('Admin'))
            <div class="row justify-content-center">
                <div class="col-lg-5 col-8 rounded  mb-3">
                    <div class="autocomplete-container position-relative">
                        <form action="{{ route('part.search', ['id' => $model->id]) }}" method="GET">
                            <div class="input-group">
                                <input placeholder="Search Part" id="search"  autocomplete="off" type="text" name="searchPart"
                                    class="form-control form-control-sm">
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                            <ul id="autocomplete-results" class="list-group bg-white" style="list-style: none;"></ul>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2 col-10 text-center  mb-3">
                    <a href="{{ url("limit-sample/model/$model->id/part/create") }}" class="btn btn-secondary ">Tambah Part
                        <i class="fa fa-plus"></i></a>
                </div>
            </div>
        @endif
        <div class="row justify-content-center" id="partCard">
            @foreach ($parts as $part)
                <div class="col-lg-6 col-12 p-2">
                    <div class="ibox">
                        <div class="ibox-content product-box">


                            <div class="product-imitation">
                                <img src="{{ asset("img/part/$part->foto_part") }}" class="img-fluid" alt="">
                            </div>
                            <div class="product-desc p-3">
                                <a href="#" class="product-name"> {{ $part->name }}</a>
                                <div class="m-t text-right">

                                    <a href="{{ url("/limit-sample/part/$part->id") }}"
                                        class="btn btn-xs btn-outline btn-primary">Lihat <i
                                            class="fa fa-long-arrow-right"></i> </a>
                                    @if (auth()->user()->hasRole('Admin'))
                                        <a href="{{ url("/limit-sample/part/edit/$part->id") }}"
                                            class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="text-center">
            {{ $parts->links() }}
            <br>
            <a href="{{ url('/limit-sample/model') }}" class="btn btn-secondary mb-5">Kembali</a>
        </div>
    </section>
@endsection



@section('script')
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
            performSearch(searchValue,click);
        }

        function performSearch(query,click) {
            if (query.length > 0) {
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
                            <div class="col-lg-6 col-12 p-2">
                                <div class="ibox">
                                    <div class="ibox-content product-box">
                                        <div class="product-imitation">
                                            <img src="{{ asset('img/part/') }}/${item.foto_part}" class="img-fluid" alt="">
                                        </div>
                                        <div class="product-desc p-3">
                                            <a href="#" class="product-name">${item.name}</a>
                                            <div class="m-t text-right">
                                                <a href="{{ url('/limit-sample/part/') }}/${item.id}" class="btn btn-xs btn-outline btn-primary">Lihat <i class="fa fa-long-arrow-right"></i> </a>
                                                @if (auth()->user()->hasRole('Admin'))
                                                    <a href="{{ url('/limit-sample/part/edit/') }}/${item.id}" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                        });

                        if(click == true){
                                $('#autocomplete-results').empty();
                            }
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
                performSearch(query,click); // Call performSearch on keyup
            });
        });
    </script>
@endsection

