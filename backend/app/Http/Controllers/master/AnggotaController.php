<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModelAnggota;
use Illuminate\Http\Response;



class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all records with optional pagination
        // $data = YourModel::paginate(10); // Ganti dengan kebutuhan Anda

        $anggota = ModelAnggota::all();
        $data = [
            "data" =>$anggota,
            "message" => 'success'
        ];
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
           'uuid' => 'required|uuid',
            'is_active' => 'boolean',
            'namalengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'email' => 'required|email|unique:anggota_tm,email',
            'no_anggota' => 'required|integer',
            'no_tlp' => 'required|string',
            'kontak_darurat' => 'required|string',
            'uuid_kontak_darurat' => 'required|uuid',
            'alamat_ktp' => 'required|string',
            'alamat_domisili' => 'required|string',
            'uuid_agama' => 'required|uuid',
            'uuid_golongan_darah' => 'required|uuid',
            'uuid_pekerjaan' => 'required|uuid',
            'uuid_pendidikan' => 'required|uuid',
            'uuid_chapter' => 'required|uuid',
        ]);

        // Create a new record
        $anggota = ModelAnggota::create($validated);

        return response()->json([
            'success' => true,
            'data' => $anggota
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $anggota = ModelAnggota::findOrFail($id);
        // Return a single record
        return response()->json([
            'success' => true,
            'data' => $yourModel
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
             'uuid' => 'sometimes|uuid',
            'is_active' => 'boolean',
            'namalengkap' => 'sometimes|string|max:255',
            'tempat_lahir' => 'sometimes|string|max:255',
            'tgl_lahir' => 'sometimes|date',
            'email' => 'sometimes|email|unique:anggota_tm,email,' . $id,
            'no_anggota' => 'sometimes|integer',
            'no_tlp' => 'sometimes|string',
            'kontak_darurat' => 'sometimes|string',
            'uuid_kontak_darurat' => 'sometimes|uuid',
            'alamat_ktp' => 'sometimes|string',
            'alamat_domisili' => 'sometimes|string',
            'uuid_agama' => 'sometimes|uuid',
            'uuid_golongan_darah' => 'sometimes|uuid',
            'uuid_pekerjaan' => 'sometimes|uuid',
            'uuid_pendidikan' => 'sometimes|uuid',
            'uuid_chapter' => 'sometimes|uuid',
        ]);

        // Update the record
        $anggota = ModelAnggota::findOrFails($id);
        $anggota -> update($validated);

        return response()->json([
            'success' => true,
            'data' => $yourModel
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete the record
        $anggota = ModelAnggota::findOrFail($id);
        $anggota->delete();

        return response()->json([
            'success' => true,
            'message' => 'Record deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }
}
