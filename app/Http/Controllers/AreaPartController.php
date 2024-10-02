<?php

namespace App\Http\Controllers;

use App\Models\AreaPart;
use App\Models\ModelPart;
use App\Models\Part;
use App\Models\PartArea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $partAreas = PartArea::where('part_id', $id)->get();
        return response()->view('areaPart.index', compact('part', 'partAreas', 'model'));
    }

    public function katalog($id)
    {
        $partArea = PartArea::find($id);
        $part = Part::find($partArea->part_id);
        $model = ModelPart::find($part->model_part_id);

        if (Auth::user()->hasRole('Guest')) {
            $AreaParts = AreaPart::where('part_area_id', $id)->whereNotNull('sec_head_approval_date')->simplePaginate();
        } else {
            $AreaParts = AreaPart::where('part_area_id', $id)->simplePaginate();
        }

        return response()->view('areaPart.katalog', compact('part', 'partArea', 'model', 'AreaParts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // if(Auth::user()->hasRole('Guest')){
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
        $validatedData['part_id'] = $part->id;
        $validatedData['part_area_id'] = $partArea->id;
        $validatedData['submit_date'] = Carbon::now();
        // Simpan data ke database
        AreaPart::create($validatedData);

        // Redirect atau return ke halaman lain dengan pesan sukses
        return redirect()->route('areaPart.katalog', ['id' => $id]);
    }

    public function approvalSecHead(Request $request, $id)
    {
        $areaPart = AreaPart::find($id);
        $areaPart->update([
            'sec_head_approval_date' => Carbon::now()->format('Y-m-d'),
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
    public function show(AreaPart $areaPart)
    {
        //
    }

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
            $oldImage = $oldAreaPart->foto_ke_satu;

            // Hapus gambar lama dari direktori jika ada
            if ($oldImage && file_exists(public_path('img/areaPart/' . $oldImage))) {
                unlink(public_path('img/areaPart/' . $oldImage));
            }

            $image = $request->file('foto_ke_satu');
            $imageName = time() . '_satu.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/areaPart'), $imageName);
            $validatedData['foto_ke_satu'] = $imageName; // Simpan nama file untuk database
        }

        if ($request->hasFile('foto_ke_dua')) {
            // Ambil gambar lama dari database
            $oldImage = $oldAreaPart->foto_ke_satu;

            // Hapus gambar lama dari direktori jika ada
            if ($oldImage && file_exists(public_path('img/areaPart/' . $oldImage))) {
                unlink(public_path('img/areaPart/' . $oldImage));
            }

            //masukan Gambar terbaru
            $image = $request->file('foto_ke_dua');
            $imageName = time() . '_dua.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/areaPart'), $imageName);
            $validatedData['foto_ke_dua'] = $imageName; // Simpan nama file untuk database
        }

        if ($request->hasFile('foto_ke_tiga')) {
            // Ambil gambar lama dari database
            $oldImage = $oldAreaPart->foto_ke_satu;

            // Hapus gambar lama dari direktori jika ada
            if ($oldImage && file_exists(public_path('img/areaPart/' . $oldImage))) {
                unlink(public_path('img/areaPart/' . $oldImage));
            }

            //masukan Gambar terbaru
            $image = $request->file('foto_ke_tiga');
            $imageName = time() . '_tiga.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/areaPart'), $imageName);
            $validatedData['foto_ke_tiga'] = $imageName; // Simpan nama file untuk database
        }

        if ($request->hasFile('foto_ke_empat')) {
            // Ambil gambar lama dari database
            $oldImage = $oldAreaPart->foto_ke_satu;

            // Hapus gambar lama dari direktori jika ada
            if ($oldImage && file_exists(public_path('img/areaPart/' . $oldImage))) {
                unlink(public_path('img/areaPart/' . $oldImage));
            }

            //masukan Gambar terbaru
            $image = $request->file('foto_ke_empat');
            $imageName = time() . '_empat.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/areaPart'), $imageName);
            $validatedData['foto_ke_empat'] = $imageName; // Simpan nama file untuk database
        }

        $validatedData['model_part_id'] = $part->modelPart->id;
        $validatedData['part_id'] = $part->id;
        $validatedData['part_area_id'] = $oldAreaPart->part_area_id;
        $validatedData['submit_date'] = $oldAreaPart->submit_date;
        // Simpan data ke database
        $oldAreaPart->update($validatedData);

        // Redirect atau return ke halaman lain dengan pesan sukses
        return redirect()->route('areaPart.katalog', ['id' => $oldAreaPart->part_area_id]);
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
        unlink(public_path('img/areaPart/' . $deleteData->foto_ke_satu));
        unlink(public_path('img/areaPart/' . $deleteData->foto_ke_dua));
        unlink(public_path('img/areaPart/' . $deleteData->foto_ke_tiga));
        unlink(public_path('img/areaPart/' . $deleteData->foto_ke_empat));
        $deleteData->delete();
        return redirect()->route('areaPart.katalog', ['id' => $partArea->id]);
    }

    public function katalogSearch(Request $request, $id)
    {
        $partArea = PartArea::find($id);
        $part = Part::find($partArea->part_id);
        $model = ModelPart::find($part->model_part_id);
        if (Auth::user()->hasRole('Guest')) {
            $AreaParts = AreaPart::where('part_area_id', $id)
                ->whereNotNull('sec_head_approval_date')
                ->where('name', 'LIKE', "%$request->searchKatalog%")
                ->simplePaginate();
        } else {
            $AreaParts = AreaPart::where('part_area_id', $id)
                ->where('name', 'LIKE', "%$request->searchKatalog%")
                ->simplePaginate();
        }
        return response()->view('areaPart.katalog', compact('part', 'partArea', 'model', 'AreaParts'));
    }
}
