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
            <h2>Limit Sample - <strong>Area Path</strong> </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/limit-sample/model') }}">Modal</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ url("/limit-sample/model/$model->id/part") }}">Part</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong href="index.html">Area Path</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
@endsection

@section('content')
    <section class="bg-white m-0 p-0">
        <div class="image-container text-center bg-white tooltip-demo" id="imageContainer">
            <img src="{{ asset("img/part/$part->foto_part") }}" alt="Gambar" class="image">
            @foreach ($partAreas as $partArea)
                <!-- Tombol Visit dengan posisi tetap -->
                <a href="{{ url("/limit-sample/area-part/$partArea->id") }}" class="visit-btn" data-toggle="tooltip"
                    data-placement="top" title="{{ $partArea->nameArea }}"
                    style="top: {{ $partArea->koordinat_y }}; left: {{ $partArea->koordinat_x }};
                                    background-color: black; color: white;
                                ">
                    {{ $loop->iteration }}
                </a>
            @endforeach
        </div>
        <input type="hidden" name="countArea" id="countPartArea" value="">
        <div class="hr-line-dashed"></div>
        <div class="row mb-4 mt-4 p-3">
            <div class="col-lg-12">
                <div class="text-center d-flex justify-content-center">
                    @if (auth()->user()->hasRole('Admin'))
                        <a href="{{ url("/limit-sample/part-area/kelola/$part->id") }}"
                            class="btn btn-secondary mr-2">Kelola Part Area</a>
                    @endif
                    <a href="{{ url("/limit-sample/model/$model->id/part") }}" class="btn btn-dark mr-2">Kembali</a>
                    @if (auth()->user()->hasRole('Admin'))
                        <form action="{{ url("/limit-sample/model/part/delete/$part->id") }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus part ini?');">
                            @csrf
                            @method('DELETE') <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {{-- <script>
        let countArea = 1;
        const imageContainer = document.getElementById('imageContainer');
        const formInputPartArea = document.querySelector('.form-input-part-area');
        let countPartArea = document.getElementById('countPartArea');

        imageContainer.addEventListener('click', function(event) {
            const x = event.clientX - imageContainer.getBoundingClientRect()
                .left; // Koordinat X relatif terhadap gambar
            const y = event.clientY - imageContainer.getBoundingClientRect()
                .top; // Koordinat Y relatif terhadap gambar

            const marker = document.createElement('div');
            marker.className = 'marker';
            marker.style.left = `${(x / imageContainer.offsetWidth) * 100}%`; // Posisi X dalam persentase
            marker.style.top = `${(y / imageContainer.offsetHeight) * 100}%`; // Posisi Y dalam persentase
            marker.innerHTML = `<a class="visit-btn" style="background-color: black; color: white;" data-original-title="kamera">
                                    ` + countArea + `</a>`; // Ganti dengan simbol atau elemen lain sesuai kebutuhan

            imageContainer.appendChild(marker);

            // Tambahkan Inputan untuk klik menggunakan insertAdjacentHTML
            formInputPartArea.insertAdjacentHTML('beforeend', `
        <div class="form-group row" id="partArea` + countArea + `">
            <label class="col-sm-2 col-form-label">Nama Area Part 0` + countArea + `</label>
            <div class="col-sm-8">
                <input type="text" name="nameArea` + countArea + `" class="form-control">
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
            countPartArea.setAttribute('value', countArea )
            countArea++;



        });
    </script> --}}
@endsection
