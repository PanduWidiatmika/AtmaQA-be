<?php

namespace App\Http\Controllers;

use App\Models\MatKul;
use Illuminate\Http\Request;

class MatKulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matkul = MatKul::all();

        if(count($matkul)>0) {
            return response()->json([
                'success' => true,
                'message' => 'Retrieve All Success',
                'matkul' => $matkul
            ], 200);
        }

        return response()->json([
            'message' => 'Retrieve All Empty',
            'matkul' => null
        ], 204);
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
            'name' => ['required'],
            'dosen_id' => ['required'],
        ]);

        $matkul = new MatKul();
        $matkul->matkul_name = $request["name"];
        $matkul->dosen_id = $request["dosen_id"];

        if ($matkul->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Add Mata Kuliah Success!',
                'matkul' => $matkul,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Add Mata Kuliah Failed!',
                'matkul' => $matkul,
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show(MatKul $matkul)
    {
        return response()->json([
            'success' => true,
            'message' => 'Retrieve Mata Kuliah Success',
            'matkul' => $matkul
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MatKul $matkul)
    {
        $request->validate([
            'name' => ['required'],
            'dosen_id' => ['required'],
        ]);

        $matkul->matkul_name = $request["name"];
        $matkul->dosen_id = $request["dosen_id"];
        
        if ($matkul->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Update Mata Kuliah Success!',
                'matkul' => $matkul,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update Mata Kuliah Failed!',
                'matkul' => $matkul,
            ], 400);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosen $dosen)
    {
        //
    }
}
