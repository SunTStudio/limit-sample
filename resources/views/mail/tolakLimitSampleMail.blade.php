<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penolakan Limit Sample</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <h2 style="font-weight: bold;">Penolakan Limit Sample oleh {{ $userPenerima }}</h2>
    <p style="font-size: 16px;">
        {{ $userPenerima }} telah menolak Limit Sample Area baru dengan Detail berikut :
    </p>
    <ul style="list-style-type: none; padding: 0;">
        <li style="font-size: 16px;"><strong>Model :</strong> {{ $data['modelPart']->name }}</li>
        <li style="font-size: 16px;"><strong>Jenis Part :</strong> {{ $data['parts']->name }}</li>
        <li style="font-size: 16px;"><strong>No. Area Part :</strong> {{ $data['part_number'] }}</li>
        <li style="font-size: 16px;"><strong>No. Dokumen :</strong> <span style="color:red; font-weight:600;"> {{ $data['document_number'] }} </span></li>
        <li style="font-size: 16px;"><strong>Tanggal Penolakan :</strong> {{ $data['penolakan_date'] }}</li>
        <li style="font-size: 16px;"><strong>Catatan Penolakan :</strong> {{ $data['penolakan'] }}</li>
    </ul>
    <p style="font-size: 16px;">Link Temuan :  {{ config('app.link_website') }}/limit-sample/area-part/{{ $data['part_id'] }}</p>

    <br>

    <p style="font-size: 16px;">Dimohon untuk dapat melakukan Perbaikan pada dokumen Limit Sample.</p>
    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>
