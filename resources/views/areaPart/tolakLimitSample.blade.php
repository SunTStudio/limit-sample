@extends('layouts.app')
@section('css')
@endsection
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Part</strong> </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/limit-sample/') }}">Modal</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ url("/limit-sample/model/$model->id/part") }}">Part</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ url("/limit-sample/part/$part->id") }}">Area Part</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ url("/limit-sample/area-part/$partArea->id") }}">Katalog Part</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong href="index.html">Tolak Limit Sample</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Form Penolakan Limit Sample</h5>
                    </div>
                    <div class="ibox-content">
                        @if (Auth::user()->hasRole('Section Head'))
                        <form method="POST" action="{{ url("/limit-sample/area-part/tolak/sechead/$areaPart->id") }}" enctype="multipart/form-data">
                            @elseif (Auth::user()->hasRole('Departement Head'))
                            <form method="POST" action="{{ url("/limit-sample/area-part/tolak/depthead/$areaPart->id") }}" enctype="multipart/form-data">
                        @endif
                            @csrf
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Catatan Penolakan</label>

                                <div class="col-sm-10"><input type="text" name="penolakan" class="form-control"></div>
                                <input type="hidden" name="user_id" class="form-control" value="{{ Auth::user()->id }}">
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="{{ url("/limit-sample/area-part/$partArea->id") }}" class="btn btn-white btn-sm">Batal</a>
                                    <button class="btn btn-primary btn-sm" type="submit">Penolakan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
@endsection