<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();

        if(count($mahasiswa)>0) {
            return response()->json([
                'success' => true,
                'message' => 'Retrieve All Success',
                'mahasiswa' => $mahasiswa
            ], 200);
        }

        return response()->json([
            'message' => 'Retrieve All Empty',
            'mahasiswa' => null
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
            'npm' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $mahasiswa = new Mahasiswa();
        $mahasiswa->mahasiswa_name = $request["name"];
        $mahasiswa->npm = $request["npm"];
        $mahasiswa->email_mahasiswa = $request["email"];
        $mahasiswa->password_mahasiswa = $request["password"];

        if ($mahasiswa->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Add Mahasiswa Success!',
                'mahasiswa' => $mahasiswa,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Add Mahasiswa Failed!',
                'mahasiswa' => $mahasiswa,
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return response()->json([
            'success' => true,
            'message' => 'Retrieve Mahasiswa Success',
            'mahasiswa' => $mahasiswa
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'name' => ['required'],
            'npm' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $mahasiswa = new Mahasiswa();
        $mahasiswa->mahasiswa_name = $request["name"];
        $mahasiswa->npm = $request["npm"];
        $mahasiswa->email_mahasiswa = $request["email"];
        $mahasiswa->password_mahasiswa = $request["password"];
        
        if ($mahasiswa->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Update Mahasiswa Success!',
                'mahasiswa' => $mahasiswa,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update Mahasiswa Failed!',
                'mahasiswa' => $mahasiswa,
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
