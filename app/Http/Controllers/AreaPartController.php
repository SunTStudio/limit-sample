<?php

namespace App\Http\Controllers;

use App\Models\AreaPart;
use App\Models\ModelPart;
use App\Models\Part;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $areaParts = AreaPart::where('part_id', $id)->get();
        return response()->view('areaPart.index', compact('part', 'areaParts', 'model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $areaParts = AreaPart::where('part_id', $id)->get();
        $part = Part::find($id);
        $model = ModelPart::find($part->model_part_id);
        return response()->view('areaPart.create', compact('part','areaParts','model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        dd($request->all());
        $part = Part::find($id);

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
            'koordinat_x' => 'required',
            'koordinat_y' => 'required',
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
        $validatedData['submit_date'] = Carbon::now();
        // Simpan data ke database
        AreaPart::create($validatedData);

        // Redirect atau return ke halaman lain dengan pesan sukses
        return redirect()->route('areaPart.index', ['id' => $validatedData['part_id']]);
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
    public function edit(AreaPart $areaPart,$id)
    {
        $areaPart = AreaPart::find($id);
        $part = Part::find($areaPart->part_id);
        $model = ModelPart::find($part->model_part_id);
        return response()->view('areaPart.edit', compact('part','areaPart','model'));
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
            'koordinat_x' => 'required',
            'koordinat_y' => 'required',
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
        $validatedData['submit_date'] = $oldAreaPart->submit_date;
        // Simpan data ke database
        $oldAreaPart->update($validatedData);

        // Redirect atau return ke halaman lain dengan pesan sukses
        return redirect()->route('areaPart.index', ['id' => $validatedData['part_id']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaPart  $areaPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(AreaPart $areaPart)
    {
        //
    }
}
