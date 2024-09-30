<?php

namespace App\Http\Controllers;

use App\Models\ModelPart;
use App\Models\Part;
use App\Models\PartArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use File;
class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $parts = Part::where('model_part_id', $id)->simplePaginate(4);
        $model = ModelPart::find($id);
        return response()->view('part.index', compact('parts', 'model'));
    }

    public function search(Request $request, $id)
    {
        $parts = Part::where('name', 'LIKE', "%$request->searchPart%")->simplePaginate(4);
        $model = ModelPart::find($id);

        return view('part.index', compact('parts', 'model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $model = ModelPart::find($id);
        return response()->view('part.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        // Temukan model berdasarkan ID
        $model = ModelPart::find($id);

        // Validasi file yang diunggah
        $request->validate([
            'name' => 'required',
            'foto_part' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        // Ambil file yang diunggah
        $image = $request->file('foto_part');

        // Membaca gambar
        $originalImage = Image::make($image);
        // Periksa tinggi dan lebar gambar
        if ($originalImage->height() > $originalImage->width()) {
            // Rotate gambar 90 derajat jika tinggi lebih besar dari lebar
            $originalImage->rotate(90);
        }

        // Buat nama unik untuk file
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Simpan gambar yang sudah diproses ke direktori public/img/part
        $originalImage->save(public_path('img/part/' . $imageName), 90);

        // Simpan data part ke database
        Part::create([
            'name' => $request->name,
            'foto_part' => $imageName,
            'model_part_id' => $id,
        ]);

        return redirect()->route('part.index',['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function edit(Part $part,$id)
    {
        $part = Part::find($id);
        $model = ModelPart::find(($part->model_part_id));
        return response()->view('part.edit', compact('part','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part,$id)
    {
        $oldPart = Part::find($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'foto_part' => 'required'
        ]);

        //Membuat Nama gambar Baru dan Memasukan gambar baru
        $image = $request->file('foto_part');

        // Membaca gambar
        $originalImage = Image::make($image);

         // Periksa tinggi dan lebar gambar
         if ($originalImage->height() > $originalImage->width()) {
            // Rotate gambar 90 derajat jika tinggi lebih besar dari lebar
            $originalImage->rotate(90);
        }

        $imageName = time().'.'.$image->getClientOriginalExtension();
        $originalImage->save(public_path('img/part/' . $imageName), 90);
        $validatedData['foto_part'] = $imageName;
        // Ambil gambar lama dari database
        $oldImage = $oldPart->foto_part;

        // Hapus gambar lama dari direktori jika ada
        if ($oldImage && file_exists(public_path('img/part/' . $oldImage))) {
            unlink(public_path('img/part/' . $oldImage));
        }
        $oldPart->update($validatedData);
        $id = $oldPart->model_part_id;
        return redirect()->route('part.index',compact('id'));
    }

    public function kelola(Request $request,$id)
    {
        $part = Part::find($id);
        $model = ModelPart::find($part->model_part_id);
        return view('part.partArea',compact('part','model'));
    }

    public function kelolaStore(Request $request,$id)
    {
        $count = $request->countArea;
        $begin = 1;

        if($count == null){
            return back();
        }

        for($i = 1; $i <= $count; $i++){
            if($request->{'nameArea'.$i} != null){
                $data = [];
                $data['nameArea'] = $request->{'nameArea'.$i};
                $data['part_id'] = $id;
                $data['koordinat_y'] = $request->{'koordinat_y'.$i};
                $data['koordinat_x'] = $request->{'koordinat_x'.$i};
                PartArea::create($data);
            }
        };


        return redirect()->route('areaPart.index',['id' => $id]);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Temukan data Part berdasarkan ID
        $part = Part::find($id);
        $modelPart = ModelPart::find($part->model_part_id);

        // Cek apakah Part ditemukan
        if (!$part) {
            return redirect()->route('part.index',["id" => $modelPart->id ])->with('error', 'Part tidak ditemukan!');
        }
        // Hapus file gambar jika ada
        $oldImage = $part->foto_part;
        $imagePath = public_path('img/part/' . $oldImage);

        if (file_exists($imagePath)) {
            unlink($imagePath); // Menghapus file gambar
        }

        // Hapus data dari database
        $part->delete();

        return redirect()->route('part.index',["id" => $modelPart->id ])->with('success', 'Part berhasil dihapus!');
    }
}
