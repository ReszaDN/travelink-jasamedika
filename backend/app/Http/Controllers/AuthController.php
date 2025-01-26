<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Customer;
use DB;


class AuthController extends Controller
{

    //----------REGISTER----------//
//     /**
//  * @OA\Get(
//  *     path="/api/register",
//  *     summary="Show All Pekerjaan",
//  *     @OA\Response(response=200, description="Successful response")
//  * )
//  */
    public function register(Request $request)
    {
         // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);


        //simpan user baru
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hashing password
        ]);

        $getLastID =  User::max('id');
            $userUuid = User::where('id', $getLastID)->value('uuid');

        $validatedDataCus = $request->validate([
            'nama' => 'required|string|max:255',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
        ]);

        Customer::create([
            "nama"=>$validatedDataCus['nama'],
            "tgl_lahir"=>$validatedDataCus['tgl_lahir'],
            'jenis_kelamin'=>$validatedDataCus['jenis_kelamin'],
            'alamat'=>$validatedDataCus['alamat'],
            'id_user'=>$userUuid
        ]);

        return response()->json(['message' => 'User registered successfully!']);
    }


    //----------LOGIN----------//
/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="User login",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="rano@gmail.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLC..."),
 *             @OA\Property(property="token_type", type="string", example="Bearer")
 *         )
 *     ),
 *
 * )
 */


    public function login (Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Dapatkan uuid berdasarkan relasi
            $uuid = null;

            if ($user->pegawai) {
                $uuid = $user->pegawai->uuid;
                $userType = 'pegawai'; // Menandakan tipe user adalah pegawai
            }
        
            // Cek apakah user adalah customer
            if ($user->customer) {
                $uuid = $user->customer->uuid;
                $userType = 'customer';
            }

            // Jika uuid ditemukan, buat token dengan uuid
            $token = $user->createToken('YourApp', ['*'])->plainTextToken;

            return response()->json([
                'token' => $token,
                'uuid' => $uuid,
                'user_type' => $userType,
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

  //----------LOGOUT----------//

  /**
 * @OA\Post(
 *     path="/api/logout",
 *     summary="Logout user",
 *     tags={"Authentication"},
 *     security={{"sanctum": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Logged out successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Logged out successfully")
 *         )
 *     )
 * )
 */

public function logout(Request $request)
{
    // Revoke the user's current token
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out successfully']);
}

  //----------LOGOUT SEMUA PERANGKAT----------//

// public function logout(Request $request)
// {
//     // Revoke all tokens for the authenticated user
//     $request->user()->tokens()->delete();

//     return response()->json(['message' => 'Logged out from all devices successfully']);
// }

}
