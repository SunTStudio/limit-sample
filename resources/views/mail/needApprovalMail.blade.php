<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Need Approval Limit Sample</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <h2 style="font-weight: bold;">Need Approval {{ $userPenerima }}</h2>
    <p style="font-size: 16px;">
        Admin telah membuat Limit Sample Area baru dengan Detail berikut :
    </p>
    <ul style="list-style-type: none; padding: 0;">
        <li style="font-size: 16px;"><strong>Model :</strong> {{ $data['modelPart']->name }}</li>
        <li style="font-size: 16px;"><strong>Jenis Part :</strong> {{ $data['parts']->name }}</li>
        <li style="font-size: 16px;"><strong>No. Area Part :</strong> {{ $data['part_number'] }}</li>
        <li style="font-size: 16px;"><strong>No. Dokumen :</strong> <span style="color:red; font-weight:600;"> {{ $data['document_number'] }} </span></li>
    </ul>
    <p style="font-size: 16px;">Link Temuan :  {{ config('app.link_website') }}/limit-sample/area-part/{{ $data['part_id'] }}</p>

    <br>

    <p style="font-size: 16px;">Dimohon untuk dapat melakukan Review pada dokument Limit Sample tersebut dan melakukan Appproval.</p>
    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>
