<?php

namespace App\Http\Controllers;

use App\Models\ManageAccess;
use App\Models\ModelPart;
use App\Models\Part;
use App\Models\PartArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use File;
use Yajra\DataTables\Facades\DataTables;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $secHead1 = ManageAccess::where('peran','Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran','Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran','Department Head')->first();
        //mengambil data part dengan paginasion per halaman 4
        $parts = Part::where('model_part_id', $id)->simplePaginate(4);
        //mengambil data model part bedasarkan id request
        $model = ModelPart::find($id);

        //melakukan pengecekan apabila pengakses adalah role Guest maka count pada model yang diakses bertambah++
        if(auth()->user()->id != $secHead1->user_id && auth()->user()->id != $secHead2->user_id && auth()->user()->id != $DeptHead->user_id){
            $count = $model->count_visit;
                        $count++;
                        $model->update([
                            'count_visit' => $count,
                        ]);
        }
        return response()->view('part.index', compact('secHead1','secHead2','DeptHead','parts', 'model'));
    }

    public function search(Request $request, $id)
    {
        if ($request->ajax()) {
            // Jika AJAX, ambil parameter pencarian
            $searchTerm = $request->input('query');
            // Lakukan pencarian
            $parts  = Part::where('name', 'LIKE', "%{$searchTerm}%")->get();

            // Kembalikan hasil pencarian dalam format JSON
            return response()->json($parts);
        } else {
            //mengambil seluruh data part bedasarkan model part id yang diakses
            $parts = Part::where('model_part_id', $id)
                ->where('name', 'LIKE', "%$request->searchPart%")
                ->simplePaginate(4);

            //mengambil model part bedasarkan parameter id yang dikirimkan
            $model = ModelPart::find($id);

            return view('part.index', compact('parts', 'model'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //mengambil data model bedasarkan id request
        $model = ModelPart::find($id);
        return response()->view('part.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
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

        return redirect()->route('part.index', ['id' => $id])->with('success','Part Berhasil Dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    // public function show(Part $part)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function edit(Part $part, $id)
    {
        //mengambil data part bedasarkan id request
        $part = Part::find($id);
        //mengambil data model part bedasarkan model part id dari data part
        $model = ModelPart::find($part->model_part_id);
        return response()->view('part.edit', compact('part', 'model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part, $id)
    {
        //mengambil data part lama bedasarkan id request
        $oldPart = Part::find($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'foto_part' => 'required',
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

        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $originalImage->save(public_path('img/part/' . $imageName), 90);
        $validatedData['foto_part'] = $imageName;
        // Ambil gambar lama dari database
        $oldImage = $oldPart->foto_part;

        // Hapus gambar lama dari direktori jika ada
        if ($oldImage && file_exists(public_path('img/part/' . $oldImage))) {
            unlink(public_path('img/part/' . $oldImage));
        }

        //update data part lama dengan data part baru
        $oldPart->update($validatedData);

        //menyimpan id model part untuk dikirim ke view part
        $id = $oldPart->model_part_id;

        return redirect()->route('part.index', compact('id'))->with('success','Part Berhasil diPerbarui!');
    }

    public function kelola(Request $request, $id)
    {
        //mengambil data part bedasarkan id request
        $part = Part::find($id);
        //mengambil data part area bedasarkan part_id
        $partAreas = PartArea::where('part_id', $id)->get();
        //mengambil data total part
        $partAreasCount = PartArea::where('part_id', $id)->count();
        //mengambil data model part bedasarkan model part id dari data part
        $model = ModelPart::find($part->model_part_id);
        return view('part.partArea', compact('part', 'model', 'partAreas', 'partAreasCount'));
    }

    public function kelolaStore(Request $request, $id)
    {
        $count = $request->countArea;

        if ($count == null) {
            return back();
        }

        //melalukan perulangan bedasarkan nilai count (nilai count adalah jumlah data yang dimasukan)
        for ($i = 1; $i <= $count; $i++) {
            if ($request->{'id' . $i} != null) {
                $oldData = PartArea::find($request->{'id' . $i});
                $data = [];
                $data['nameArea'] = $request->{'nameArea' . $i};
                $data['part_id'] = $id;
                $data['koordinat_y'] = $request->{'koordinat_y' . $i};
                $data['koordinat_x'] = $request->{'koordinat_x' . $i};
                $oldData->update($data);
            } elseif ($request->{'idDel' . $i} != null) {
                $oldData = PartArea::find($request->{'idDel' . $i});
                $oldData->delete();
            } elseif ($request->{'nameArea' . $i} != null) {
                $data = [];
                $data['nameArea'] = $request->{'nameArea' . $i};
                $data['part_id'] = $id;
                $data['koordinat_y'] = $request->{'koordinat_y' . $i};
                $data['koordinat_x'] = $request->{'koordinat_x' . $i};
                PartArea::create($data);
            }
        }

        return redirect()->route('areaPart.index', ['id' => $id])->with('success','Katalog Area Part Berhasil diTambah!');
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
        //mengambil data model part bedasarkan model part id dari data part
        $modelPart = ModelPart::find($part->model_part_id);

        // Cek apakah Part ditemukan
        if (!$part) {
            return redirect()
                ->route('part.index', ['id' => $modelPart->id])
                ->with('error', 'Part tidak ditemukan!');
        }
        // Hapus file gambar jika ada
        $oldImage = $part->foto_part;
        $imagePath = public_path('img/part/' . $oldImage);

        if (file_exists($imagePath)) {
            unlink($imagePath); // Menghapus file gambar
        }

        // Hapus data dari database
        $part->delete();

        return redirect()
            ->route('part.index', ['id' => $modelPart->id])
            ->with('success', 'Part berhasil dihapus!');
    }

    public function listPart(Request $request,$id){
        //pengecekan apakah request adalah ajax
        if($request->ajax()){
            $data = Part::where('model_part_id',$id)->get();
            //return data ke datatables
            return DataTables::of($data)->make(true);
        }
    }
}
