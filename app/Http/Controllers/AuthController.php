<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only(['email','password']);

        
        if(Auth::attempt($credentials)) {
            $user = \Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            // return response()->json([
            //     'jamet' => $credentials
            // ]);

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json(['error' => 'Unauthenticated'],401);
    }

    public function logout(Request $request)
    {
        
        $request->user()->token()->revoke();
        $request->user()->token()->delete();

        return response()->json(['message' => 'Successfully Logged Out!']);
    }

}
