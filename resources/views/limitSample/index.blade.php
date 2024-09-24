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
        <div class="col-lg-10 col-10">
            <div class="input-group m-4"><input placeholder="Search" type="text" class="form-control form-control-sm">
                <span class="input-group-append">
                    <button type="button" class="btn btn-sm btn-primary">Go!
                    </button>
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-11">
            <div class="ibox">
                <div class="ibox-content product-box">


                    <div class="product-imitation">
                        <img src="{{ asset("img/model/backD26A.jpg") }}" class="img-fluid" alt="">
                    </div>
                    <div class="product-desc">
                        <a href="#" class="product-name"> D26A</a>
                        <div class="m-t text-right">

                            <a href="{{ url('/limit-sample/part/1') }}" class="btn btn-xs btn-outline btn-primary">See Detail <i class="fa fa-long-arrow-right"></i> </a>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-11">
            <div class="ibox">
                <div class="ibox-content product-box">

                    <div class="product-imitation">
                        <img src="{{ asset('img/model/backD30D.jpg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="product-desc">
                        <a href="#" class="product-name"> D30D</a>
                        <div class="m-t text-right">

                            <a href="#" class="btn btn-xs btn-outline btn-primary">See Detail <i class="fa fa-long-arrow-right"></i> </a>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-11">
            <div class="ibox">
                <div class="ibox-content product-box">

                    <div class="product-imitation">
                        <img src="{{ asset('img/model/backD40D.jpg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="product-desc">
                        <a href="#" class="product-name"> D40D</a>
                        <div class="m-t text-right">

                            <a href="#" class="btn btn-xs btn-outline btn-primary">See Detail <i class="fa fa-long-arrow-right"></i> </a>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-11">
            <div class="ibox">
                <div class="ibox-content product-box">

                    <div class="product-imitation">
                        <img src="{{ asset('img/model/back800A.jpg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="product-desc">
                        <a href="#" class="product-name"> D26A</a>
                        <div class="m-t text-right">

                            <a href="#" class="btn btn-xs btn-outline btn-primary">See Detail <i class="fa fa-long-arrow-right"></i> </a>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Edit <i class="fa fa-edit"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


@endsection
