@extends('layouts.app')

@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Part</strong> </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/limit-sample/model') }}">Model</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ url("/limit-sample/model/$model->id/part") }}">Part</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ url("/limit-sample/part/$part->id") }}">Area Part</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Detail Area Part</strong>
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
            @if (auth()->user()->hasRole('Admin'))
                <div class="col-lg-8 col-10 text-center  mb-3">
                    <form action="{{ route('excel.import', ['id' => $partArea->id]) }}" class="bg-white p-2 rounded "
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="" class="h5">Import Data File Area Part</label>
                        </div>
                        <div class="fileinput fileinput-new border border-secondary rounded" data-provides="fileinput">
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select file Excel</span>
                                <span class="fileinput-exists">Change</span><input type="file"
                                    name="excel_file" /></span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput"
                                style="float: none">×</a>
                        </div>
                        <div class="fileinput fileinput-new border border-secondary rounded" data-provides="fileinput">
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select Zip Image File</span>
                                <span class="fileinput-exists">Change</span><input type="file" name="zip_file" /></span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput"
                                style="float: none">×</a>
                        </div>
                        {{-- <div class="form-group custom-file">
                    <label for="file"  class="custom-file-label">Pilih File Excel</label>
                    <input type="file" class="form-control" name="file" id="file" class="custom-file-input" required>
                </div> --}}
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            @endif
            <div class="col-lg-5 col-8 rounded  mb-3">
                <form action="{{ route('katalog.search', ['id' => $partArea->id]) }}" method="GET">
                    <div class="input-group">
                        <input placeholder="Search" type="text" name="searchKatalog"
                            class="form-control form-control-sm">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            @if (auth()->user()->hasRole('Admin'))
                <div class="col-lg-2 col-10 text-center  mb-3">
                    <a href="{{ url("/limit-sample/area-part/create/$partArea->id") }}" class="btn btn-secondary ">Tambah
                        Detail
                        Area Part <i class="fa fa-plus"></i></a>
                </div>
            @endif
        </div>

        <div class="row justify-content-center">
            @foreach ($AreaParts as $areaPart)
                <div class="col-lg-3 col-11">
                    <div class="ibox">
                        <div class="ibox-content product-box">


                            <div class="product-imitation">
                                <img src="{{ asset("img/areaPart/$areaPart->foto_ke_satu") }}" class="img-fluid img-katalog"
                                    alt="">
                            </div>
                            <div class="product-desc">
                                <a href="#" class="product-name"> {{ $areaPart->name }}</a>
                                <div class="m-t text-right d-flex justify-content-between">

                                    <a data-toggle="modal" data-target="#{{ $areaPart->id }}"
                                        class="btn btn-xs btn-outline btn-primary">See Detail <i
                                            class="fa fa-long-arrow-right"></i> </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <section id="modal">

                @foreach ($AreaParts as $areaPart)
                    <div class="modal inmodal" id="{{ $areaPart->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content animated fadeIn">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Limit Sample</h4>
                                    {{-- <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> --}}
                                </div>
                                <div class="modal-body">
                                    <div class="row d-flex text-center border border-dark  m-0 p-0 align-items-center"
                                        style="background-color: #002060; border-width: 4px;">
                                        <div class="col-2 p-3 m-0" style="background-color: #ffffff;">
                                            <img src="{{ asset('img/limitSample/logoLimitSample.png') }}" class="img-fluid"
                                                alt="">
                                        </div>
                                        <div class="col-8" style="background-color: #002060;">
                                            <p class="m-0" style="color: yellow;" id="CopHeading"><strong> LIMIT
                                                    SAMPLE
                                                </strong>
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
                                                <div class="col-6 border border-dark p-2"><strong>Doc.No</strong> :
                                                    {{ $areaPart->document_number }}</div>
                                                <div class="col-6 border border-dark p-2"><strong>Part Number</strong> :
                                                    {{ $areaPart->part_number }}</div>
                                                <div class="col-6 border border-dark p-2"><strong>Effective Date</strong> :
                                                    {{ $areaPart->effective_date }}</div>
                                                <div class="col-6 border border-dark p-2"><strong>Charackteristic</strong>
                                                    :
                                                    {{ $areaPart->characteristics }}</div>
                                                <div class="col-6 border border-dark p-2"><strong>Expired Date</strong> :
                                                    {{ $areaPart->expired_date }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row bg-white">
                                                <div class="col-6 p-3 border border-dark "><img
                                                        src="{{ asset("img/areaPart/$areaPart->foto_ke_satu") }}"
                                                        alt="" class="fotoLimitSample"></div>
                                                <div class="col-6 p-3 border border-dark "><img
                                                        src="{{ asset("img/areaPart/$areaPart->foto_ke_dua") }}"
                                                        alt="" class="fotoLimitSample"></div>
                                                <div class="col-6 p-3 border border-dark "><img
                                                        src="{{ asset("img/areaPart/$areaPart->foto_ke_tiga") }}"
                                                        alt="" class="fotoLimitSample"></div>
                                                <div class="col-6 p-3 border border-dark "><img
                                                        src="{{ asset("img/areaPart/$areaPart->foto_ke_empat") }}"
                                                        alt="" class="fotoLimitSample"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-left p-2 border border-dark text-dark"
                                            style="background-color: #ffffff;">
                                            <p> <strong> A.Detail</strong></p>
                                            <p>{{ $areaPart->deskripsi }}</p>
                                            <div class="detail pl-3">
                                                <p><span><strong>1. Appearance </strong>:
                                                    </span>{{ $areaPart->appearance }}</p>
                                                <p><span><strong>2. Dimension </strong>: </span>{{ $areaPart->dimension }}
                                                </p>
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
                                                    <br>
                                                    @if ($areaPart->sec_head_approval_date != null)
                                                        <p style="color: red;"><strong> Sudah diApprove </strong></p>
                                                    @else
                                                        <br>
                                                        <br>
                                                    @endif
                                                    <br>
                                                    <p><strong>Section Head</strong></p>
                                                    {{-- <p><strong>(Nama SecHead)</strong></p> --}}
                                                </div>
                                                <div class="col-6 p-1 border border-dark ">
                                                    <p><strong>Approval</strong></p>
                                                    <br>
                                                    @if ($areaPart->dept_head_approval_date != null)
                                                        <p style="color: red;"><strong> Sudah diApprove </strong></p>
                                                    @else
                                                        <br>
                                                        <br>
                                                    @endif
                                                    <br>
                                                    <p><strong>Departemen Head</strong></p>
                                                    {{-- <p><strong>(Nama DeptHead)</strong></p> --}}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="display: flex; justify-content: center;">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Kembali</button>
                                    @if (auth()->user()->hasRole('Section Head') && $areaPart->sec_head_approval_date == null)
                                        <a href="{{ url("/limit-sample/area-part/tolak/sechead/$areaPart->id") }}"
                                            class="btn btn-danger">Tolak</a>
                                        <a href="{{ url("/limit-sample/area-part/approve/sechead/$areaPart->id") }}"
                                            class="btn btn-secondary">Approve</a>
                                    @endif
                                    @if (auth()->user()->hasRole('Departement Head') && $areaPart->sec_head_approval_date != null)
                                        <a href="{{ url("/limit-sample/area-part/tolak/depthead/$areaPart->id") }}"
                                            class="btn btn-danger">Tolak</a>
                                        <a href="{{ url("/limit-sample/area-part/approve/depthead/$areaPart->id") }}"
                                            class="btn btn-secondary">Approve</a>
                                    @endif
                                    @if (auth()->user()->hasRole('Admin'))
                                        <a href="{{ url("/limit-sample/area-part/edit/$areaPart->id") }}"
                                            class="btn btn-secondary">Edit</a>
                                        <form action="{{ url("/limit-sample/areaPart/delete/$areaPart->id") }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus Area Part ini?');">
                                            @csrf
                                            @method('DELETE') <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </section>

        </div>
        <div class="text-center mb-5">
            {{ $AreaParts->links() }}
        </div>
        <div class="text-center m-3">
            <a href="{{ url("/limit-sample/part/$part->id") }}" class="btn btn-dark mr-2">Kembali</a>
        </div>
    </section>
@endsection
