@extends('layouts.app')
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Part</strong> </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/limit-sample/model') }}">Modal</a>
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
            <div class="col-lg-12 p-0">
                <form method="POST" action="{{ url("/limit-sample/part-area/kelola/$part->id") }}">
                    @csrf
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Tandai Area part</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="map-container text-center">
                                <img id="mapImage" src="{{ asset("img/part/$part->foto_part") }}" alt="Area Map">
                                <div id="buttonsContainer"></div>

                            </div>
                            <div class="form-input-part-area">

                            </div>
                            <input type="hidden" name="countArea" id="countPartArea" value="">
                            {{-- <a class="zoom-btn btn btn-light" id="zoomInBtn">+</a>
                        <a class="zoom-btn btn btn-light" id="zoomOutBtn">-</a> --}}

                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="{{ url("/limit-sample/part/$part->id") }}"
                                        class="btn btn-white btn-sm">Batal</a>
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
        let countArea = 1;
        const mapContainer = document.querySelector('.map-container');
        const mapImage = document.getElementById('mapImage');
        const buttonsContainer = document.getElementById('buttonsContainer'); // Ambil elemen untuk tombol
        let countPartArea = document.getElementById('countPartArea');

        const formInputPartArea = document.querySelector('.form-input-part-area');
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
            const y = event.clientY - rect.top; // Koordinat Y relatif terhadap gambar

            // Hitung persentase posisi klik terhadap gambar
            const percentageX = ((x / rect.width) * 95).toFixed(2);
            if (window.innerWidth <= 768) {
                const percentageX = ((x / rect.width) * 95).toFixed(2);
            }
            const percentageY = ((y / rect.height) * 95).toFixed(2);

            // Tambahkan Inputan untuk klik menggunakan insertAdjacentHTML
            formInputPartArea.insertAdjacentHTML('beforeend', `
        <div class="form-group row d-flex align-items-center" id="partArea` + countArea + `">
            <label class="col-4 col-form-label">Nama Area Part 0` + countArea + `</label>
            <div class="col-6">
                <input type="text" name="nameArea` + countArea + `" class="form-control">
            </div>
            <div class="col-2">
                <button type="button" id="deletePartArea" class="btn btn-danger" onclick="deleteArea(` +
                countArea + `)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            <input type="hidden" name="koordinat_y` + countArea + `" id="btnY` + countArea + `" value="">
            <input type="hidden" name="koordinat_x` + countArea + `" id="btnX` + countArea + `" value="">
        </div>
    `);





            // Tambahkan tombol baru dengan persentase
            const button = document.createElement('a');
            button.className = 'visit-btn';
            button.id = 'visit-btn' + countArea;
            button.style.top = `${(y / rect.height) * 95}%`; // Posisi dalam persentase
            button.style.left = `${(x / rect.width) * 95}%`;
            if (window.innerWidth <= 768) {
                button.style.left = `${(x / rect.width) * 95}%`;
            }
            button.style.color = `#FFFFFF`;

            //setting value inputan btnY dan btnX
            let btnY = document.getElementById('btnY'+ countArea);
            let btnX = document.getElementById('btnX'+ countArea);

            btnY.setAttribute('value', `${(y / rect.height) * 95}%`);
            btnX.setAttribute('value', `${(x / rect.width) * 95}%`);
            if (window.innerWidth <= 768) {
                btnX.setAttribute('value', `${(x / rect.width) * 95}%`);
            }


            // Simpan persentase posisi untuk keperluan zoom
            button.dataset.percentageX = percentageX;
            button.dataset.percentageY = percentageY;

            button.innerHTML = countArea;
            buttonsContainer.appendChild(button);

            currentButton = button; // Simpan tombol saat ini untuk tracking

            countPartArea.setAttribute('value', countArea )

            countArea++;
        });

        function deleteArea(id) {
            const deletePartArea = document.getElementById('partArea' + id);
            const deleteVisitBtn = document.getElementById('visit-btn' + id);
            deletePartArea.remove();
            deleteVisitBtn.remove();
        }

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
