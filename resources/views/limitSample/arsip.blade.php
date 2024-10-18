@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">
@endsection
@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Limit Sample - <strong>Arsip</strong></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <strong href="index.html">Limit Sample Arsip</strong>
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
        <div class="col bg-white p-3">
            <table id="arsip" class="display ">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Action</th> <!-- Optional: Soft delete date -->
                        <th class="text-center">Name</th>
                        <th class="text-center">Part Number</th>
                        <th class="text-center">Document Number</th>
                        <th class="text-center">Characteristics</th>
                        <th class="text-center">Effective Date</th>
                        <th class="text-center">Expired Date</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Dimension</th>
                        <th class="text-center">Appearance</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Checking Method</th>
                        <th class="text-center">Rejector ID</th>
                        <th class="text-center">Rejector Position</th>
                        <th class="text-center">Rejection Reason</th>
                        <th class="text-center">Rejection Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Section Head 1 Approval Date</th>
                        <th class="text-center">Section Head 2 Approval Date</th>
                        <th class="text-center">Department Head Approval Date</th>
                        <th class="text-center">Submit Date</th>
                        <th class="text-center">Count Visit</th>
                        <th class="text-center">Deleted At</th> <!-- Optional: Soft delete date -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <section id="modalAreaPart">

    </section>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

    <script>
        //datatables deleted limit sample data
        $(document).ready(function() {
            $('#arsip').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('limitSample.arsip') }}", // Ensure this route points to your DataTable data
                columns: [
                    // {
                    //     data: 'id',
                    //     name: 'id',
                    //     className: 'text-center',
                    //     orderable: false
                    // },
                    {
                        data: null,
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Nomor urut sederhana
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex justify-content-center m-2">
                                <bottom data-toggle="modal" data-target="#${data}" class="btn mb-1 btn-primary">Lihat</bottom>
                            </div>`;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'part_number',
                        name: 'part_number'
                    },
                    {
                        data: 'document_number',
                        name: 'document_number'
                    },
                    {
                        data: 'characteristics',
                        name: 'characteristics'
                    },
                    {
                        data: 'effective_date',
                        name: 'effective_date'
                    },
                    {
                        data: 'expired_date',
                        name: 'expired_date'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'dimension',
                        name: 'dimension'
                    },
                    {
                        data: 'appearance',
                        name: 'appearance'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'metode_pengecekan',
                        name: 'metode_pengecekan'
                    },
                    {
                        data: 'penolak_id',
                        name: 'penolak_id'
                    },
                    {
                        data: 'penolak_posisi',
                        name: 'penolak_posisi'
                    },
                    {
                        data: 'penolakan',
                        name: 'penolakan'
                    },
                    {
                        data: 'penolakan_date',
                        name: 'penolakan_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'sec_head_approval_date1',
                        name: 'sec_head_approval_date1'
                    },
                    {
                        data: 'sec_head_approval_date2',
                        name: 'sec_head_approval_date2'
                    },
                    {
                        data: 'dept_head_approval_date',
                        name: 'dept_head_approval_date'
                    },
                    {
                        data: 'submit_date',
                        name: 'submit_date'
                    },
                    {
                        data: 'count_visit',
                        name: 'count_visit'
                    },
                    {
                        data: 'deleted_at',
                        name: 'deleted_at' // Jika ingin menampilkan data soft delete
                    },



                ]
            });
        });


        //get modal data
        const dataRoles = @json(session('roles'));
        const userAll = @json(session('all_users'));
        // Ambil nilai dari sesi (ini bisa berbeda tergantung bagaimana sesi diakses di aplikasi Anda)
        let userDetailDeptId = @json(session('user')['detail_dept_id']);
        let allDetailDepts = @json(session('all_detail_dept', []));

        // Buat array dengan kolom 'id' dari setiap objek dalam allDetailDepts
        let detailDeptColumn = allDetailDepts.map(dept => dept.id);
        let searchDetailDeptId;


        $.ajax({
            url: "{{ route('limitSample.arsipModal') }}",
            type: "GET",
            success: function(data) {
                $.each(data, function(index, item) {
                    // Cari indeks dari userDetailDeptId dalam detailDeptColumn
                    searchDetailDeptId = detailDeptColumn.indexOf(parseInt(item.penolak_id, 10));

                    // Pastikan nilai yang ditemukan adalah indeks yang valid
                    let penolakDetailDeptName = searchDetailDeptId !== -1 ? allDetailDepts[
                        searchDetailDeptId].name : null;

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
                                                            <div class="col-6 p-3 border border-dark ">
                                                                 <a href="{{ asset('img/areaPart/') }}/${item.foto_ke_satu}"
                                                        data-lightbox="foto${item.id}" data-title="Foto 1">
                                                                <img src="{{ asset('img/areaPart/') }}/${item.foto_ke_satu}" alt="" class="fotoLimitSample">
                                                                </a>

                                                                </div>
                                                            <div class="col-6 p-3 border border-dark ">
                                            <a href="{{ asset('img/areaPart/') }}/${item.foto_ke_dua}"
                                                        data-lightbox="foto${item.id}" data-title="Foto 2">
                                                                <img src="{{ asset('img/areaPart/') }}/${item.foto_ke_dua}" alt="" class="fotoLimitSample">
                                                                </a>

                                                                </div>
                                                            <div class="col-6 p-3 border border-dark ">
                                            <a href="{{ asset('img/areaPart/') }}/${item.foto_ke_tiga}"
                                                            data-lightbox="foto${item.id}" data-title="Foto 3">
                                                                <img src="{{ asset('img/areaPart/') }}/${item.foto_ke_tiga}" alt="" class="fotoLimitSample">
                                                                </a>

                                                                </div>
                                                            <div class="col-6 p-3 border border-dark ">
                                            <a href="{{ asset('img/areaPart/') }}/${item.foto_ke_empat}"
                                                            data-lightbox="foto${item.id}" data-title="Foto 4">
                                                                <img src="{{ asset('img/areaPart/') }}/${item.foto_ke_empat}" alt="" class="fotoLimitSample">
                                                                </a>

                                                                </div>
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
                                                                ${item.sec_head_approval_date1 ? `
                                                                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove </strong></p>
                                                                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Pada ${item.sec_head_approval_date2} </strong></p>
                                                                                                    ` : ` `}

                                                                ${item.status == 'tolak' && penolakDetailDeptName == 'Quality Control' && item.penolak_posisi == 'Supervisor' ? `
                                                                                                        <br><p style="color: red;" class="p-0 m-0"><strong> Ditolak </strong></p>
                                                                                                    ` : `<br><br>`}
                                                                <br>
                                                                <p><strong>Section Head 1</strong></p>
                                                            </div>
                                                            <div class="col-3 p-1 border border-dark ">
                                                                <p><strong>Approval</strong></p>
                                                                <br>
                                                                ${item.sec_head_approval_date2 ? `
                                                                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove </strong></p>
                                                                                                        <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Pada ${item.sec_head_approval_date1} </strong></p>
                                                                                                    ` : ` `}

                                                                ${item.status == 'tolak' && penolakDetailDeptName == 'Quality Assurance' && item.penolak_posisi == 'Supervisor' ? `
                                                                                                        <br><p style="color: red;" class="p-0 m-0"><strong> Ditolak </strong></p>
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
    </script>
@endsection
