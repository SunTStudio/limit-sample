@extends('layouts.app')
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
                <strong href="#">Edit Part</strong>
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
                    <h5>Form Edit Part</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ url("/limit-sample/part/edit/$part->id") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Model</label>

                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="{{ $model->name }}" disabled></div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Part</label>

                            <div class="col-sm-10"><input type="text" name="name" class="form-control" value="{{ $part->name }}"></div>
                        </div>
                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Foto Part</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input id="logo" name="foto_part" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="{{ url("/limit-sample/model/$model->id/part") }}" class="btn btn-white btn-sm" >Batal</a>
                                <button class="btn btn-primary btn-sm" type="submit">Edit</button>
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
