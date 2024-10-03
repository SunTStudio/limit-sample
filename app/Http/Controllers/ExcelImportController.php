<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaPart; // Ganti dengan nama model Anda
use App\Models\ModelPart;
use App\Models\Part;
use App\Models\PartArea;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Zip;

class ExcelImportController extends Controller
{
    public function import(Request $request, $id)
    {
        $partArea = PartArea::find($id);
        $part = Part::find($partArea->part_id);
        $modelPart = ModelPart::find($part->model_part_id);

        $request->validate([
            'excel_file' => 'required|mimes:xlsx,csv,xls',
            'zip_file' => 'required|mimes:zip|max:20480',
        ]);

        //menyimpan zip yang berisi foto ke public/img/areaPart
        // Simpan zip file sementara di storage
        $zipPath = $request->file('zip_file')->store('temp', 'public');

        // Lokasi direktori tujuan ekstraksi
        $extractTo = public_path('img/areaPart');

        // Buka dan ekstrak file zip
        $zip = Zip::open(storage_path('app/public/' . $zipPath));

        // Ekstrak semua file ke direktori public/img
        $zip->extract($extractTo);

        // Tutup zip setelah diekstrak
        $zip->close();

        // Hapus file zip setelah diekstrak
        Storage::disk('public')->delete($zipPath);

        $excel_file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($excel_file);
        $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($data as $index => $row) {
            if ($index === 1 || $index === 2) {
                continue; // Lewati baris pertama dan kedua
            }
            // // Ambil gambar berdasarkan koordinat gambar di lembar kerja
            // $fotoKeSatu = $this->uploadImageFromExcel($spreadsheet, $index + 2, 'L');
            // $fotoKeDua = $this->uploadImageFromExcel($spreadsheet, $index + 2, 'M');
            // $fotoKeTiga = $this->uploadImageFromExcel($spreadsheet, $index + 2, 'N');
            // $fotoKeEmpat = $this->uploadImageFromExcel($spreadsheet, $index + 2, 'O');

            //apabila colomn sebaris kosong terdeteksi maka akan di skip
            if ($row['A'] == '') {
                continue;
            }
            // Mengambil tanggal efektif dan kedaluwarsa
            $effective_date = $row['E'];
            $expired_date = $row['F'];
            $lastAreaPartId = AreaPart::latest()->pluck('id')->first();

            AreaPart::create([
                'model_part_id' => $modelPart->id,
                'part_id' => $part->id,
                'part_area_id' => $partArea->id,
                'name' => $row['A'],
                'part_number' => $row['B'],
                'document_number' => "AJI/LS/$modelPart->name/$part->name/0$lastAreaPartId",
                'characteristics' => $row['D'],
                'effective_date' => $effective_date,
                'expired_date' => $expired_date,
                'deskripsi' => $row['G'],
                'dimension' => $row['H'],
                'appearance' => $row['I'],
                'jumlah' => $row['J'],
                'metode_pengecekan' => $row['K'],
                'foto_ke_satu' => $row['L'],
                'foto_ke_dua' => $row['M'],
                'foto_ke_tiga' => $row['N'],
                'foto_ke_empat' => $row['O'],
                'sec_head_approval_date' => $row['P'] ?? null,
                'dept_head_approval_date' => $row['Q'] ?? null,
                'submit_date' => Carbon::now()->format('Y-m-d'),
            ]);
        }

        return redirect()->back()->with('success', 'Data imported successfully.');
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
