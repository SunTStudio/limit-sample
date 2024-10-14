<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
        }

        .fotoLimitSample {
            max-width: 50%; /* Adjust image size */
            height: auto; /* Maintain aspect ratio */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000; /* Border for table cells */
            text-align: left; /* Align text to the left */
            font-size: 0.8rem;
        }

        td{
            vertical-align: top;
            padding: 5px;
        }

        #imgLS {
            width: 60%; /* Set fixed width for the image cell */
        }

        #detailLS {
            width: 40%; /* Set fixed width for the detail cell */
        }

        #imgLS th, #imgLS td {
            border: 0px solid #ffffff; /* Border for table cells */
            text-align: left; /* Align text to the left */
            font-size: 0.8rem;
        }

        #detailLS th, #detailLS td {
            border: 0px solid #ffffff; /* Border for table cells */
            text-align: left; /* Align text to the left */
            font-size: 0.8rem;
        }

        th {
            background-color: #002060; /* Header background color */
            color: yellow; /* Header text color */
        }

        .header-row {
            background-color: #e0e0e0; /* Header row color */
        }

        .white-bg {
            background-color: #ffffff;
        }

        .text-center {
            text-align: center;
        }

        #approval td{
            text-align: center;
        }
    </style>
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/animate.css" rel="stylesheet">
</head>
<body>
    <table>
        <tr class="header-row">
            <th style="width: 20%;" class="text-center white-bg">
                <img src="../public/img/limitSample/logoLimitSample.png" style="width: 60%; padding:1rem;" class="img-fluid" alt="">
            </th>
            <th style="width: 60%; font-size:3rem;" class="text-center">
                <strong> LIMIT SAMPLE </strong>
            </th>
            <th style="width: 20%;font-size:2rem;" class="text-center">
                <strong>{{ $areaPart->modelPart->name }}</strong>
            </th>
        </tr>
    </table>
    <table class="white-bg">
        <tr>
            <td><strong>Part Name</strong>: {{ $areaPart->name }}</td>
            <td><strong>Doc.No</strong>: {{ $areaPart->document_number }}</td>
            <td><strong>Effective Date</strong>: {{ $areaPart->effective_date }}</td>
        </tr>
        <tr>
            <td><strong>Charackteristic</strong>: {{ $areaPart->characteristics }}</td>
            <td><strong>Part Number</strong>: {{ $areaPart->part_number }}</td>
            <td >
                @if ($areaPart->expired_date < now()->toDateString())
                    <strong style="color:red;">Expired Date: {{ $areaPart->expired_date }}</strong>
                @else
                    <strong>Expired Date</strong>: {{ $areaPart->expired_date }}
                @endif
            </td>
        </tr>
    </table>

    <table class="white-bg">
        <tr>
            <td id="imgLS">
                <table>
                    <tr>
                        <td class="text-center" colspan="2"><img src="../public/img/areaPart/{{ $areaPart->foto_ke_satu }}" alt="" class="fotoLimitSample"></td>
                        <td class="text-center" colspan="2"><img src="../public/img/areaPart/{{ $areaPart->foto_ke_dua }}" alt="" class="fotoLimitSample"></td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="2"><img src="../public/img/areaPart/{{ $areaPart->foto_ke_tiga }}" alt="" class="fotoLimitSample"></td>
                        <td class="text-center"colspan="2"><img src="../public/img/areaPart/{{ $areaPart->foto_ke_empat }}" alt="" class="fotoLimitSample"></td>
                    </tr>
                </table>
            </td>
            <td id="detailLS" class="white-bg">

                <table>
                    <tr>
                        <td colspan="2"><strong>A.Detail</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $areaPart->deskripsi }}</td>
                    </tr>
                    <tr>
                        <td><strong>1. Appearance</strong>: {{ $areaPart->appearance }}</td>
                    </tr>
                    <tr>
                        <td><strong>2. Dimension</strong>: {{ $areaPart->dimension }}</td>
                    </tr>
                    <tr >
                        <td style="padding-bottom: 1rem;"><strong>3. Jumlah</strong>: {{ $areaPart->jumlah }}</td>
                    </tr>
                </table>
                <hr style="margin: 0; border: 0; border-top: 1px solid black; width: 100%;">
                <table class="white-bg">
                    <tr>
                        <td colspan="2"><strong>B.Metode Pengecekan</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $areaPart->metode_pengecekan }}</td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

    <table class="white-bg" id="approval">
        <tr>
            <td style="width: 50%;">
                <strong>Approval</strong><br>
                @if ($areaPart->sec_head_approval_date1 != null)
                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove</strong></p>
                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>Pada {{ $areaPart->sec_head_approval_date1 }}</strong></p>
                @elseif ($areaPart->status == 'tolak' && $areaPart->penolak_posisi == 'Supervisor')
                    <br>
                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>DiTolak</strong></p>
                @else
                    <br><br>
                @endif
                <strong>Section Head</strong>
            </td>
            <td style="width: 50%;">
                <strong>Approval</strong><br>
                @if ($areaPart->sec_head_approval_date2 != null)
                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove</strong></p>
                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>Pada {{ $areaPart->sec_head_approval_date2 }}</strong></p>
                @elseif ($areaPart->status == 'tolak' && $areaPart->penolak_posisi == 'Supervisor')
                    <br>
                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>DiTolak</strong></p>
                @else
                    <br><br>
                @endif
                <strong>Section Head</strong>
            </td>
            <td style="width: 50%;">
                <strong>Approval</strong><br>
                @if ($areaPart->dept_head_approval_date != null)
                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong> Sudah diApprove</strong></p>
                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>Pada {{ $areaPart->dept_head_approval_date }}</strong></p>
                @elseif ($areaPart->status == 'tolak' && $areaPart->penolak_posisi == 'Department Head')
                    <br>
                    <p style="color: rgb(18, 1, 170);" class="p-0 m-0"><strong>DiTolak</strong></p>
                @else
                    <br><br>
                @endif
                <strong>Departemen Head</strong>
            </td>
        </tr>
    </table>

    @if ($areaPart->status == 'tolak')
        <table class="white-bg">
            {{-- <tr>
                <td colspan="2">
                    <strong>Informasi Penolakan</strong>
                </td>
            </tr> --}}
            <tr>
                <td style="width: 50%;">Tanggal Penolakan: <strong> {{ $areaPart->penolakan_date }}</strong></td>
                <td style="width: 50%;">Catatan Penolakan: <strong> {{ $areaPart->penolakan }}</strong></td>
            </tr>
        </table>
    @endif

    <!-- Mainly scripts -->
    <script src="../public/js/jquery-3.1.1.min.js"></script>
    <script src="../public/js/popper.min.js"></script>
    <script src="../public/js/bootstrap.js"></script>
</body>
</html>
