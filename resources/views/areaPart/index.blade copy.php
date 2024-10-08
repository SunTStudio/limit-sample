@extends('layouts.app')
@section('css')
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
    <section id="areaPart">

        <div class="wrapper animated fadeInRight pt-0">
            <div class="row m-t-lg">
                <div class="col-lg-12 p-0">
                    <div class="ibox-content">
                        <div class="map-container text-center tooltip-demo">
                            <img id="mapImage" src="{{ asset("img/part/$part->foto_part") }}" alt="Area Map">
                            @foreach ($partAreas as $partArea)
                                <!-- Tombol Visit dengan posisi tetap -->
                                <a href="{{ url("/limit-sample/area-part/$partArea->id") }}" class="visit-btn"
                                    data-toggle="tooltip" data-placement="top" title="{{ $partArea->nameArea }}"
                                    style="top: {{ $partArea->koordinat_y }}; left: {{ $partArea->koordinat_x }};
                                    background-color: black; color: white;
                                ">
                                    {{ $loop->iteration }}
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
            <div class="row mb-4 mt-4">
                <div class="col-lg-12">
                    <div class="text-center d-flex justify-content-center">
                        <a href="{{ url("/limit-sample/part-area/kelola/$part->id") }}"
                            class="btn btn-secondary mr-2">Kelola Part Area</a>
                        <a href="{{ url("/limit-sample/model/$model->id/part") }}" class="btn btn-dark mr-2">Kembali</a>
                        <form action="{{ url("/limit-sample/model/part/delete/$part->id") }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus part ini?');">
                            @csrf
                            @method('DELETE') <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section id="modal">

        @foreach ($areaParts as $areaPart)
            <div class="modal inmodal" id="{{ $areaPart->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Limit Sample</h4>
                        <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                    </div>
                        <div class="modal-body">
                            <div class="row d-flex text-center border border-dark  m-0 p-0 align-items-center"
                                style="background-color: #002060; border-width: 4px;">
                                <div class="col-2 p-3 m-0" style="background-color: #ffffff;">
                                    <img src="{{ asset('img/limitSample/logoLimitSample.png') }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="col-8" style="background-color: #002060;">
                                    <p class="m-0" style="color: yellow;" id="CopHeading"><strong> LIMIT SAMPLE </strong>
                                    </p>
                                </div>
                                <div class="col-2" style="background-color: #002060;">
                                    <p class="m-0 pr-3" style="color: yellow;" id="CopSubHeading">
                                        {{ $areaPart->modelPart->name }}</p>
                                </div>
                                <div class="col-12">
                                    <div class="row text-left bg-white text-dark">
                                        <div class="col-6 border border-dark p-2"><strong>Part Name</strong> :
                                            {{ $areaPart->name }}</div>
                                        <div class="col-6 border border-dark p-2"><strong>Effective Date</strong> :
                                            {{ $areaPart->effective_date }}</div>
                                        <div class="col-6 border border-dark p-2"><strong>Charackteristic</strong> :
                                            {{ $areaPart->characteristics }}</div>
                                        <div class="col-6 border border-dark p-2"><strong>Expired Date</strong> :
                                            {{ $areaPart->expired_date }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row bg-white">
                                        <div class="col-6 p-3 border border-dark "><img
                                                src="{{ asset("img/areaPart/$areaPart->foto_ke_satu") }}" alt=""
                                                class="fotoLimitSample"></div>
                                        <div class="col-6 p-3 border border-dark "><img
                                                src="{{ asset("img/areaPart/$areaPart->foto_ke_dua") }}" alt=""
                                                class="fotoLimitSample"></div>
                                        <div class="col-6 p-3 border border-dark "><img
                                                src="{{ asset("img/areaPart/$areaPart->foto_ke_tiga") }}" alt=""
                                                class="fotoLimitSample"></div>
                                        <div class="col-6 p-3 border border-dark "><img
                                                src="{{ asset("img/areaPart/$areaPart->foto_ke_empat") }}" alt=""
                                                class="fotoLimitSample"></div>
                                    </div>
                                </div>
                                <div class="col-12 text-left p-2 border border-dark text-dark"
                                    style="background-color: #ffffff;">
                                    <p> <strong> A.Detail</strong></p>
                                    <p>{{ $areaPart->deskripsi }}</p>
                                    <div class="detail pl-3">
                                        <p><span><strong>1. Appearance </strong>: </span>{{ $areaPart->appearance }}</p>
                                        <p><span><strong>2. Dimension </strong>: </span>{{ $areaPart->dimension }}</p>
                                        <p><span><strong>3. Jumlah </strong>: </span>{{ $areaPart->jumlah }}</p>
                                    </div>
                                </div>
                                <div class="col-12 text-left p-2 border border-dark text-dark"
                                    style="background-color: #ffffff;">
                                    <p> <strong> B.Metode Pengecekan</strong></p>
                                    <div class="metodePengecekan pl-3">
                                        <p>{{ $areaPart->metode_pengecekan }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12 text-dark">
                                    <div class="row bg-white">
                                        <div class="col-6 p-1 border border-dark ">
                                            <p><strong>Approval</strong></p>
                                            <p><strong>Section Head</strong></p>
                                            <br><br>
                                            <p><strong>(Nama SecHead)</strong></p>
                                        </div>
                                        <div class="col-6 p-1 border border-dark ">
                                            <p><strong>Approval</strong></p>
                                            <p><strong>Departemen Head</strong></p>
                                            <br><br>
                                            <p><strong>(Nama DeptHead)</strong></p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="display: flex; justify-content: center;">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Kembali</button>
                            <a href="{{ url("/limit-sample/area-part/edit/$areaPart->id") }}"
                                class="btn btn-secondary">Edit</a>
                            <a href="{{ url('') }}" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </section> --}}
@endsection











@section('script')
    {{-- <script>
    // Menangkap event klik pada gambar
    document.getElementById('mapImage').addEventListener('click', function(event) {
        // Mendapatkan ukuran asli gambar
        const originalWidth = this.naturalWidth;
        const originalHeight = this.naturalHeight;

        // Mendapatkan ukuran yang ditampilkan
        const displayedWidth = this.clientWidth;
        const displayedHeight = this.clientHeight;

        // Mendapatkan posisi klik
        const rect = this.getBoundingClientRect();
        const x = event.clientX - rect.left; // Koordinat X relatif terhadap gambar
        const y = event.clientY - rect.top;  // Koordinat Y relatif terhadap gambar

        // Menghitung rasio
        const ratioX = originalWidth / displayedWidth;
        const ratioY = originalHeight / displayedHeight;

        // Menghitung koordinat asli
        const originalX = Math.round(x * ratioX);
        const originalY = Math.round(y * ratioY);

        // Menghitung persentase
        const percentageX = ((originalX / originalWidth) * 100).toFixed(2); // Persentase X
        const percentageY = ((originalY / originalHeight) * 100).toFixed(2); // Persentase Y

        // Menampilkan koordinat dan persentase
        alert(`Koordinat Asli: \nTop: ${originalY}px \nLeft: ${originalX}px\n\nPersentase: \nTop: ${percentageY}% \nLeft: ${percentageX}%`);
    });
</script> --}}
@endsection
