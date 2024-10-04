@extends('layouts.app')

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
        <div class="row justify-content-center">
            <div class="col-lg-5 col-8 rounded  mb-3">
                <div class="autocomplete-container position-relative">
                    <form action="{{ route('model.search') }}" method="GET">
                        <div class="input-group">
                            <input placeholder="Search Models"  autocomplete="off" id="search" type="text" name="searchModel"
                                class="form-control form-control-sm">
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
                <div class="col-lg-6 col-11">
                    <div class="ibox">
                        <div class="ibox-content product-box">


                            <div class="product-imitation">
                                <img src="{{ asset("img/model/$model->foto_model") }}" class="img-fluid" alt="">
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
                                                class="btn btn-xs btn-outline btn-primary mr-1">Edit <i
                                                    class="fa fa-edit"></i>
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

        </div>
        <div class="text-center mb-5">
            {{ $models->links() }}
        </div>
    </section>
@endsection



@section('script')
    <script>
        function replaceSearch(searchValue) {
            let search = document.getElementById('search');
            search.value = searchValue; // Set the input value
            search.focus(); // Set focus back to the input
            $('#autocomplete-results').empty();
            let click = true; // Clear autocomplete results
            performSearch(searchValue,click);
        }

        function performSearch(query,click) {

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
                                <div class="col-lg-6 col-11 mb-4">
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

                            if(click == true){
                                $('#autocomplete-results').empty();
                            }
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
                performSearch(query,click); // Call performSearch on keyup
            });
        });
    </script>
@endsection
