<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Will Expired Limit Sample</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <h2 style="font-weight: bold;">Notifikasi Will Expired Limit Sample</h2>
    <p style="font-size: 16px;">
        Ditemukan adanya Dokumen Limit Sample yang mendekati tanggal Expired Berikut Rinciannya :
    </p>
    @foreach ($areaParts as $areaPart)
    <ul style="list-style-type: none; padding: 0;">
        <li style="font-size: 16px;"><strong>No :</strong> {{ $loop->iteration }}</li>
        <li style="font-size: 16px;"><strong>Model :</strong> {{ $areaPart['modelPart']->name }}</li>
        <li style="font-size: 16px;"><strong>Jenis Part :</strong> {{ $areaPart['parts']->name }}</li>
        <li style="font-size: 16px;"><strong>Area Part :</strong> {{ $areaPart['partArea']->nameArea }}</li>
        <li style="font-size: 16px;"><strong>Tanggal Expired :</strong> {{ $areaPart['expired_date']}}</li>
        <li style="font-size: 16px;"><strong>Link Temuan :</strong>  {{ config('app.link_website') }}/limit-sample/area-part/{{ $areaPart['part_area_id'] }}</li>
    </ul>
    @endforeach

    <br>

    <p style="font-size: 16px;">Dimohon untuk dapat segera menindaklanjuti dokumen Limit Sample tersebut.</p>
    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>
