<?php

namespace App\Http\Controllers;

use App\Models\ModelPart;
use App\Models\Part;
use Illuminate\Http\Request;

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
        $model = ModelPart::find($id);

        // Validasi file yang diunggah
        $request->validate([
            'name' => 'required',
            'foto_part' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        // Ambil file yang diunggah
        $image = $request->file('foto_part');

        // Buat nama unik untuk file
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Pindahkan file ke direktori public/img/part
        $image->move(public_path('img/part'), $imageName);
        Part::create([
            'name' => $request->name,
            'foto_part' => $imageName,
            'model_part_id' => $id,
        ]);

        return redirect()->route('part.index');
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
    public function edit(Part $part)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part)
    {
        //
    }
}
