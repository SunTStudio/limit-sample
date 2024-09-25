@extends('layouts.app')

@section('header')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Limit Sample - <strong>Part D26A</strong> </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/limit-sample/') }}">Model</a>
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
    <div class="row justify-content-center">
        <div class="col-lg-5 col-8 rounded  mb-3">
            <div class="input-group" >
                <input placeholder="Search" type="text" class="form-control form-control-sm">
                <span class="input-group-append">
                    <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-10 text-center  mb-3">
            <a href="{{ url('limit-sample/model/id/part/create') }}" class="btn btn-secondary ">Tambah Part <i class="fa fa-plus"></i></a>
        </div>
    </div>
    <div class="row text-center justify-content-center">
        <div class="col-lg-3 col-6">
            <div class="ibox">
                <div class="ibox-content product-box">


                    <div class="product-imitation">
                        <img src="{{ asset('img/part/D26A.png') }}" class="img-fluid" alt="">
                    </div>
                    <div class="product-desc ">
                        <a href="#" class="product-name"> Reflektor</a>
                        <div class="m-t text-right">

                            <a href="{{ url('/limit-sample/part/id') }}" class="btn btn-xs btn-outline btn-primary">lihat <i class="fa fa-long-arrow-right"></i> </a>
                            <a href="{{ url('/limit-sample/part/edit/id') }}" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="ibox">
                <div class="ibox-content product-box">

                    <div class="product-imitation">
                        <img src="{{ asset('img/part/D26A.png') }}" class="img-fluid" alt="">
                    </div>
                    <div class="product-desc">
                        <a href="#" class="product-name"> Reflektor</a>
                        <div class="m-t text-right">

                            <a href="#" class="btn btn-xs btn-outline btn-primary">lihat <i class="fa fa-long-arrow-right"></i> </a>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="ibox">
                <div class="ibox-content product-box">

                    <div class="product-imitation">
                        <img src="{{ asset('img/part/D26A.png') }}" class="img-fluid" alt="">
                    </div>
                    <div class="product-desc">
                        <a href="#" class="product-name"> Reflektor</a>
                        <div class="m-t text-right">

                            <a href="#" class="btn btn-xs btn-outline btn-primary">lihat <i class="fa fa-long-arrow-right"></i> </a>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="ibox">
                <div class="ibox-content product-box">

                    <div class="product-imitation">
                        <img src="{{ asset('img/part/D26A.png') }}" class="img-fluid" alt="">
                    </div>
                    <div class="product-desc">
                        <a href="#" class="product-name"> Reflektor</a>
                        <div class="m-t text-right">

                            <a href="#" class="btn btn-xs btn-outline btn-primary">lihat <i class="fa fa-long-arrow-right"></i> </a>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ url('/limit-sample') }}" class="btn btn-secondary mb-5">Kemabali</a>
    </div>
</section>
@endsection
