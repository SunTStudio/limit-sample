<?php

namespace App\Http\Controllers;

use App\Models\Guest;
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

        $models = ModelPart::simplePaginate(8);


        return response()->view('model.index', compact('models'));
    }

    public function search(Request $request)
    {
        // Cek apakah request adalah AJAX
        if ($request->ajax()) {
            // Jika AJAX, ambil parameter pencarian
            $searchTerm = $request->input('query');
            // Lakukan pencarian
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

        $image = $request->file('foto_model');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('img/model'), $imageName);

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
        $oldModel = ModelPart::find($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'foto_model' => 'required',
        ]);

        //Membuat Nama gambar Baru dan Memasukan gambar baru
        $image = $request->file('foto_model');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('img/model'), $imageName);
        $validatedData['foto_model'] = $imageName;
        // Ambil gambar lama dari database
        $oldImage = $oldModel->foto_model;

        // Hapus gambar lama dari direktori jika ada
        if ($oldImage && file_exists(public_path('img/model/' . $oldImage))) {
            unlink(public_path('img/model/' . $oldImage));
        }
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
        $deleteData = ModelPart::find($id);
        if (file_exists(public_path('img/model/' . $deleteData->foto_model))) {
            unlink(public_path('img/model/' . $deleteData->foto_model));
        }
        $deleteData->delete();
        return redirect()->route('model.index')->with('success','Model Berhasil diHapus!');
    }

    public function listModel(Request $request){
        if($request->ajax()){
            $data = ModelPart::all();
            return DataTables::of($data)->make(true);
        }
    }
}
