<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class jawabanController extends Controller
{
    //
    public function addJawaban(Request $request){
        try{
            $request->validate([
                'jawaban' => ['required'],
            ]);

            $list_jawaban = json_decode($request['jawaban'],true);

            foreach($list_jawaban as $jawaban){

                if($jawaban["pilihanA"] == null) {
                    DB::table('jawaban_mhs')
                        ->insert([
                            'pertanyaandsn_id' => $jawaban["id"],
                            'mahasiswa_id' => $request->id,
                            'jawaban' => $jawaban["jawaban"],
                        ]);
                }else{
                    $cekJawaban = DB::table('pertanyaan_dosen')
                                    ->select('jawaban_benar')
                                    ->where('pertanyaandsn_id', $jawaban["id"])
                                    ->first();

                    if($cekJawaban->jawaban_benar == $jawaban["jawaban"]){
                        DB::table('jawaban_mhs')
                        ->insert([
                            'pertanyaandsn_id' => $jawaban["id"],
                            'mahasiswa_id' => $request->id,
                            'jawaban' => $jawaban["jawaban"],
                            'score' => 100,
                        ]);
                    }else{
                        DB::table('jawaban_mhs')
                        ->insert([
                            'pertanyaandsn_id' => $jawaban["id"],
                            'mahasiswa_id' => $request->id,
                            'jawaban' => $jawaban["jawaban"],
                            'score' => 0,
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'Message' => 'Success!',
            ]);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ], 401);
        }
        // DB::table('jawaban_mhs')
        //     ->insert()
    }

    public function pernahJawab(Request $request){
        $cekAns = DB::table('jawaban_mhs as jm')
                    ->join('pertanyaan_dosen as pd','jm.pertanyaandsn_id','=','pd.pertanyaandsn_id')
                    ->select('jm.pertanyaandsn_id','jm.mahasiswa_id')
                    ->where('pd.minggukelas_id',$request->id)
                    ->where('jm.mahasiswa_id',$request->mid)
                    ->count();

        if($cekAns>0){
            return response()->json([
                'success' => false
            ]);
        }else{
            return response()->json([
                'success' => true
            ]);
        }
    }

    public function cekPernahJawab(Request $request){
        $cekAns = DB::table('jawaban_mhs as jm')
                    ->join('pertanyaan_dosen as pd','jm.pertanyaandsn_id','=','pd.pertanyaandsn_id')
                    ->select('jm.pertanyaandsn_id','jm.mahasiswa_id')
                    ->where('pd.minggukelas_id',$request->id)
                    ->count();

        if($cekAns>0){
            return response()->json([
                'success' => false
            ]);
        }else{
            return response()->json([
                'success' => true
            ]);
        }
    }

    public function nilaiJawaban(Request $request){
        $nilai = DB::table('jawaban_mhs as jm')
                    ->join('pertanyaan_dosen as pd','jm.pertanyaandsn_id','=','pd.pertanyaandsn_id')
                    ->select('jm.*','pd.*')
                    ->where('pd.minggukelas_id',$request->id)
                    ->where('jm.mahasiswa_id',$request->mid)
                    ->count();

        $sumNilai = DB::table('jawaban_mhs as jm')
                        ->join('pertanyaan_dosen as pd','jm.pertanyaandsn_id','=','pd.pertanyaandsn_id')
                        ->where('pd.minggukelas_id',$request->id)
                        ->where('jm.mahasiswa_id',$request->mid)
                        ->where('jm.score',"!=", 0)
                        ->sum('jm.score');

        if($nilai>0){
            $realnilai = DB::table('jawaban_mhs as jm')
                            ->join('pertanyaan_dosen as pd','jm.pertanyaandsn_id','=','pd.pertanyaandsn_id')
                            ->select('jm.*','pd.*')
                            ->where('pd.minggukelas_id',$request->id)
                            ->where('jm.mahasiswa_id',$request->mid)
                            ->get();

            $npm = DB::table('mahasiswa')
                        ->select('npm')
                        ->where('mahasiswa_id',$request->mid)
                        ->first();

            $sum = $sumNilai/$nilai;

            return response()->json([
                'success' => true,
                'nilai' => $realnilai,
                'sum' => $sum,
                'npm' => $npm,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'nilai' => null,
            ]);
        }
        
    }

    public function koreksiJawaban(Request $request){
        try{
            $request->validate([
                'quiz' => ['required'],
            ]);
    
            $list_quiz = json_decode($request['quiz'],true);
    
            foreach($list_quiz as $quiz){
                DB::table('jawaban_mhs')
                    ->where('pertanyaandsn_id',$quiz['id'])
                    ->where('mahasiswa_id',$request->id)
                    ->update([
                        'score' => $quiz['score'],
                        'saran_dosen' => $quiz['saran'],
                    ]);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Update Score Success!',
            ]);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message'=>$e->getMessage()
            ], 401);
        }
    }
}
