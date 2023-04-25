<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosens = Dosen::all();

        if(count($dosens)>0) {
            return response()->json([
                'success' => true,
                'message' => 'Retrieve All Success',
                'dosens' => $dosens
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
            'email' => ['required'],
            'password'=> ['required'],
            'notelp' => ['required'],
        ]);
        $dosen = new Dosen();
        $dosen->dosen_name = $request["name"];
        $dosen->email_dosen = $request["email"];
        $dosen->password_dosen = $request["password"];
        $dosen->notelp_dosen = $request["notelp"];

        if ($dosen->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Add Dosen Success!'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Add Dosen Failed!'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show(Dosen $dosen)
    {
        return response()->json([
            'success' => true,
            'message' => 'Retrieve Dosen Success',
            'dosens' => $dosen
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'dosen_name' => ['required'],
            'email_dosen' => ['required'],
            'password_dosen'=> ['required'],
            'notelp_dosen' => ['required'], //inget ganti
        ]);

        $dosen->dosen_name = $request["dosen_name"];
        $dosen->email_dosen = $request["email_dosen"];
        $dosen->password_dosen = $request["password_dosen"];
        $dosen->notelp_dosen = $request["notelp_dosen"];
        
        if ($dosen->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Update Dosen Success!',
                'dosen' => $dosen,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update Dosen Failed!',
                'dosen' => $dosen,
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
