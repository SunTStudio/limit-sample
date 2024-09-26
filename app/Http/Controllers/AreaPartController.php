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
        $part = Part::find($id);
        return response()->view('areaPart.create', compact('part'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
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
            $image->move(public_path('img/part'), $imageName);
            $validatedData['foto_ke_satu'] = $imageName; // Simpan nama file untuk database
        }

        if ($request->hasFile('foto_ke_dua')) {
            $image = $request->file('foto_ke_dua');
            $imageName = time() . '_dua.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/part'), $imageName);
            $validatedData['foto_ke_dua'] = $imageName; // Simpan nama file untuk database
        }

        if ($request->hasFile('foto_ke_tiga')) {
            $image = $request->file('foto_ke_tiga');
            $imageName = time() . '_tiga.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/part'), $imageName);
            $validatedData['foto_ke_tiga'] = $imageName; // Simpan nama file untuk database
        }

        if ($request->hasFile('foto_ke_empat')) {
            $image = $request->file('foto_ke_empat');
            $imageName = time() . '_empat.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/part'), $imageName);
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
    public function edit(AreaPart $areaPart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaPart  $areaPart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AreaPart $areaPart)
    {
        //
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
