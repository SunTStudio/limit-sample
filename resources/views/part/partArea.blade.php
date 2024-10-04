@extends('layouts.app')
@section('css')
    <style>
        .image-container {
            position: relative;
            cursor: pointer;
            /* Mengubah kursor saat mengarahkan mouse */
        }

        .image {
            width: 70%;
            /* Atur lebar gambar sesuai kebutuhan */
            height: auto;
            /* Mempertahankan rasio aspek gambar */
        }

        .marker {
            position: absolute;
            transform: translate(-50%, -50%);
            /* Memusatkan marker pada posisi yang ditentukan */
            font-size: 24px;
            /* Ukuran marker */
            pointer-events: none;
            /* Marker tidak dapat diklik */
        }
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
                    <strong href="index.html">Kelola Area Part</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
@endsection

@section('content')
    <section class="bg-white m-0 p-0">
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
        <form method="POST" action="{{ url("/limit-sample/part-area/kelola/$part->id") }}">
            @csrf
            <div class="image-container text-center bg-white tooltip-demo" id="imageContainer">
                @foreach ($partAreas as $partArea)
                    <!-- Tombol Visit dengan posisi tetap -->
                    <a class="visit-btn" id="visit-btn{{ $loop->iteration }}" data-toggle="tooltip" data-placement="top"
                        title="{{ $partArea->nameArea }}"
                        style="top: {{ $partArea->koordinat_y }}; left: {{ $partArea->koordinat_x }};
                                    background-color: black; color: white;
                                ">
                        {{ $loop->iteration }}
                    </a>
                @endforeach
                <img src="{{ asset("img/part/$part->foto_part") }}" alt="Gambar" class="image">
            </div>
            <div class="oldData pt-5 pr-5 pl-5">
                @if ($partAreasCount >= 1)
                    <h4>Area Tersedia</h4>
                @endif

                @foreach ($partAreas as $partArea)
                    <div class="form-group row" id="partArea{{ $loop->iteration }}">
                        <label class="col-3 col-form-label p-0 pl-3">Nama Area 0{{ $loop->iteration }}</label>
                        <div class="col-7">
                            <input type="text" name="nameArea{{ $loop->iteration }}" class="form-control"
                                value="{{ $partArea->nameArea }}" required>
                        </div>
                        <div class="col-2">
                            <button type="button" id="deletePartArea" class="btn btn-danger"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus Part Area ini?')) { deleteAreaLama({{ $loop->iteration }}); }">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <input type="hidden" name="koordinat_y{{ $loop->iteration }}" id="btnY{{ $loop->iteration }}"
                            value="{{ $partArea->koordinat_y }}">
                        <input type="hidden" name="koordinat_x{{ $loop->iteration }}" id="btnX{{ $loop->iteration }}"
                            value="{{ $partArea->koordinat_x }}">
                    </div>
                    <input type="hidden" id="idDelete{{ $loop->iteration }}" name="id{{ $loop->iteration }}"
                        value="{{ $partArea->id }}">
                @endforeach
                <div id="partAreasCount" hidden>{{ $partAreasCount }}</div>

            </div>
            <div class="form-input-part-area bg-white pb-5 pr-5 pl-5">
                <h4>Area baru</h4>


            </div>
            <input type="hidden" name="countArea" id="countPartArea" value="{{ $partAreasCount }}">
            <div class="hr-line-dashed"></div>
            <div class="form-group row p-3">
                <div class="col-sm-4 col-sm-offset-2">
                    <a href="{{ url("/limit-sample/part/$part->id") }}" class="btn btn-white btn-sm">Batal</a>
                    <button class="btn btn-primary btn-sm" type="submit">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('script')
    <script>
        let partAreasCount = document.getElementById('partAreasCount');
        let countArea = partAreasCount.innerHTML;
        countArea++;
        const imageContainer = document.getElementById('imageContainer');
        let countPartArea = document.getElementById('countPartArea');
        const formInputPartArea = document.querySelector('.form-input-part-area');

        imageContainer.addEventListener('click', function(event) {
            const x = event.clientX - imageContainer.getBoundingClientRect()
                .left; // Koordinat X relatif terhadap gambar
            const y = event.clientY - imageContainer.getBoundingClientRect()
                .top; // Koordinat Y relatif terhadap gambar

            const marker = document.createElement('div');
            marker.className = 'marker';
            marker.id = 'marker' + countArea;
            marker.style.left = `${(x / imageContainer.offsetWidth) * 100}%`; // Posisi X dalam persentase
            marker.style.top = `${(y / imageContainer.offsetHeight) * 100}%`; // Posisi Y dalam persentase
            marker.innerHTML = `<a class="visit-btn" id="visit-btn` + countArea + `" style="background-color: black; color: white;" data-original-title="kamera">
                                    ` + countArea + `</a>`; // Ganti dengan simbol atau elemen lain sesuai kebutuhan

            imageContainer.appendChild(marker);

            // Tambahkan Inputan untuk klik menggunakan insertAdjacentHTML
            formInputPartArea.insertAdjacentHTML('beforeend', `
        <div class="form-group row" id="partArea` + countArea + `">
            <label class="col-sm-2 col-form-label">Nama Area Part 0` + countArea + `</label>
            <div class="col-sm-8">
                <input type="text" name="nameArea` + countArea + `" class="form-control" required>
            </div>
            <div class="col-sm-2">
                <button type="button" id="deletePartArea" class="btn btn-danger" onclick="deleteArea(` +
                countArea + `)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            <input type="hidden" name="koordinat_y` + countArea + `" id="btnY` + countArea + `" value="">
            <input type="hidden" name="koordinat_x` + countArea + `" id="btnX` + countArea + `" value="">
        </div>
    `);

            //setting value inputan btnY dan btnX
            let btnY = document.getElementById('btnY' + countArea);
            let btnX = document.getElementById('btnX' + countArea);

            btnY.setAttribute('value', `${(y / imageContainer.offsetHeight) * 100}%`);
            btnX.setAttribute('value', `${(x / imageContainer.offsetWidth) * 100}%`);
            countPartArea.setAttribute('value', countArea);
            countArea++;



        });

        function deleteArea(id) {
            const deletePartArea = document.getElementById('partArea' + id);
            const deleteVisitBtn = document.getElementById('visit-btn' + id);
            const deleteMarkerBtn = document.getElementById('marker' + id);
            deletePartArea.remove();
            deleteVisitBtn.remove();
            deleteMarkerBtn.remove();
        }

        function deleteAreaLama(id) {
            const deletePartArea = document.getElementById('partArea' + id);
            const deleteVisitBtn = document.getElementById('visit-btn' + id);
            const deleteMarkerBtn = document.getElementById('marker' + id);
            let idDelete = document.getElementById('idDelete' + id);
            idDelete.setAttribute('name', 'idDel' + id)
            deletePartArea.remove();
            deleteVisitBtn.remove();
            deleteMarkerBtn.remove();
        }
    </script>
@endsection
