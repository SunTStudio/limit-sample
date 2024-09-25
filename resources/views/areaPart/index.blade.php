@extends('layouts.app')
@section('css')
@endsection
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Area Path</strong> </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/limit-sample/') }}">Modal</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ url('/limit-sample/model/id/part') }}">Part</a>
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
        <div class="row justify-content-center">
            <div class="col-lg-5 col-8 rounded  mb-3">
                <div class="input-group">
                    <input placeholder="Search" type="text" class="form-control form-control-sm">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="col-lg-2 col-10 text-center  mb-3">
                <a href="{{ url('/limit-sample/model/create') }}" class="btn btn-secondary ">Tambah Area Part <i
                        class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight pt-0">
            <div class="row m-t-lg">
                <div class="col-lg-12 p-0">
                    <div class="ibox-content">
                        <div class="map-container">
                            <img id="mapImage" src="{{ asset('img/part/D26A.png') }}" alt="Area Map">

                            <!-- Tombol Visit dengan posisi tetap -->
                            <button class="visit-btn" style="top: 8%; left: 12%;" data-toggle="modal"
                                data-target="#myModal4">1</button>
                            <button class="visit-btn" style="top: 30%; left: 38%;" data-toggle="modal"
                                data-target="#myModal4">2</button>
                            <button class="visit-btn" style="top: 13.29%; left: 92.74%;" data-toggle="modal"
                                data-target="#myModal4">3</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="legend-container">
                        <p><strong>Keterangan</strong></p>
                        <div class="legend-item">
                            <div class="circle yellow"></div>
                            <span>Area Part Belum Ditampilkan Butuh Approval Sec Head</span>
                        </div>
                        <div class="legend-item">
                            <div class="circle gray"></div>
                            <span>Area Part Belum Ditampilkan Butuh Approval Dept Head</span>
                        </div>
                        <div class="legend-item">
                            <div class="circle black"></div>
                            <span>Part Dapat Ditampilkan</span>
                        </div>
                    </div>
                    <a href="{{ url('/limit-sample/model/id/part') }}" class="btn btn-secondary">Kemabali</a>
                </div>
            </div>
        </div>
    </section>


    <section id="modal">
        <!-- Modal -->
        <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-clock-o modal-icon"></i>
                        <h4 class="modal-title">Modal title</h4>
                        <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                    </div>
                    <div class="modal-body">
                        <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                            remaining essentially unchanged.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Kembali</button>
                        <a href="{{ url('/') }}" class="btn btn-secondary">Export PDF</a>
                        <a href="{{ url('/limit-sample/area-part/edit/id') }}" class="btn btn-secondary">Edit</a>
                        <a href="{{ url('') }}" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
