@extends('layouts.app')
@section('css')
    <style>

    </style>
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
                        <form method="POST" action="{{ url("/limit-sample/area-part/create/$partArea->id") }}"
                            enctype="multipart/form-data">
                            @csrf
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Model</label>

                                <div class="col-sm-10"><input type="text" class="form-control" name="model_part_id"
                                        value="{{ $part->modelPart->name }}" disabled></div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Jenis Part</label>

                                <div class="col-sm-10"><input type="text" class="form-control" name="part_id"
                                        value="{{ $part->name }}" disabled></div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Part</label>

                                <div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
                            </div>
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Part Number</label>

                                <div class="col-sm-4"><input type="text" name="part_number" class="form-control"></div>
                                <label class="col-sm-2 col-form-label">Document Number</label>

                                <div class="col-sm-4">
                                    <input type="text" name="document_number" class="form-control"
                                        value="AJI/LS/{{ $model->name }}/{{ $part->name }}/{{ $partArea->nameArea }}/0{{ $lastAreaPartId }}"
                                        disabled>
                                    <input type="hidden" name="document_number" class="form-control"
                                        value="AJI/LS/{{ $model->name }}/{{ $part->name }}/{{ $partArea->nameArea }}/0{{ $lastAreaPartId }}">
                                </div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Characteristik</label>

                                <div class="col-sm-10"><input type="text" name="characteristics" class="form-control">
                                </div>
                            </div>
                            <div class="form-group  row">

                                <div id="data_1" class="col-sm-6 ">
                                    <label class="font-normal">Effective Date</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" name="effective_date" class="form-control datepicker"
                                            value="03/04/2024">
                                    </div>
                                </div>

                                <div id="data_2" class="col-sm-6 ">
                                    <label class="font-normal">Expired Date</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" name="expired_date" class="form-control datepicker"
                                            value="03/04/2024">
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

                            <div class="col-sm-10">
                                <textarea type="text-area" name="deskripsi" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">1. Apperance</label>

                            <div class="col-sm-10"><input name="appearance" type="text" class="form-control"></div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">2. Dimension</label>

                            <div class="col-sm-10"><input type="text" name="dimension" class="form-control"></div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">3. Jumlah</label>

                            <div class="col-sm-10"><input type="text" name="jumlah" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">
                                <h5><strong> B. Metode Pengecekan </strong></h5>
                            </label>

                            <div class="col-sm-10">
                                <textarea type="text-area" name="metode_pengecekan" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Upload Foto Dokumentasi</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group row" id="uploadFotoLS">
                            <label class="col-sm-2 col-form-label">Foto Ke-Satu</label>
                            <div class="col-sm-10 mb-2">
                                <input type="hidden" name="rotateFotoSatu" id="rotateFoto1">
                                <div class="custom-file">
                                    <input name="foto_ke_satu" id="imageInput1" type="file"
                                        class="custom-file-input">
                                    <label for="imageInput1" class="custom-file-label">Choose file...</label>
                                </div>
                                <button type="button" class="btn btn-secondary" id="rotate1" style="display: none;">
                                    <i class="fa fa-rotate-right"></i>
                                </button>
                                <div class="image-container">
                                    <img id="preview1" src="" alt="Image Preview">
                                </div>
                            </div>

                            <label class="col-sm-2 col-form-label">Foto Ke-Dua</label>
                            <div class="col-sm-10 mb-2">
                                <input type="hidden" name="rotateFotoDua" id="rotateFoto2">
                                <div class="custom-file">
                                    <input name="foto_ke_dua" id="imageInput2" type="file" class="custom-file-input">
                                    <label for="imageInput2" class="custom-file-label">Choose file...</label>
                                </div>
                                <button type="button" class="btn btn-secondary" id="rotate2" style="display: none;">
                                    <i class="fa fa-rotate-right"></i>
                                </button>
                                <div class="image-container">
                                    <img id="preview2" src="" alt="Image Preview">
                                </div>
                            </div>

                            <label class="col-sm-2 col-form-label">Foto Ke-Tiga</label>
                            <div class="col-sm-10 mb-2">
                                <input type="hidden" name="rotateFotoTiga" id="rotateFoto3">
                                <div class="custom-file">
                                    <input name="foto_ke_tiga" id="imageInput3" type="file"
                                        class="custom-file-input">
                                    <label for="imageInput3" class="custom-file-label">Choose file...</label>
                                </div>
                                <button type="button" class="btn btn-secondary" id="rotate3" style="display: none;">
                                    <i class="fa fa-rotate-right"></i>
                                </button>
                                <div class="image-container">
                                    <img id="preview3" src="" alt="Image Preview">
                                </div>
                            </div>

                            <label class="col-sm-2 col-form-label">Foto Ke-Empat</label>
                            <div class="col-sm-10 mb-2">
                                <input type="hidden" name="rotateFotoEmpat" id="rotateFoto4">
                                <div class="custom-file">
                                    <input name="foto_ke_empat" id="imageInput4" type="file"
                                        class="custom-file-input">
                                    <label for="imageInput4" class="custom-file-label">Choose file...</label>
                                </div>
                                 <button type="button" class="btn btn-secondary" id="rotate4" style="display: none;">
                                    <i class="fa fa-rotate-right"></i>
                                </button>
                                <div class="image-container">
                                    <img id="preview4" src="" alt="Image Preview">
                                </div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="{{ url("/limit-sample/part/$part->id") }}"
                                    class="btn btn-white btn-sm">Batal</a>
                                <button class="btn btn-primary btn-sm" type="submit">Tambah</button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>


    </div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const imageInputs = document.querySelectorAll('input[type="file"]');
        const rotateButtons = document.querySelectorAll('button[id^="rotate"]');
        const previews = document.querySelectorAll('img[id^="preview"]');
        const rotations = [0, 0, 0, 0]; // Menyimpan sudut rotasi untuk setiap gambar
        const rotateFoto = document.querySelectorAll('input[id^="rotateFoto"]')

        imageInputs.forEach((input, index) => {
            input.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previews[index].src = e.target.result;
                        previews[index].style.display = 'block';
                        rotateButtons[index].style.display = 'inline-block';
                        rotations[index] = 0; // Reset rotasi saat gambar baru dimuat
                        previews[index].style.transform =
                            `rotate(${rotations[index]}deg)`; // Reset rotasi
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        rotateButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                rotations[index] += 90; // Tambah rotasi 90 derajat
                previews[index].style.transform =
                    `rotate(${rotations[index]}deg)`; // Update rotasi
                rotateFoto[index].setAttribute('value',rotations[index]);
            });
        });
    });
</script>












    <script>
        $(document).ready(function() {
            // Initialize date picker for data_1
            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                format: 'mm/dd/yyyy',
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
            }).datepicker("setDate", new Date());

            $('#data_2 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: 'mm/dd/yyyy', // format sesuai dengan input yang diinginkan
            }).datepicker("setDate", new Date());
        });
    </script>
@endsection
