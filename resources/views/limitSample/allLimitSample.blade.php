@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">

    <style>
        .product-imitation{
            height: 15rem;
            display: flex;
            align-items: center;
        }
        .product-imitation img {
            width: 100%;
            height: auto;
        }
    </style>
@endsection
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2> <strong>All Limit Sample</strong></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <strong href="index.html">All Data Limit Sample</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <!-- Optional: You can add buttons or other controls here if needed -->
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center m-3">
        @foreach ($combinedDatas as $combinedData)
            <div class="col-lg-3 col-11 cardDisplay">
                <div class="ibox">
                    <div class="ibox-content product-box">
                        @if ($combinedData->filter == 'Model')
                            <div class="product-imitation">
                                <a href="{{ url("/limit-sample/model/$combinedData->id/part") }}"><img
                                        src="{{ asset("img/model/$combinedData->foto") }}" class="img-fluid"
                                        alt=""></a>
                            </div>
                            <div class="product-desc">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="product-name"> {{ $combinedData->name }}</a>
                                    <button type="button" class="btn btn-info mb-1">{{ $combinedData->filter }}</button>
                                </div>
                                <div class="m-t text-right d-flex justify-content-between">
                                    <div>

                                        <a href="{{ url("/limit-sample/model/$combinedData->id/part") }}"
                                            class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                class="fa fa-long-arrow-right"></i> </a>
                                        @hasRole('Admin')
                                            <a href="{{ url("/limit-sample/model/edit/$combinedData->id") }}"
                                                class="btn btn-xs btn-outline btn-primary mr-1">Edit <i class="fa fa-edit"></i>
                                            </a>
                                        @endhasRole
                                    </div>
                                    @hasRole('Admin')
                                        <div class="d-flex">

                                            <form action="{{ url("/limit-sample/model/delete/$combinedData->id") }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus Model ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                                                <button type="submit" class="btn btn-xs btn-outline btn-danger">Hapus <i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    @endhasRole
                                </div>
                            </div>
                        @elseif ($combinedData->filter == 'Part')
                            <div class="product-imitation">
                                <a href="{{ url("/limit-sample/part/$combinedData->id") }}"><img
                                        src="{{ asset("img/part/$combinedData->foto") }}" class="img-fluid"
                                        alt=""></a>
                            </div>
                            <div class="product-desc">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="product-name"> {{ $combinedData->name }}</a>
                                    <button type="button" class="btn btn-primary mb-1">{{ $combinedData->filter }}</button>
                                </div>
                                <div class="m-t text-right d-flex justify-content-between">
                                    <div>

                                        <a href="{{ url("/limit-sample/part/$combinedData->id") }}"
                                            class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                class="fa fa-long-arrow-right"></i> </a>
                                        @hasRole('Admin')
                                            <a href="{{ url("/limit-sample/part/edit/$combinedData->id") }}"
                                                class="btn btn-xs btn-outline btn-primary mr-1">Edit <i class="fa fa-edit"></i>
                                            </a>
                                        @endhasRole
                                    </div>
                                </div>
                            </div>
                        @elseif ($combinedData->filter == 'Limit Sample')
                            <div class="product-imitation">
                                <a href="{{ url("/limit-sample/model/$combinedData->id/part") }}"><img
                                        src="{{ asset("img/areaPart/$combinedData->foto") }}" class="img-fluid"
                                        alt=""></a>
                            </div>
                            <div class="product-desc">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="product-name"> {{ $combinedData->name }}</a>
                                    <button type="button" class="btn btn-success mb-1">{{ $combinedData->filter }}</button>
                                </div>
                                <div class="m-t text-right d-flex justify-content-between">
                                    <div>
                                        <a data-toggle="modal" data-target="#{{ $combinedData->id }}"
                                            class="btn btn-xs btn-outline btn-primary">Lihat <i
                                                class="fa fa-long-arrow-right"></i> </a>
                                        @hasRole('Admin')
                                            <a href="{{ url("/limit-sample/area-part/edit/$combinedData->id") }}"
                                                class="btn btn-xs btn-outline btn-primary mr-1">Edit <i class="fa fa-edit"></i>
                                            </a>
                                        @endhasRole
                                    </div>
                                    @hasRole('Admin')
                                        <div class="d-flex">

                                            <form action="{{ url("/limit-sample/model/delete/$combinedData->id") }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus Model ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                                                <button type="submit" class="btn btn-xs btn-outline btn-danger">Hapus <i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    @endhasRole
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <section id="modalAreaPart">

    </section>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            //get modal data
            const dataRoles = @json(session('roles'));
            const userAll = @json(session('all_users'));
            $.ajax({
                url: "{{ route('limitSample.allLimitSampleModal') }}",
                type: "GET",
                success: function(data) {
                    $.each(data, function(index, item) {
                        // untuk mencari data penolak dari session all_user dengan penolak_id
                        let userIndex = userAll.map(user => user.id).indexOf(Number(item
                            .penolak_id));
                        $('#modalAreaPart').append(`
                                <div class="modal inmodal" id="${item.id}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content animated fadeIn">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                        aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title">Arsip Limit Sample</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row d-flex text-center border border-dark m-0 p-0 align-items-center"
                                                    style="background-color: #002060; border-width: 4px;">
                                                    <div class="col-2 p-3 m-0" style="background-color: #ffffff;">
                                                        <img src="{{ asset('img/limitSample/logoLimitSample.png') }}" class="img-fluid" alt="">
                                                    </div>
                                                    <div class="col-8" style="background-color: #002060;">
                                                        <p class="m-0" style="color: yellow;" id="CopHeading"><strong> LIMIT SAMPLE </strong></p>
                                                    </div>
                                                    <div class="col-2" style="background-color: #002060;">
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row text-left bg-white text-dark">
                                                            <div class="col-6 border border-dark p-2"><strong>Part Name</strong>: ${item.name}</div>
                                                            <div class="col-6 border border-dark p-2"><strong>Doc.No</strong>: ${item.document_number}</div>
                                                            <div class="col-6 border border-dark p-2"><strong>Part Number</strong>: ${item.part_number}</div>
                                                            <div class="col-6 border border-dark p-2"><strong>Effective Date</strong>: ${item.effective_date}</div>
                                                            <div class="col-6 border border-dark p-2"><strong>Characteristic</strong>: ${item.characteristics}</div>
                                                            <div class="col-6 border border-dark p-2">
                                                                <strong>Expired Date</strong>:
                                                                <span style="color:${item.expired_date < new Date().toISOString().split('T')[0] ? 'red' : 'inherit'};">
                                                                    ${item.expired_date}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row bg-white">
                                                            <div class="col-6 p-3 border border-dark "><img src="{{ asset('img/areaPart/') }}/${item.foto_ke_satu}" alt="" class="fotoLimitSample"></div>
                                                            <div class="col-6 p-3 border border-dark "><img src="{{ asset('img/areaPart/') }}/${item.foto_ke_dua}" alt="" class="fotoLimitSample"></div>
                                                            <div class="col-6 p-3 border border-dark "><img src="{{ asset('img/areaPart/') }}/${item.foto_ke_tiga}" alt="" class="fotoLimitSample"></div>
                                                            <div class="col-6 p-3 border border-dark "><img src="{{ asset('img/areaPart/') }}/${item.foto_ke_empat}" alt="" class="fotoLimitSample"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-left p-2 border border-dark text-dark" style="background-color: #ffffff;">
                                                        <p> <strong> A.Detail</strong></p>
                                                        <p>${item.deskripsi}</p>
                                                        <div class="detail pl-3">
                                                            <p><span><strong>1. Appearance </strong>:</span>${item.appearance}</p>
                                                            <p><span><strong>2. Dimension </strong>: </span>${item.dimension}</p>
                                                            <p><span><strong>3. Jumlah </strong>: </span>${item.jumlah}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-left p-2 border border-dark text-dark" style="background-color: #ffffff;">
                                                        <p> <strong> B.Metode Pengecekan</strong></p>
                                                        <div class="metodePengecekan pl-3">
                                                            <p>${item.metode_pengecekan}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-dark">
                                                        <div class="row bg-white">
                                                            <div class="col-3 p-1 border border-dark ">
                                                                <p><strong>Approval</strong></p>
                                                                <br>
                                                                ${item.sec_head_approval_date2 ? `
                                                                                                            <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove </strong></p>
                                                                                                            <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Pada ${item.sec_head_approval_date2} </strong></p>
                                                                                                        ` : ` `}

                                                                ${item.status == 'tolak' && item.penolak_id == 16 && item.penolak_posisi == 'Supervisor' ? `
                                                                                                            <p style="color: red;" class="p-0 m-0"><strong> Ditolak </strong></p>
                                                                                                        ` : `<br><br>`}
                                                                <br>
                                                                <p><strong>Section Head 1</strong></p>
                                                            </div>
                                                            <div class="col-3 p-1 border border-dark ">
                                                                <p><strong>Approval</strong></p>
                                                                <br>
                                                                ${item.sec_head_approval_date1 ? `
                                                                                                            <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove </strong></p>
                                                                                                            <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Pada ${item.sec_head_approval_date1} </strong></p>
                                                                                                        ` : ` `}

                                                                ${item.status == 'tolak' && item.penolak_id == 15 && item.penolak_posisi == 'Supervisor' ? `
                                                                                                            <p style="color: red;" class="p-0 m-0"><strong> Ditolak </strong></p>
                                                                                                        ` : `<br><br>`}
                                                                <br>
                                                                <p><strong>Section Head 2</strong></p>
                                                            </div>
                                                            <div class="col-6 p-1 border border-dark ">
                                                                <p><strong>Approval</strong></p>
                                                                <br>
                                                                ${item.dept_head_approval_date ? `
                                                                                                            <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove </strong></p>
                                                                                                            <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Pada ${item.dept_head_approval_date} </strong></p>
                                                                                                        ` : ` `}
                                                                ${item.status == 'tolak' && item.penolak_posisi == 'Department Head' ? `
                                                                                                            <p style="color: red;" class="p-0 m-0"><strong> Ditolak </strong></p>
                                                                                                        ` : `<br><br>`}
                                                                <br>
                                                                <p><strong>Departemen Head</strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ${item.status == 'tolak'?
                                                    `<div class="col-12 bg-white text-left p-2 border border-dark text-dark">
                                                                                            <p> <strong> Informasi Penolakan</strong></p>
                                                                                            <p>  Tanggal Penolakan :<strong> ${item.penolakan_date}</strong></p>
                                                                                            <p>  Catatan Penolakan :<strong> ${item.penolakan}</strong></p>
                                                                                            <br>

                                                                                        </div>`
                                                    :` `}
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="display: flex; justify-content: center;">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Kembali</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ', status, error);
                }
            });
        });
    </script>
@endsection
