<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckUserType
{
    public function handle(Request $request, Closure $next)
    {
        // Mendapatkan user berdasarkan token
        $user = auth()->user();
        $uuid = $user->uuid;  // Ambil UUID dari user yang sedang login

        // Cek apakah uuid terdaftar di customer_mt
        $customer = \App\Models\Customer::where('id_user', $uuid)->first();
        if ($customer) {
            $request->merge(['user_type' => 'customer']);
        }

        // Cek apakah uuid terdaftar di pegawai_mt
        $pegawai = \App\Models\Pegawai::where('id_user', $uuid)->first();
        if ($pegawai) {
            $request->merge(['user_type' => 'pegawai']);
        }

        return $next($request);
    }
}
