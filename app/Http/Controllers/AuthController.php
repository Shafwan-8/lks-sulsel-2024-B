<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request) {

        try{

            $tervalidasi = $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required'
            ]);
        }
        catch (ValidationException $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $e->errors(),
            ], 201);
        }
        
        $user = User::where('email', $tervalidasi['email'])->first();

        if (Auth::attempt($tervalidasi)) {

            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'success login!',
                'data' => $tervalidasi,
                'token' => $token
            ], 200);

        }else {
            return response()->json([
                'status' => false,
                'message' => 'email or password does not match our record',
                'data' => null,
                'token' => null
            ], 201);
        }

    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Success Logout'
        ], 200);
    }
}
