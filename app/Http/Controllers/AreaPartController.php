<?php

namespace App\Http\Controllers;

use App\Mail\NeedApprovalMail;
use App\Mail\TolakLimitSampleMail;
use App\Models\AreaPart;
use App\Models\Characteristics;
use App\Models\ModelPart;
use App\Models\Part;
use App\Models\PartArea;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class AreaPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $part = Part::find($id);
        $model = ModelPart::find($part->model_part_id);
        if (in_array('Guest', session('roles', []))) {
            $partAreas = PartArea::has('areaPart')->whereHas('areaPart', fn($query) => $query->where(function($query) {
                $query->where('sec_head_approval_date1', '!=', null)
                      ->orWhere('sec_head_approval_date2', '!=', null);
            })->where('expired_date', '>' , Carbon::now()->format('Y-m-d')))->where('part_id', $id)->get();
            $count = $part->count_visit;
            $count++;
            $part->update([
                'count_visit' => $count,
            ]);
        } else {
            $partAreas = PartArea::where('part_id', $id)->get();
        }
        return response()->view('areaPart.index', compact('part', 'partAreas', 'model'));
    }

    public function katalog($id)
    {
        $partArea = PartArea::find($id);
        $part = Part::find($partArea->part_id);
        $model = ModelPart::find($part->model_part_id);
        $characteristics = Characteristics::all();

        if (in_array('Guest', session('roles', []))) {
            $count = $partArea->count_visit;
            $count++;
            $partArea->update([
                'count_visit' => $count,
            ]);
        }

        if (in_array('Guest', session('roles', []))) {
            $AreaParts = AreaPart::where('part_area_id', $id)->where('expired_date', '>' , Carbon::now()->format('Y-m-d'))
            ->where(function($query) {
                $query->where('sec_head_approval_date1', '!=', null)
                      ->orWhere('sec_head_approval_date2', '!=', null);
            })->simplePaginate();
        } else {
            $AreaParts = AreaPart::where('part_area_id', $id)->simplePaginate();
        }

        return response()->view('areaPart.katalog', compact('part', 'partArea', 'model', 'AreaParts', 'characteristics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // if(in_array('Guest', session('roles', []))){
        //     return redirect()->route('areaPart.katalog',['id' => $id]);
        // }
        $areaParts = AreaPart::where('part_area_id', $id)->get();
        $partArea = PartArea::find($id);

        //mengambil id data terakhir untuk membuat document number
        $lastAreaPartId = AreaPart::latest()->pluck('id')->first();
        //jika data null(pertama) beri nilai manual satu
        if ($lastAreaPartId == null) {
            $lastAreaPartId = 1;
        } else {
            $lastAreaPartId++;
        }
        $part = Part::find($partArea->part_id);
        $model = ModelPart::find($part->model_part_id);
        return response()->view('areaPart.create', compact('part', 'areaParts', 'partArea', 'model', 'lastAreaPartId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $partArea = PartArea::find($id);
        $part = Part::find($partArea->part_id);

        // Validasi data dari form
        $validatedData = $request->validate([
            'name' => 'required',
            'characteristics' => 'required',
            'effective_date' => 'required',
            'expired_date' => 'required',
            'deskripsi' => 'required',
            'dimension' => 'required',
            'appearance' => 'required',
            'jumlah' => 'required',
            'metode_pengecekan' => 'required',
            'foto_ke_satu' => 'required',
            'foto_ke_dua' => 'required',
            'foto_ke_tiga' => 'required',
            'foto_ke_empat' => 'required',
            'part_number' => 'required',
            'document_number' => 'required',
        ]);

        $validatedData['effective_date'] = Carbon::createFromFormat('m/d/Y', $request->effective_date)->format('Y-m-d');
        $validatedData['expired_date'] = Carbon::createFromFormat('m/d/Y', $request->expired_date)->format('Y-m-d');

        // Pindahkan foto ke direktori public/img/part
        if ($request->hasFile('foto_ke_satu')) {
            $image = $request->file('foto_ke_satu');
            $imageName = time() . '_satu.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/areaPart'), $imageName);
            $validatedData['foto_ke_satu'] = $imageName; // Simpan nama file untuk database
        }

        if ($request->hasFile('foto_ke_dua')) {
            $image = $request->file('foto_ke_dua');
            $imageName = time() . '_dua.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/areaPart'), $imageName);
            $validatedData['foto_ke_dua'] = $imageName; // Simpan nama file untuk database
        }

        if ($request->hasFile('foto_ke_tiga')) {
            $image = $request->file('foto_ke_tiga');
            $imageName = time() . '_tiga.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/areaPart'), $imageName);
            $validatedData['foto_ke_tiga'] = $imageName; // Simpan nama file untuk database
        }

        if ($request->hasFile('foto_ke_empat')) {
            $image = $request->file('foto_ke_empat');
            $imageName = time() . '_empat.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/areaPart'), $imageName);
            $validatedData['foto_ke_empat'] = $imageName; // Simpan nama file untuk database
        }

        $validatedData['model_part_id'] = $part->modelPart->id;
        $validatedData['status'] = 'create';
        $validatedData['part_id'] = $part->id;
        $validatedData['part_area_id'] = $partArea->id;
        $validatedData['submit_date'] = Carbon::now();
        // Simpan data ke database
        AreaPart::create($validatedData);

        //kirim data yang sudah dibuat ke email untuk review sec head and Dept Head
        $emailData = AreaPart::latest()->first();

        //mengambil nama Dept Head
        $semuaUsers = session('all_users');
        foreach ($semuaUsers as $semuaUser) {
            if ($semuaUser['position_id'] == 1 && $semuaUser['detail_dept_id'] == 15 && $semuaUser['dept_id'] == 13) {
                //send Mail Ke Sec Head dan Dept Head
                Mail::to($semuaUser['email'])->send(new NeedApprovalMail($emailData, $semuaUser['name']));
            } elseif ($semuaUser['position_id'] == 2 && $semuaUser['detail_dept_id'] == 15 && $semuaUser['dept_id'] == 13) {
                //send Mail Ke Sec Head dan Dept Head
                Mail::to($semuaUser['email'])->send(new NeedApprovalMail($emailData, $semuaUser['name']));
            }
        }

        // Redirect atau return ke halaman lain dengan pesan sukses
        return redirect()
            ->route('areaPart.katalog', ['id' => $id])
            ->with('success', 'Limit Sample Berhasil di Tambahkan!');
    }

    public function approvalSecHead1(Request $request, $id)
    {
        $areaPart = AreaPart::find($id);
        $areaPart->update([
            'sec_head_approval_date1' => Carbon::now()->format('Y-m-d'),
            'status' => 'approve',
        ]);

        return redirect()
            ->route('areaPart.katalog', ['id' => $areaPart->part_area_id])
            ->with('success', 'Limit Sample Berhasil di Approve');
    }

    public function approvalSecHead2(Request $request, $id)
    {
        $areaPart = AreaPart::find($id);
        $areaPart->update([
            'sec_head_approval_date2' => Carbon::now()->format('Y-m-d'),
            'status' => 'approve',
        ]);

        return redirect()
            ->route('areaPart.katalog', ['id' => $areaPart->part_area_id])
            ->with('success', 'Limit Sample Berhasil di Approve');
    }

    public function approvalDeptHead(Request $request, $id)
    {
        $areaPart = AreaPart::find($id);
        $areaPart->update([
            'dept_head_approval_date' => Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()
            ->route('areaPart.katalog', ['id' => $areaPart->part_area_id])
            ->with('success', 'Limit Sample Berhasil di Approve');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AreaPart  $areaPart
     * @return \Illuminate\Http\Response
     */
    // public function show(AreaPart $areaPart)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AreaPart  $areaPart
     * @return \Illuminate\Http\Response
     */
    public function edit(AreaPart $areaPart, $id)
    {
        $areaPart = AreaPart::find($id);
        $part = Part::find($areaPart->part_id);
        $model = ModelPart::find($part->model_part_id);
        return response()->view('areaPart.edit', compact('part', 'areaPart', 'model'));
    }

    public function tolakSecHead(Request $request, $id)
    {
        $areaPart = AreaPart::find($id);
        $partArea = PartArea::find($areaPart->part_area_id);
        $part = Part::find($areaPart->part_id);
        $model = ModelPart::find($part->model_part_id);
        return response()->view('areaPart.tolakLimitSample', compact('part', 'areaPart', 'model', 'partArea'));
    }

    public function tolakSecHeadProsses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'penolak_id' => 'required',
            'penolakan' => 'required',
        ]);
        $areaPart = AreaPart::find($id);
        $validatedData['sec_head_approval_date1'] = null;
        $validatedData['sec_head_approval_date2'] = null;
        $validatedData['dept_head_approval_date'] = null;
        $validatedData['status'] = 'tolak';
        $validatedData['penolak_posisi'] = implode(', ', session('roles'));
        $validatedData['penolakan_date'] = Carbon::now()->format('Y-m-d');
        $areaPart->update($validatedData);
        $partArea = PartArea::find($areaPart->part_area_id);
        $part = Part::find($areaPart->part_id);
        $model = ModelPart::find($part->model_part_id);

        //kirim data yang sudah dibuat ke email untuk informasi Penolakan ke sec head and Dept Head
        $emailData = AreaPart::find($id);
        //mengambil nama Dept Head
        $semuaUsers = session('all_users');
        foreach ($semuaUsers as $semuaUser) {
            if ($semuaUser['position_id'] == 1 && $semuaUser['detail_dept_id'] == 15 && $semuaUser['dept_id'] == 13) {
                //send Mail ke Dept Head
                Mail::to($semuaUser['email'])->send(new TolakLimitSampleMail($emailData, $semuaUser['name']));
            } elseif ($semuaUser['position_id'] == 2 && $semuaUser['detail_dept_id'] == 15 && $semuaUser['dept_id'] == 13) {
                //send Mail Ke Sec Head
                Mail::to($semuaUser['email'])->send(new TolakLimitSampleMail($emailData, $semuaUser['name']));
            } elseif ($semuaUser['username'] == 'adminLS') {
                //send Mail ke Admin
                Mail::to($semuaUser['email'])->send(new TolakLimitSampleMail($emailData, $semuaUser['name']));
            }
        }
        return redirect()
            ->route('areaPart.katalog', ['id' => $areaPart->part_area_id])
            ->with('success', 'Limit Sample Berhasil di Tolak');
    }

    public function tolakDeptHead(Request $request, $id)
    {
        $areaPart = AreaPart::find($id);
        $partArea = PartArea::find($areaPart->part_area_id);
        $part = Part::find($areaPart->part_id);
        $model = ModelPart::find($part->model_part_id);
        return response()->view('areaPart.tolakLimitSample', compact('part', 'areaPart', 'model', 'partArea'));
    }

    public function tolakDeptHeadProsses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'penolak_id' => 'required',
            'penolakan' => 'required',
        ]);
        $areaPart = AreaPart::find($id);
        $validatedData['sec_head_approval_date1'] = null;
        $validatedData['sec_head_approval_date2'] = null;
        $validatedData['dept_head_approval_date'] = null;
        $validatedData['status'] = 'tolak';
        $validatedData['penolak_posisi'] = implode(', ', session('roles'));
        $validatedData['penolakan_date'] = Carbon::now()->format('Y-m-d');
        $areaPart->update($validatedData);
        $partArea = PartArea::find($areaPart->part_area_id);
        $part = Part::find($areaPart->part_id);
        $model = ModelPart::find($part->model_part_id);
        return redirect()
            ->route('areaPart.katalog', ['id' => $areaPart->part_area_id])
            ->with('success', 'Limit Sample Berhasil di Approve');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaPart  $areaPart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $oldAreaPart = AreaPart::find($id);
        $part = Part::find($oldAreaPart->part_id);
        $modelPart = ModelPart::find($oldAreaPart->model_part_id);
        $partArea = PartArea::find($oldAreaPart->part_area_id);

        // Validasi data dari form
        $validatedData = $request->validate([
            'name' => 'required',
            'characteristics' => 'required',
            'effective_date' => 'required',
            'expired_date' => 'required',
            'deskripsi' => 'required',
            'dimension' => 'required',
            'appearance' => 'required',
            'jumlah' => 'required',
            'metode_pengecekan' => 'required',
            'foto_ke_satu' => 'required',
            'foto_ke_dua' => 'required',
            'foto_ke_tiga' => 'required',
            'foto_ke_empat' => 'required',
            'part_number' => 'required',
            'document_number' => 'required',
        ]);

        $validatedData['effective_date'] = Carbon::createFromFormat('m/d/Y', $request->effective_date)->format('Y-m-d');
        $validatedData['expired_date'] = Carbon::createFromFormat('m/d/Y', $request->expired_date)->format('Y-m-d');

        // Pindahkan foto ke direktori public/img/part
        if ($request->hasFile('foto_ke_satu')) {
            // Ambil gambar lama dari database
            // $oldImage = $oldAreaPart->foto_ke_satu;

            // // Hapus gambar lama dari direktori jika ada
            // if ($oldImage && file_exists(public_path('img/areaPart/' . $oldImage))) {
            //     unlink(public_path('img/areaPart/' . $oldImage));
            // }

            // Ambil file gambar dari request
            $image = $request->file('foto_ke_satu');

            // Buat objek image dengan Intervention Image
            $img = Image::make($image->getRealPath());

            // Putar gambar 90 derajat
            if ($request->rotateFotoSatu != null) {
                $img->rotate($request->rotateFotoSatu + 180);
            } else {
                $img->rotate($request->rotateFotoSatu);
            }

            // Ambil dimensi gambar
            $width = $img->width();
            $height = $img->height();
            // Tentukan ukuran baru
            if ($width > $height) {
                // Jika lebar lebih besar dari tinggi, resize lebar
                $newWidth = 1600; // Ganti dengan lebar yang Anda inginkan
                $aspectRatio = $height / $width; // Rasio tinggi terhadap lebar
                $newHeight = $newWidth * $aspectRatio; // Hitung tinggi baru
                $img->resize($newWidth, $newHeight); // Resize dengan rasio
            } else {
                // Jika tinggi lebih besar dari lebar, resize tinggi
                $newHeight = 1000; // Ganti dengan tinggi yang Anda inginkan
                $aspectRatio = $width / $height; // Rasio lebar terhadap tinggi
                $newWidth = $newHeight * $aspectRatio; // Hitung lebar baru
                $img->resize($newWidth, $newHeight); // Resize dengan rasio
            }

            // Siapkan nama file untuk disimpan
            $imageName = time() . '_satu.' . $image->getClientOriginalExtension();

            // Simpan gambar yang sudah diputar ke direktori tujuan
            $img->save(public_path('img/areaPart/' . $imageName));

            // Simpan nama file yang sudah diputar ke dalam validated data
            $validatedData['foto_ke_satu'] = $imageName;
        }

        if ($request->hasFile('foto_ke_dua')) {
            // Ambil gambar lama dari database
            // $oldImage = $oldAreaPart->foto_ke_satu;

            // // Hapus gambar lama dari direktori jika ada
            // if ($oldImage && file_exists(public_path('img/areaPart/' . $oldImage))) {
            //     unlink(public_path('img/areaPart/' . $oldImage));
            // }

            // Ambil file gambar dari request
            $image = $request->file('foto_ke_dua');

            // Buat objek image dengan Intervention Image
            $img = Image::make($image->getRealPath());

            // Putar gambar 90 derajat
            if ($request->rotateFotoDua != null) {
                $img->rotate($request->rotateFotoDua + 180);
            } else {
                $img->rotate($request->rotateFotoDua);
            }

            // Ambil dimensi gambar
            $width = $img->width();
            $height = $img->height();

            // Tentukan ukuran baru
            if ($width > $height) {
                // Jika lebar lebih besar dari tinggi, resize lebar
                $newWidth = 1600; // Ganti dengan lebar yang Anda inginkan
                $aspectRatio = $height / $width; // Rasio tinggi terhadap lebar
                $newHeight = $newWidth * $aspectRatio; // Hitung tinggi baru
                $img->resize($newWidth, $newHeight); // Resize dengan rasio
            } else {
                // Jika tinggi lebih besar dari lebar, resize tinggi
                $newHeight = 1000; // Ganti dengan tinggi yang Anda inginkan
                $aspectRatio = $width / $height; // Rasio lebar terhadap tinggi
                $newWidth = $newHeight * $aspectRatio; // Hitung lebar baru
                $img->resize($newWidth, $newHeight); // Resize dengan rasio
            }
            // Siapkan nama file untuk disimpan
            $imageName = time() . '_dua.' . $image->getClientOriginalExtension();

            // Simpan gambar yang sudah diputar ke direktori tujuan
            $img->save(public_path('img/areaPart/' . $imageName));

            // Simpan nama file yang sudah diputar ke dalam validated data
            $validatedData['foto_ke_dua'] = $imageName;
        }

        if ($request->hasFile('foto_ke_tiga')) {
            // Ambil gambar lama dari database
            $oldImage = $oldAreaPart->foto_ke_satu;

            // // Hapus gambar lama dari direktori jika ada
            // if ($oldImage && file_exists(public_path('img/areaPart/' . $oldImage))) {
            //     unlink(public_path('img/areaPart/' . $oldImage));
            // }

            // Ambil file gambar dari request
            $image = $request->file('foto_ke_tiga');

            // Buat objek image dengan Intervention Image
            $img = Image::make($image->getRealPath());

            // Putar gambar 90 derajat
            if ($request->rotateFotoTiga != null) {
                $img->rotate($request->rotateFotoTiga + 180);
            } else {
                $img->rotate($request->rotateFotoTiga);
            }

            // Ambil dimensi gambar
            $width = $img->width();
            $height = $img->height();

            // Tentukan ukuran baru
            if ($width > $height) {
                // Jika lebar lebih besar dari tinggi, resize lebar
                $newWidth = 1600; // Ganti dengan lebar yang Anda inginkan
                $aspectRatio = $height / $width; // Rasio tinggi terhadap lebar
                $newHeight = $newWidth * $aspectRatio; // Hitung tinggi baru
                $img->resize($newWidth, $newHeight); // Resize dengan rasio
            } else {
                // Jika tinggi lebih besar dari lebar, resize tinggi
                $newHeight = 1000; // Ganti dengan tinggi yang Anda inginkan
                $aspectRatio = $width / $height; // Rasio lebar terhadap tinggi
                $newWidth = $newHeight * $aspectRatio; // Hitung lebar baru
                $img->resize($newWidth, $newHeight); // Resize dengan rasio
            }
            // Siapkan nama file untuk disimpan
            $imageName = time() . '_tiga.' . $image->getClientOriginalExtension();

            // Simpan gambar yang sudah diputar ke direktori tujuan
            $img->save(public_path('img/areaPart/' . $imageName));

            // Simpan nama file yang sudah diputar ke dalam validated data
            $validatedData['foto_ke_tiga'] = $imageName;
        }

        if ($request->hasFile('foto_ke_empat')) {
            // Ambil gambar lama dari database
            $oldImage = $oldAreaPart->foto_ke_satu;

            // // Hapus gambar lama dari direktori jika ada
            // if ($oldImage && file_exists(public_path('img/areaPart/' . $oldImage))) {
            //     unlink(public_path('img/areaPart/' . $oldImage));
            // }

            // Ambil file gambar dari request
            $image = $request->file('foto_ke_empat');

            // Buat objek image dengan Intervention Image
            $img = Image::make($image->getRealPath());

            // Putar gambar 90 derajat
            if ($request->rotateFotoEmpat != null) {
                $img->rotate($request->rotateFotoEmpat + 180);
            } else {
                $img->rotate($request->rotateFotoEmpat);
            }

            // Ambil dimensi gambar
            $width = $img->width();
            $height = $img->height();

            // Tentukan ukuran baru
            if ($width > $height) {
                // Jika lebar lebih besar dari tinggi, resize lebar
                $newWidth = 1600; // Ganti dengan lebar yang Anda inginkan
                $aspectRatio = $height / $width; // Rasio tinggi terhadap lebar
                $newHeight = $newWidth * $aspectRatio; // Hitung tinggi baru
                $img->resize($newWidth, $newHeight); // Resize dengan rasio
            } else {
                // Jika tinggi lebih besar dari lebar, resize tinggi
                $newHeight = 1000; // Ganti dengan tinggi yang Anda inginkan
                $aspectRatio = $width / $height; // Rasio lebar terhadap tinggi
                $newWidth = $newHeight * $aspectRatio; // Hitung lebar baru
                $img->resize($newWidth, $newHeight); // Resize dengan rasio
            }
            // Siapkan nama file untuk disimpan
            $imageName = time() . '_empat.' . $image->getClientOriginalExtension();

            // Simpan gambar yang sudah diputar ke direktori tujuan
            $img->save(public_path('img/areaPart/' . $imageName));

            // Simpan nama file yang sudah diputar ke dalam validated data
            $validatedData['foto_ke_empat'] = $imageName;
        }
        $lastAreaPartId = AreaPart::orderBy('id', 'desc')->pluck('id')->first();
        $lastAreaPartId++;
        $validatedData['document_number'] = "AJI/LS/$modelPart->name/$part->name/$partArea->nameArea/0$lastAreaPartId";
        $validatedData['model_part_id'] = $part->modelPart->id;
        $validatedData['part_id'] = $part->id;
        $validatedData['status'] = 'update';
        $validatedData['part_area_id'] = $oldAreaPart->part_area_id;
        $validatedData['submit_date'] = $oldAreaPart->submit_date;
        // Simpan data ke database
        $oldAreaPart->delete();
        AreaPart::create($validatedData);

        // Redirect atau return ke halaman lain dengan pesan sukses
        return redirect()->route('areaPart.katalog', ['id' => $partArea->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaPart  $areaPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $deleteData = AreaPart::find($id);
        $partArea = PartArea::find($deleteData->part_area_id);
        // if (file_exists(public_path('img/areaPart/' . $deleteData->foto_ke_satu)) != false) {
        //     unlink(public_path('img/areaPart/' . $deleteData->foto_ke_satu));
        //     unlink(public_path('img/areaPart/' . $deleteData->foto_ke_dua));
        //     unlink(public_path('img/areaPart/' . $deleteData->foto_ke_tiga));
        //     unlink(public_path('img/areaPart/' . $deleteData->foto_ke_empat));
        // }

        $deleteData->delete();
        return redirect()->route('areaPart.katalog', ['id' => $partArea->id]);
    }

    public function katalogSearch(Request $request, $id)
    {
        $partArea = PartArea::find($id);
        $part = Part::find($partArea->part_id);
        $model = ModelPart::find($part->model_part_id);
        if ($request->ajax()) {
            // Jika AJAX, ambil parameter pencarian
            $searchTerm = $request->input('query');
            if (in_array('Guest', session('roles', []))) {
                $AreaParts = AreaPart::with(['modelPart'])
                    ->where('part_area_id', $id)
                    ->where(function($query) {
                        $query->where('sec_head_approval_date1', '!=', null)
                              ->orWhere('sec_head_approval_date2', '!=', null);
                    })
                    ->where('name', 'LIKE', "%$searchTerm%")
                    ->get();
            } else {
                $AreaParts = AreaPart::with(['modelPart'])
                    ->where('part_area_id', $id)
                    ->where('name', 'LIKE', "%$searchTerm%")
                    ->get();
            }
            return response()->json($AreaParts);
        } else {
            if (in_array('Guest', session('roles', []))) {
                $AreaParts = AreaPart::with(['modelPart'])
                    ->where('part_area_id', $id)
                    ->where(function($query) {
                        $query->where('sec_head_approval_date1', '!=', null)
                              ->orWhere('sec_head_approval_date2', '!=', null);
                    })
                    ->where('name', 'LIKE', "%$request->searchKatalog%")
                    ->simplePaginate();
            } else {
                $AreaParts = AreaPart::with(['modelPart'])
                    ->where('part_area_id', $id)
                    ->where('name', 'LIKE', "%$request->searchKatalog%")
                    ->simplePaginate();
            }
            $characteristics = Characteristics::all();
            return response()->view('areaPart.katalog', compact('part', 'partArea', 'model', 'AreaParts', 'characteristics'));
        }
    }

    public function getDataCharacteristic(Request $request, $id)
    {
        $partArea = PartArea::find($id);
        $part = Part::find($partArea->part_id);
        $model = ModelPart::find($part->model_part_id);
        $sortChar = $request->sortChar;
        $AreaParts = AreaPart::with(['modelPart'])
            ->where('part_area_id', $partArea->id)
            ->where('characteristics', 'LIKE', "%$sortChar%")
            ->get();
        return response()->json($AreaParts);
    }

    public function download($filename)
    {
        // Tentukan path file, sesuaikan dengan lokasi file Anda
        $filePath = public_path('template/' . $filename);

        // Periksa apakah file ada
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return abort(404, 'File not found.');
    }

    public function addCharacteristic(Request $request)
    {
        // Retrieve the 'newChar' parameter from the request
        $newChar = $request->input('newChar');
        Characteristics::create([
            'name' => $newChar,
        ]);

        $allChar = Characteristics::all();

        return response()->json($allChar);
    }

    public function delCharacteristic(Request $request)
    {
        // Retrieve the 'newChar' parameter from the request
        $delIdChar = $request->input('delChar');
        $delChar = Characteristics::find($delIdChar);
        $delChar->delete();
        $allChar = Characteristics::all();

        return response()->json($allChar);
    }

    public function exportPDF($id)
    {
        ini_set('max_execution_time', 120);
        // Ambil data areaPart berdasarkan ID
        $areaPart = AreaPart::find($id);

        // Jika Anda ingin menambahkan data dari session
        // $allUsers = session('all_users', []);

        // Buat PDF dari view
        $pdf = FacadePdf::loadView('pdf.export', ['areaPart' => $areaPart])->setPaper('a4', 'landscape');

        // Atur nama file untuk PDF
        return $pdf->stream('area_part_' . $areaPart->id . '.pdf');
    }

    public function katalogCount(Request $request, $idCount)
    {
        $areaPart = AreaPart::find($idCount);
        $count = $areaPart->count_visit;
        $count++;
        $areaPart->update([
            'count_visit' => $count,
        ]);
        return response()->json();
    }

    public function listKatalog(Request $request,$id){
        $data = AreaPart::with(['modelPart'])->where('part_area_id', $id)->get();
        return DataTables::of($data)->make(true);
    }
}
