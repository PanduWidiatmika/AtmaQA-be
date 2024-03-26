<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $dosens = Dosen::all()->where('status','aktif');

        $dosens = DB::table('dosen')
                    ->select('*')
                    ->where('status','aktif')
                    ->get();

        if(count($dosens)>0) {
            return response()->json([
                'success' => true,
                'message' => 'Retrieve All Success',
                'dosen' => $dosens
            ], 200);
        }

        return response()->json([
            'message' => 'Retrieve All Empty',
            'dosens' => null
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
        $dosen->password_dosen = Hash::make($request["password"]);
        $dosen->notelp_dosen = $request["notelp"];
        $dosen->status = 'aktif';

        if ($dosen->save()) {
            $user = new User();
            $user->email = $dosen->email_dosen;
            $user->password = $dosen->password_dosen;
            $user->mahasiswa_id = null;
            $user->dosen_id = $dosen->dosen_id;
            $user->status = $dosen->status;

            if ($user->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Add Dosen Success!',
                    'dosen' => $dosen,
                    'user' => $user,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Add Dosen Failed!',
                    'user' => $user,
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Add Dosen Failed!',
                'dosen' => $dosen,
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
            'dosen' => $dosen
        ], 200);
    }

    public function search(Request $request)
    {
        try{
            $dosen = DB::table('dosen')
                                ->select(
                                    'dosen_id',
                                    'dosen_name',
                                    'notelp_dosen'
                                )
                                ->where('dosen_name', 'LIKE', "$request->name%")
                                ->get();

            if(count($dosen)>0){
                return response()->json([
                    'success' => true,
                    'message' => 'Retrieve Dosen Success!',
                    'dosen' => $dosen,
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Retrieve Dosen Empty!',
                'dosen' => null,
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ], 401);
        }
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
            'name' => ['required'],
            'email' => ['required'],
            // 'password_dosen'=> ['required'],
            'notelp' => ['required'], //inget ganti
        ]);

        if($request['password'] === $dosen->password_dosen){
            $user = $dosen->user;
            $dosen->dosen_name = $request["name"];
            $dosen->email_dosen = $request["email"];
            $dosen->password_dosen = $dosen->password_dosen;
            $dosen->notelp_dosen = $request["notelp"];
            
            if ($dosen->save()) {
                $user->email = $dosen->email_dosen;
                $user->password = $dosen->password_dosen;
                $user->mahasiswa_id = null;
                $user->dosen_id = $dosen->dosen_id;
    
                if ($user->save()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Update Dosen Success!',
                        'dosen' => $dosen,
                        'user' => $user,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Update Dosen Failed!',
                        'user' => $user,
                    ], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Update Dosen Failed!',
                    // 'mahasiswa' => $mahasiswa,
                ], 400);
            }
        } else {
            $dosen->dosen_name = $request["name"];
            $dosen->email_dosen = $request["email"];
            $dosen->password_dosen = Hash::make($request["password"]);
            $dosen->notelp_dosen = $request["notelp"];

            if ($dosen->save()) {
                $user = $dosen->user;
                $user->email = $dosen->email_dosen;
                $user->password = $dosen->password_dosen;
                $user->mahasiswa_id = null;
                $user->dosen_id = $dosen->dosen_id;
    
                if ($user->save()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Update Dosen Success!',
                        'dosen' => $dosen,
                        'user' => $user,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Update Dosen Failed!',
                        'user' => $user,
                    ], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Update Dosen Failed!',
                    // 'mahasiswa' => $mahasiswa,
                ], 400);
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosen $dosen, Request $request)
    {
        try{
            DB::table('dosen')
                ->where('dosen_id',$request->id)
                ->update([
                    'status'=>'nonaktif',
                ]);

            // DB::table('users')->where('dosen_id',$request->id)->delete();

            return response() -> json([
                'success' => true,
                'message' => `Dosen Deleted!`
            ],200);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Delete Dosen Failed!'
            ]);
        }
    }
}
