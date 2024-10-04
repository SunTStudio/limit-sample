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
            @hasRole('Admin')
                <div class="col-lg-12 col-10 text-center  mb-3">
                    <form action="{{ route('excel.import', ['id' => $partArea->id]) }}" class="bg-white p-2 rounded "
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="" class="h5">Import Data File Area Part</label>
                        </div>
                        <a href="{{ route('file.download', ['filename' => 'template-import.xlsx']) }}"
                            class="btn btn-primary">Download Template</a>
                        <div class="fileinput fileinput-new border border-secondary rounded" data-provides="fileinput">
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select file Excel</span>
                                <span class="fileinput-exists">Change</span><input type="file" name="excel_file" /></span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                        </div>
                        <div class="fileinput fileinput-new border border-secondary rounded" data-provides="fileinput">
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select Zip Image File</span>
                                <span class="fileinput-exists">Change</span><input type="file" name="zip_file" /></span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                        </div>
                        {{-- <div class="form-group custom-file">
                    <label for="file"  class="custom-file-label">Pilih File Excel</label>
                    <input type="file" class="form-control" name="file" id="file" class="custom-file-input" required>
                </div> --}}
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            @endhasRole
            <div class="col-lg-1 col-2 rounded  mr-5">
                <div class="form-group row">

                    <div class="col-sm-12 p-0">
                        <div class="dropdown">
                            <button class="btn btn-white dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Karakteristik
                            </button>
                            <ul class="dropdown-menu" id="charDropdown" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-item p-2" data-value="Karakteristik">Karakteristik
                                </li>
                                @foreach ($characteristics as $characteristic)
                                    <li class="dropdown-item p-2" data-value="{{ $characteristic->name }}">
                                        {{ $characteristic->name }}
                                    </li>
                                @endforeach
                                <li class="dropdown-item p-2">
                                    <div class="input-group">
                                        <input placeholder="Add Characteristic" id="newCharacteristic" autocomplete="off" type="text" name="new_characteristic" class="form-control form-control-sm">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-sm btn-primary" onclick="addCharacteristic()">+</button>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-8 rounded  mb-3">
                <div class="autocomplete-container position-relative">
                    <form action="{{ route('katalog.search', ['id' => $partArea->id]) }}" method="GET">
                        <div class="input-group">
                            <input placeholder="Search Part" id="search" autocomplete="off" type="text"
                                name="searchKatalog" class="form-control form-control-sm">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <ul id="autocomplete-results" class="list-group bg-white" style="list-style: none;"></ul>
                    </form>
                </div>
            </div>
            @hasRole('Admin')
                <div class="col-lg-2 col-10 text-center  mb-3">
                    <a href="{{ url("/limit-sample/area-part/create/$partArea->id") }}" class="btn btn-secondary ">Tambah
                        Detail
                        Area Part <i class="fa fa-plus"></i></a>
                </div>
            @endhasRole
        </div>

        <div class="row justify-content-center" id="AreaPartCard">
            @foreach ($AreaParts as $areaPart)
                <div class="col-lg-3 col-11">
                    <div class="ibox">
                        <div class="ibox-content product-box">


                            <div class="product-imitation">
                                <img src="{{ asset("img/areaPart/$areaPart->foto_ke_satu") }}"
                                    class="img-fluid img-katalog" alt="">
                            </div>
                            <div class="product-desc ">
                                <a href="#" class="product-name"> {{ $areaPart->name }}</a>
                                <div class="row mt-3 align-items-center">
                                    <div class="col-3">
                                        <a data-toggle="modal" data-target="#{{ $areaPart->id }}"
                                            class="btn btn-xs btn-outline mb-1 btn-primary">Lihat <i
                                                class="fa fa-long-arrow-right"></i> </a>
                                    </div>
                                    <div class="col-8 text-right " id="toolsCard">
                                        @if ($areaPart->expired_date < now()->toDateString())
                                            <button type="button" class="btn btn-danger mb-1 "> Expired <i
                                                    class="fa fa-warning"></i></button>
                                        @endif
                                        @if (in_array('Supervisor', session('roles', [])) && $areaPart->sec_head_approval_date == null)
                                            <button type="button" class="btn btn-primary mb-1">Need Approve</button>
                                        @endif
                                        @if (in_array('Department Head', session('roles', [])) &&
                                                $areaPart->sec_head_approval_date != null &&
                                                $areaPart->dept_head_approval_date == null)
                                            <button type="button" class="btn btn-primary mb-1">Need Approve</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <section id="AreaPartCardModal">

                @foreach ($AreaParts as $areaPart)
                    <div class="modal inmodal" id="{{ $areaPart->id }}" tabindex="-1" role="dialog"
                        aria-hidden="true">
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
                                            <img src="{{ asset('img/limitSample/logoLimitSample.png') }}"
                                                class="img-fluid" alt="">
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
                                                <div class="col-6 border border-dark p-2">
                                                    @if ($areaPart->expired_date < now()->toDateString())
                                                        <strong style="color:red;">Expired Date :
                                                            {{ $areaPart->expired_date }}</strong>
                                                    @else
                                                        <strong>Expired Date</strong> :
                                                        {{ $areaPart->expired_date }}
                                                    @endif
                                                </div>
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
                                                    @php
                                                        //mengambil semua data dari session
                                                        $allUsers = session('all_users', []);
                                                        $penolakId = $areaPart->penolak_id;

                                                        // Menginisialisasi nama penolak dengan nilai default
                                                        $penolakName = 'Unknown';

                                                        // Mencari indeks pengguna berdasarkan penolak_id
                                                        $userIndex = array_search(
                                                            $penolakId,
                                                            array_column($allUsers, 'id'),
                                                        );

                                                        // Pastikan penolakId tidak kosong dan userIndex ditemukan
                                                        if (!empty($penolakId) && $userIndex !== false) {
                                                            $penolakName = $allUsers[$userIndex]['name']; // Mengambil nama dari all_users berdasarkan penolak_id
                                                        }
                                                    @endphp
                                                    <p><strong>Approval</strong></p>
                                                    <br>
                                                    @if ($areaPart->sec_head_approval_date != null)
                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah
                                                                diApprove
                                                            </strong></p>
                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>
                                                                Pada {{ $areaPart->sec_head_approval_date }} </strong></p>
                                                    @elseif ($areaPart->status == 'tolak' && $areaPart->penolak_posisi == 'Supervisor')
                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>
                                                                DiTolak
                                                            </strong></p>
                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>
                                                                Oleh {{ $penolakName }} </strong></p>
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
                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah
                                                                diApprove
                                                            </strong></p>
                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>
                                                                Pada {{ $areaPart->dept_head_approval_date }} </strong></p>
                                                    @elseif ($areaPart->status == 'tolak' && $areaPart->penolak_posisi == 'Department Head')
                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>
                                                                DiTolak
                                                            </strong></p>
                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>
                                                                Oleh {{ $penolakName }} </strong></p>
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
                                        @if ($areaPart->status == 'tolak')
                                            <div class="col-12 bg-white text-left p-2 border border-dark text-dark">
                                                <p> <strong> Informasi Penolakan</strong></p>
                                                <p> Tanggal Penolakan :<strong> {{ $areaPart->penolakan_date }}</strong>
                                                </p>
                                                <p> Catatan Penolakan :<strong> {{ $areaPart->penolakan }}</strong></p>
                                                <br>

                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="modal-footer" style="display: flex; justify-content: center;">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Kembali</button>
                                    @if (in_array('Supervisor', session('roles', [])) && $areaPart->sec_head_approval_date == null)
                                        <a href="{{ url("/limit-sample/area-part/tolak/sechead/$areaPart->id") }}"
                                            class="btn btn-danger">Tolak</a>
                                        <a href="{{ url("/limit-sample/area-part/approve/sechead/$areaPart->id") }}"
                                            class="btn btn-secondary">Approve</a>
                                    @endif
                                    @if (in_array('Department Head', session('roles', [])) && $areaPart->sec_head_approval_date != null)
                                        <a href="{{ url("/limit-sample/area-part/tolak/depthead/$areaPart->id") }}"
                                            class="btn btn-danger">Tolak</a>
                                        <a href="{{ url("/limit-sample/area-part/approve/depthead/$areaPart->id") }}"
                                            class="btn btn-secondary">Approve</a>
                                    @endif
                                    @hasRole('Admin')
                                        <a href="{{ url("/limit-sample/area-part/edit/$areaPart->id") }}"
                                            class="btn btn-secondary">Edit</a>
                                        <form action="{{ url("/limit-sample/areaPart/delete/$areaPart->id") }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus Area Part ini?');">
                                            @csrf
                                            @method('DELETE') <!-- Ini menandakan bahwa request ini adalah DELETE method -->
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    @endhasRole
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



@section('script')
    <script>
        function addCharacteristic() {
            let newCharacteristic = document.getElementById('newCharacteristic');
            var partArea = {{ $partArea->id }};
            let charDropdown = document.getElementById('charDropdown');

            $.ajax({
                        url: "{{ route('katalog.addCharacteristic', ['id' => $partArea->id]) }}",
                        type: "GET",
                        data: {
                            id: partArea,
                            newChar: newCharacteristic.value // Use a colon (:) and send the value
                        },
                        success: function(data) {
                                // Clear existing charDropdown
                                $('#charDropdown').empty();

                                // Append new charDropdown
                                $.each(data, function(index, char) {

                                    $('#charDropdown').append(`
                                        <li class="dropdown-item p-2" data-value="${char.name}">
                                            ${char.name}
                                        </li>
                                    `);
                                });

                                // Adding the input group for adding a new characteristic
                                $('#charDropdown').append(`
                                    <li class="dropdown-item p-2">
                                        <div class="input-group">
                                            <input placeholder="Add Characteristic" id="newCharacteristic" autocomplete="off" type="text" name="new_characteristic" class="form-control form-control-sm">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-sm btn-primary" onclick="addCharacteristic()">+</button>
                                            </span>
                                        </div>
                                    </li>
                                `);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error); // Log any error for debugging
                    }
                });
            }
    </script>
    <script>
        const userRoles = @json(session('roles'));

        function authUserHasRole(role) {
            return userRoles.includes(role);
        }
    </script>
    <script>
        // Pass the model ID from the backend to JavaScript
        var partArea = {{ $partArea->id }};
        const dataRoles = @json(session('roles'));
        const userAll = @json(session('all_users'));

        function replaceSearch(searchValue) {
            let search = document.getElementById('search');
            search.value = searchValue; // Set the input value
            search.focus(); // Set focus back to the input
            $('#autocomplete-results').empty(); // Clear autocomplete results
            let click = true;
            // Manually trigger the search AJAX call
            performSearch(searchValue, click);
        }

        function performSearch(query, click) {
            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('katalog.search', ['id' => $partArea->id]) }}",
                    type: "GET",
                    data: {
                        query: query,
                        id: partArea // Send model ID in the request data if needed
                    },
                    success: function(data) {
                        $('#autocomplete-results').empty();
                        $.each(data, function(index, item) {
                            $('#autocomplete-results').append(
                                '<li class="p-2 border" onclick="replaceSearch(\'' +
                                item.name + '\')">' + item.name + '</li>'
                            );
                        });

                        // Clear existing AreaPartCard
                        $('#AreaPartCard').empty();

                        // Append new AreaPartCard
                        $.each(data, function(index, areaPart) {
                            $('#AreaPartCard').append(`
                                <div class="col-lg-3 col-11">
                                    <div class="ibox">
                                        <div class="ibox-content product-box">
                                            <div class="product-imitation">
                                                <img src="{{ asset('img/areaPart/') }}/${areaPart.foto_ke_satu}" class="img-fluid img-katalog" alt="">
                                            </div>
                                            <div class="product-desc">
                                                <a href="#" class="product-name">${areaPart.name}</a>
                                                <div class="row mt-3 align-items-center">
                                                    <div class="col-3">
                                                        <a data-toggle="modal" data-target="#${areaPart.id}" class="btn btn-xs btn-outline mb-1 btn-primary">Lihat <i class="fa fa-long-arrow-right"></i></a>
                                                    </div>
                                                    <div class="col-8 text-right" id="toolsCard">
                                                        ${new Date(areaPart.expired_date) < new Date() ?
                                                            '<button type="button" class="btn btn-danger mb-1">Expired <i class="fa fa-warning"></i></button>' :
                                                            ''}
                                                        ${dataRoles == 'Supervisor' && areaPart.sec_head_approval_date == null ?
                                                            '<button type="button" class="btn btn-primary mb-1">Need Approve</button>' :
                                                            ''}
                                                        ${dataRoles == 'Department Head' && areaPart.sec_head_approval_date != null && areaPart.dept_head_approval_date == null ?
                                                            '<button type="button" class="btn btn-primary mb-1">Need Approve</button>' :
                                                            ''}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });



                        $.each(data, function(index, item) {
                            // untuk mencari data penolak dari session all_user dengan penolak_id
                            let userIndex = userAll.map(user => user.id).indexOf(Number(item
                                .penolak_id));
                            $('#AreaPartCard').append(`
                                <div class="modal inmodal" id="${item.id}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content animated fadeIn">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                        aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title">Limit Sample</h4>
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
                                                        <p class="m-0 pr-3" style="color: yellow;" id="CopSubHeading">${item.model_part.name}</p>
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
                                                            <div class="col-6 p-1 border border-dark ">
                                                                <p><strong>Approval</strong></p>
                                                                <br>
                                                                ${item.sec_head_approval_date ? `
                                                                                            <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove </strong></p>
                                                                                            <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Pada ${item.sec_head_approval_date} </strong></p>
                                                                                        ` : ` `}

                                                                ${item.status == 'tolak' && item.penolak_posisi == 'Supervisor' ? `
                                                                                            <p style="color: red;" class="p-0 m-0"><strong> Ditolak </strong></p>
                                                                                            <p style="color: red;" class="p-0 m-0"><strong> Oleh ${userAll[userIndex].name} </strong></p>
                                                                                        ` : `<br><br>`}
                                                                <br>
                                                                <p><strong>Section Head</strong></p>
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
                                                                                            <p style="color: red;" class="p-0 m-0"><strong> Oleh ${userAll[userIndex].name} </strong></p>
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
                                                ${item.sectionHeadApproval ? `
                                                                            <a href="/limit-sample/area-part/tolak/sechead/${item.id}" class="btn btn-danger">Tolak</a>
                                                                            <a href="/limit-sample/area-part/approve/sechead/${item.id}" class="btn btn-secondary">Approve</a>
                                                                        ` : ''}
                                                ${item.departmentHeadApproval ? `
                                                                            <a href="/limit-sample/area-part/tolak/depthead/${item.id}" class="btn btn-danger">Tolak</a>
                                                                            <a href="/limit-sample/area-part/approve/depthead/${item.id}" class="btn btn-secondary">Approve</a>
                                                                        ` : ''}
                                                ${item.isAdmin ? `
                                                                            <a href="/limit-sample/area-part/edit/${item.id}" class="btn btn-secondary">Edit</a>
                                                                            <form action="/limit-sample/areaPart/delete/${item.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Area Part ini?');">
                                                                                <input type="hidden" name="_token" value="${item.csrf_token}">
                                                                                <input type="hidden" name="_method" value="DELETE">
                                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                                            </form>
                                                                        ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });



                        if (click == true) {
                            $('#autocomplete-results').empty();
                        }
                    }
                });
            } else {
                $('#autocomplete-results').empty();
                $('#partCard').empty(); // Clear parts if query is empty
            }
        }

        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let click = false;
                var query = $(this).val();
                performSearch(query, click); // Call performSearch on keyup
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle clicks on dropdown items
            $('#charDropdown').on('click', '.dropdown-item', function(event) {
                event.stopPropagation(); // Prevent click from propagating to the dropdown toggle

                // Get the selected value from the clicked item
                const selectedValue = $(this).data('value');

                // Change the button text to the selected characteristic
                $('#dropdownMenuButton').text(selectedValue);
            });

            // Optional: Keep the dropdown open when clicking the toggle button
            $('#dropdownMenuButton').on('click', function(event) {
                event.stopPropagation(); // Prevent click from propagating
                $('#charDropdown').toggle(); // Manually toggle the dropdown
            });

            // Close the dropdown when clicking outside of it
            $(document).click(function(event) {
                if (!$(event.target).closest('.dropdown').length) {
                    $('#charDropdown').hide(); // Hide dropdown if click is outside
                }
            });
        });
        </script>
@endsection
