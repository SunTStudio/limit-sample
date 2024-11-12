<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\ManageAccess;
use App\Models\ModelPart;
use App\Models\Part;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ModelPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secHead1 = ManageAccess::where('peran','Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran','Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran','Department Head')->first();
        //mengambil data model part
        $models = ModelPart::simplePaginate(8);


        return response()->view('model.index', compact('secHead1','secHead2','DeptHead','models'));
    }

    public function search(Request $request)
    {
        // Cek apakah request adalah AJAX
        if ($request->ajax()) {
            // Jika AJAX, ambil parameter pencarian
            $searchTerm = $request->input('query');
            // Lakukan pencarian dan ambil hasil data model partnya
            $models  = ModelPart::where('name', 'LIKE', "%{$searchTerm}%")->get();

            // Kembalikan hasil pencarian dalam format JSON
            return response()->json($models);
        } else {
            // Jika bukan AJAX (form submit biasa)
            $models = ModelPart::where('name', 'LIKE', "%$request->searchModel%")->simplePaginate(8);
            // Kembalikan view dengan hasil pencarian
            return view('model.index', compact('models'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('model.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'foto_model' => 'required|image',
        ]);

        //mengambil file foto model dari form create model part
        $image = $request->file('foto_model');

        //rename nama gambar dengan waktu upload gambar
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        //memindahkan file gambar ke path public/img/model dengan nama yang sudah direname sebelumnya
        $image->move(public_path('img/model'), $imageName);

        //memasukan data baru ke model part dengan data dari form create model
        ModelPart::create([
            'name' => $request->name,
            'foto_model' => $imageName,
        ]);

        return redirect()->route('model.index')->with('success','Model Berhasil Dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModelPart  $modelPart
     * @return \Illuminate\Http\Response
     */
    // public function show(ModelPart $modelPart)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModelPart  $modelPart
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelPart $modelPart, $id)
    {
        //mengambil data model part bedasarkan id
        $model = ModelPart::find($id);
        return response()->view('model.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModelPart  $modelPart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // mengambil data model lama
        $oldModel = ModelPart::find($id);

        $validatedData = $request->validate([
            'name' => 'required',
            'foto_model' => 'required',
        ]);

        //Membuat Nama gambar Baru dan Memasukan gambar baru
        $image = $request->file('foto_model');

        //merename nama file dengan waktu upload
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        //memindahkan file ke path public/img/model dengan nama yang sudah direname sebelumnya
        $image->move(public_path('img/model'), $imageName);

        $validatedData['foto_model'] = $imageName;
        // Ambil gambar lama dari database
        $oldImage = $oldModel->foto_model;

        // Hapus gambar lama dari direktori jika ada
        if ($oldImage && file_exists(public_path('img/model/' . $oldImage))) {
            unlink(public_path('img/model/' . $oldImage));
        }

        //update data model lama dengan data model baru dari form sebelumnya
        $oldModel->update($validatedData);

        return redirect()->route('model.index')->with('success','Model Berhasil diUpdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModelPart  $modelPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //mengambil data yang akan dihapus bedasarkan id request
        $deleteData = ModelPart::find($id);

        //pengecekan ketika foto model ada di folder public/img/model maka hapus file tersebut
        if (file_exists(public_path('img/model/' . $deleteData->foto_model))) {
            unlink(public_path('img/model/' . $deleteData->foto_model));
        }

        //hapus data
        $deleteData->delete();

        return redirect()->route('model.index')->with('success','Model Berhasil diHapus!');
    }

    public function listModel(Request $request){
        //pengecekan apakah request adalah ajax
        if($request->ajax()){
            //ambil data model part seluruhnya
            $data = ModelPart::all();
            //return data ke datatables
            return DataTables::of($data)->make(true);
        }
    }
}
