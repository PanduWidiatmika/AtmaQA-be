<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::all();

        if(count($kelas)>0) {
            return response()->json([
                'success' => true,
                'message' => 'Retrieve All Success',
                'kelas' => $kelas
            ], 200);
        }

        return response()->json([
            'message' => 'Retrieve All Empty',
            'kelas' => null
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
            'hari' => ['required'],
            'sesi'=> ['required'],
            'matkul_id' => ['required'],
        ]);
        $kelas = new Kelas();
        $kelas->kelas_name = $request["name"];
        $kelas->hari = $request["hari"];
        $kelas->sesi = $request["sesi"];
        $kelas->matkul_id = $request["matkul_id"];

        if ($kelas->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Add Kelas Success!',
                'kelas' => $kelas,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Add Kelas Failed!',
                'kelas' => $kelas,
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        return response()->json([
            'success' => true,
            'message' => 'Retrieve Kelas Success',
            'kelas' => $kelas
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'name' => ['required'],
            'hari' => ['required'],
            'sesi'=> ['required'],
            'matkul_id' => ['required'],
        ]);

        $kelas->kelas_name = $request["name"];
        $kelas->hari = $request["hari"];
        $kelas->sesi = $request["sesi"];
        $kelas->matkul_id = $request["matkul_id"];
        
        if ($kelas->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Update Kelas Success!',
                'kelas' => $kelas,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update Kelas Failed!',
                'kelas' => $kelas,
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
