<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaPart;
use App\Models\ModelPart;
use App\Models\Part;
use App\Models\PartArea;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Zip;
use ZipArchive;
use Illuminate\Support\Facades\File;
class ExcelImportController extends Controller
{
    public function import(Request $request, $id)
    {
        $partArea = PartArea::find($id);
        $lastIdAreapart = AreaPart::orderByDesc('id')->first();
        $part = Part::find($partArea->part_id);
        $modelPart = ModelPart::find($part->model_part_id);

        if($lastIdAreapart == null){
            $lastId = 1;
        }else{
            $lastId = $lastIdAreapart->id;
        }

        $request->validate([
            'excel_file' => 'required|mimes:xlsx,csv,xls',
            'zip_file' => 'required|mimes:zip|max:20480',
        ]);

        //menyimpan zip yang berisi foto ke public/img/areaPart
        // Simpan zip file sementara di storage
        $zipPath = $request->file('zip_file')->store('temp', 'public');

        // Lokasi direktori tujuan ekstraksi
        $extractTo = 'public/img/areaPart';

        // Buka dan ekstrak file zip menggunakan ZipArchive
        $zip = new ZipArchive();
        $res = $zip->open(storage_path('app/public/' . $zipPath));

        if ($res === true) {
            // Iterasi setiap file dalam zip
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileName = $zip->getNameIndex($i);

                // Pastikan hanya memproses file yang merupakan gambar (ekstensi .jpg, .jpeg, .png, .gif)
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    // Buat nama baru dengan menambahkan '1' sebelum ekstensi file
                    $newFileName = $lastId . pathinfo($fileName, PATHINFO_FILENAME) . '.' . $fileExtension;
                    // Ekstrak file ke lokasi sementara
                    $zip->extractTo(storage_path('app/temp/'), $fileName);
                    $sourceFilePath = storage_path('app/temp/' . $fileName);
                    $destinationFilePath = public_path('img/areaPart/' . $newFileName);
                    // Pindahkan dan rename file ke direktori tujuan
                    File::move($sourceFilePath, $destinationFilePath);
                }
            }
            // Tutup zip setelah selesai
            $zip->close();
        } else {
            echo 'Failed to open the zip file!';
        }

        // Hapus file zip setelah diekstrak
        Storage::disk('public')->delete($zipPath);

        $excel_file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($excel_file);
        $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($data as $index => $row) {
            if ($index === 1 || $index === 2) {
                continue; // Lewati baris pertama dan kedua
            }

            //apabila colomn sebaris kosong terdeteksi maka akan di skip
            if ($row['A'] == '') {
                continue;
            }
            // Mengambil tanggal efektif dan kedaluwarsa
            $effective_date = $row['E'];
            $expired_date = $row['F'];
            $lastAreaPartId = AreaPart::orderByDesc('id')->pluck('id')->first();
            if ($lastAreaPartId == null) {
                $lastAreaPartId = 1;
            } else {
                $lastAreaPartId++;
            }
            AreaPart::create([
                'model_part_id' => $modelPart->id,
                'part_id' => $part->id,
                'part_area_id' => $partArea->id,
                'name' => $row['A'],
                'part_number' => $row['B'],
                'document_number' => "AJI/LS/$modelPart->name/$part->name/$partArea->nameArea/0$lastAreaPartId",
                'characteristics' => $row['D'],
                'effective_date' => $effective_date,
                'expired_date' => $expired_date,
                'deskripsi' => $row['G'],
                'dimension' => $row['H'],
                'appearance' => $row['I'],
                'jumlah' => $row['J'],
                'metode_pengecekan' => $row['K'],
                'foto_ke_satu' => $lastId . $row['L']  ,
                'foto_ke_dua' =>$lastId . $row['M'] ,
                'foto_ke_tiga' =>$lastId . $row['N'] ,
                'foto_ke_empat' =>$lastId . $row['O'] ,
                'sec_head_approval_date1' => $row['P'] ?? null,
                'sec_head_approval_date2' => $row['Q'] ?? null,
                'dept_head_approval_date' => $row['R'] ?? null,
                'submit_date' => Carbon::now()->format('Y-m-d'),
            ]);
        }

        return redirect()->back()->with('success', 'Data imported Berhasil.');
    }

    private function uploadImageFromExcel($spreadsheet, $rowIndex, $column)
    {
        $drawingCollection = $spreadsheet->getActiveSheet()->getDrawingCollection();

        foreach ($drawingCollection as $drawing) {
            if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\Drawing) {
                $cellCoordinates = $drawing->getCoordinates();

                // Mendapatkan baris dan kolom dari koordinat sel
                [$cellColumn, $cellRow] = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($cellCoordinates);

                // Memeriksa apakah gambar berada di sel yang sesuai
                if ($cellRow == $rowIndex && $cellColumn == $column) {
                    $imagePath = $drawing->getPath();
                    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
                    $newFileName = uniqid('foto_ke_') . '.' . $imageExtension;

                    // Salin gambar ke folder tujuan
                    $destinationPath = public_path('img/areaPart/' . $newFileName);
                    copy($imagePath, $destinationPath); // Salin gambar

                    return 'img/areaPart/' . $newFileName; // Kembalikan path relatif
                }
            }
        }

        return null; // Jika tidak ada gambar
    }
}
