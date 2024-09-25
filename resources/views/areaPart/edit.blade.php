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
                <a href="{{ url('/limit-sample/model/id/part') }}">Part</a>
            </li>
            <li class="breadcrumb-item active">
                <strong href="index.html">Tambah Part</strong>
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
                    <h5>Form Tambah Area Part Baru</h5>
                </div>
                <div class="ibox-content">
                    <form method="get" action="{{ url('/limit-sample/id/part') }}">
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Model</label>

                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama Model" disabled></div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Part</label>

                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama Part" disabled></div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Area Part</label>

                            <div class="col-sm-10"><input type="text" class="form-control"></div>
                        </div>
                        <div class="form-group" id="data_1">
                            <label class="font-normal">Effective Date</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                            </div>
                        </div>
                        <div class="form-group" id="data_2">
                            <label class="font-normal">Expired Date</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                            </div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Characteristik</label>

                            <div class="col-sm-10"><input type="text" class="form-control"></div>
                        </div>
                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Foto Part</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input id="logo" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>A. Detail</h5>
                </div>
                <div class="ibox-content">
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Deskripsi</label>

                            <div class="col-sm-10"><textarea type="text-area" class="form-control"></textarea></div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">1. Apperance</label>

                            <div class="col-sm-10"><input type="text" class="form-control"></div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">2. Dimension</label>

                            <div class="col-sm-10"><input type="text" class="form-control"></div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">3. Jumlah</label>

                            <div class="col-sm-10"><input type="text" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label"><h5><strong> B. Metode Pengecekan </strong></h5></label>

                            <div class="col-sm-10"><textarea type="text-area" class="form-control"></textarea></div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Upload Foto Dokumentasi</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Foto Ke-Satu</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input id="logo" type="file" class="custom-file-input">
                                <label for="logo" class="custom-file-label">Choose file...</label>
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label">Foto Ke-Dua</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input id="logo" type="file" class="custom-file-input">
                                <label for="logo" class="custom-file-label">Choose file...</label>
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label">Foto Ke-Tiga</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input id="logo" type="file" class="custom-file-input">
                                <label for="logo" class="custom-file-label">Choose file...</label>
                            </div>
                        </div>
                        <label class="col-sm-2 col-form-label">Foto Ke-Empat</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input id="logo" type="file" class="custom-file-input">
                                <label for="logo" class="custom-file-label">Choose file...</label>
                            </div>
                        </div>
                    </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="{{ url('/limit-sample/id/part') }}" class="btn btn-white btn-sm" >Batal</a>
                                <button class="btn btn-primary btn-sm" type="submit">Tambah</button>
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
<script>
    $(document).ready(function() {
        // Initialize date picker for data_1
        $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $('#data_2 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "dd/mm/yyyy" // format sesuai dengan input yang diinginkan
            });
    });
</script>

@endsection