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
                        <form method="POST" action="{{ url("/limit-sample/area-part/create/$part->id") }}" enctype="multipart/form-data" >
                            @csrf
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Model</label>

                                <div class="col-sm-10"><input type="text" class="form-control" name="model_part_id" value="{{ $part->modelPart->name }}"
                                        disabled></div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Part</label>

                                <div class="col-sm-10"><input type="text" class="form-control" name="part_id" value="{{ $part->name }}"
                                        disabled></div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Nama Area Part</label>

                                <div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
                            </div>
                            <div class="form-group" id="data_1">
                                <label class="font-normal">Effective Date</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="effective_date" class="form-control datepicker" value="03/04/2024">
                                </div>
                            </div>

                            <div class="form-group" id="data_2">
                                <label class="font-normal">Expired Date</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="expired_date" class="form-control datepicker" value="03/04/2024">
                                </div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Characteristik</label>

                                <div class="col-sm-10"><input type="text" name="characteristics" class="form-control"></div>
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
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Upload Foto Dokumentasi</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Foto Ke-Satu</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input id="logo" name="foto_ke_satu" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
                            <label class="col-sm-2 col-form-label">Foto Ke-Dua</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input id="logo" name="foto_ke_dua" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
                            <label class="col-sm-2 col-form-label">Foto Ke-Tiga</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input id="logo" name="foto_ke_tiga" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
                            <label class="col-sm-2 col-form-label">Foto Ke-Empat</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input id="logo" name="foto_ke_empat" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Tandai Area part</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="map-container">
                            <img id="mapImage" src="{{ asset('img/part/D26A.png') }}" alt="Area Map">
                            <div id="buttonsContainer"></div>
                            <input type="hidden" name="koordinat_x" id="btnY" value="">
                            <input type="hidden" name="koordinat_y" id="btnX" value="">
                        </div>
                        {{-- <a class="zoom-btn btn btn-light" id="zoomInBtn">+</a>
                        <a class="zoom-btn btn btn-light" id="zoomOutBtn">-</a> --}}

                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="{{ url("/limit-sample/$part->id/part") }}" class="btn btn-white btn-sm">Batal</a>
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
    let scale = 1; // Skala gambar
    const mapContainer = document.getElementById('mapContainer');
    const mapImage = document.getElementById('mapImage');
    const buttonsContainer = document.getElementById('buttonsContainer'); // Ambil elemen untuk tombol
    let btnY = document.getElementById('btnY');
    let btnX = document.getElementById('btnX');

//     let currentButton = null; // Untuk melacak tombol yang ada

//     function zoomIn() {
//     scale += 0.1; // Tingkatkan skala
//     mapImage.style.transform = `scale(${scale})`;
//     updateButtonPosition('zoomIn'); // Update posisi tombol setelah zoom
// }

// function zoomOut() {
//     scale = Math.max(scale - 0.1, 1); // Pastikan skala tidak kurang dari 1
//     mapImage.style.transform = `scale(${scale})`;
//     updateButtonPosition('zoomOut'); // Update posisi tombol setelah zoom
// }

//     // Fungsi untuk memperbarui posisi tombol sesuai skala zoom
//     function updateButtonPosition(zoomDirection) {
//     if (currentButton) {
//         const rect = mapImage.getBoundingClientRect();

//         // Ambil persentase posisi Y dan X yang sudah disimpan di dataset
//         const percentageY = parseFloat(currentButton.dataset.percentageY);
//         const percentageX = parseFloat(currentButton.dataset.percentageX);

//         // Hitung posisi tombol dalam pixel berdasarkan persentase, tapi sesuaikan dengan skala zoom
//         let topPosPx = (percentageY / 100) * rect.height;
//         let leftPosPx = (percentageX / 100) * rect.width;

//         // Tidak perlu menambah atau mengurangi posisi sesuai dengan zoom
//         currentButton.style.top = `${topPosPx}px`;
//         currentButton.style.left = `${leftPosPx}px`;
//     }
// }

    // Event untuk menangkap klik dan menambahkan tombol
    mapImage.addEventListener('click', function(event) {
        const originalWidth = this.naturalWidth;
        const originalHeight = this.naturalHeight;

        const rect = this.getBoundingClientRect();
        const x = event.clientX - rect.left; // Koordinat X relatif terhadap gambar
        const y = event.clientY - rect.top;  // Koordinat Y relatif terhadap gambar

        // Hitung persentase posisi klik terhadap gambar
        const percentageX = ((x / rect.width) * 100).toFixed(2);
        const percentageY = ((y / rect.height) * 100).toFixed(2);

        // Bersihkan tombol yang sudah ada sebelumnya
        buttonsContainer.innerHTML = '';

        // Tambahkan tombol baru dengan persentase
        const button = document.createElement('a');
        button.className = 'visit-btn';
        button.style.top = `${(y / rect.height) * 95}%`; // Posisi dalam persentase
        button.style.left = `${(x / rect.width) * 95}%`;

        //setting value inputan btnY dan btnX
        btnY.setAttribute('value',`${(y / rect.height) * 100}%`);
        btnX.setAttribute('value',`${(x / rect.width) * 100}%`);

        // Simpan persentase posisi untuk keperluan zoom
        button.dataset.percentageX = percentageX;
        button.dataset.percentageY = percentageY;

        button.innerHTML = '<i class="fa fa-map-marker"></i>';
        buttonsContainer.appendChild(button);

        currentButton = button; // Simpan tombol saat ini untuk tracking
    });

    // Event listeners untuk tombol zoom
    // document.getElementById('zoomInBtn').addEventListener('click', zoomIn);
    // document.getElementById('zoomOutBtn').addEventListener('click', zoomOut);
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
