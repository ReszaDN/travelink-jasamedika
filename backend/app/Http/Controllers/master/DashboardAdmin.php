<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Jadwal;
use App\Models\Kota;
use App\Models\Rute;
use App\Models\Kendaraan;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;

class DashboardAdmin extends Controller
{

    public function addkota(Request $request)
    {

        $validatedData = $request->validate([
           "nama_kota"=>'required'
        ]);

        try{
            $data = Kota::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Kota created successfully!',
                'data' => $data
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Kota.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getKota()
    {
        $kota = Kota::select('uuid','is_active','nama_kota')
        ->where('is_active', true)
        ->get();

        $data = [
            "kota" =>$kota,
            "message" => 'success'
        ];
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function deleteKota(Request $request)
    {
        $kota = $request->input('uuid');

        $updateData['is_active'] = false;
        Kota::where('uuid', $kota)->update($updateData);

    }
   
    public function addRute(Request $request)
    {
        $validatedData = $request->validate([
           "keberangkatan"=>'required',
           "tujuan"=>'required'
        ]);

        try{
            $data = Rute::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Rute created successfully!',
                'data' => $data
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Rute.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRute()
    {
        $rute = Rute::with(['kotaKeberangkatan','kotaTujuan'])
        ->where('is_active', true)
        ->get()
        ->map(function ($item) {
            return [
                'norec_rute' => $item->uuid,
                'keberangkatan' => $item->kotaKeberangkatan->nama_kota,
                'tujuan' => $item->kotaTujuan->nama_kota,
                'ruteTujuan' => $item->kotaKeberangkatan->nama_kota . "->" . $item->kotaTujuan->nama_kota,
            ];
        });

        $data = [
            "rute" =>$rute,
            "message" => 'success'
        ];
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function deleteRute(Request $request)
    {
        $rute = $request->input('uuid');

        $updateData['is_active'] = false;
        Rute::where('uuid', $rute)->update($updateData);

    }
    
    public function addKendaraan(Request $request)
    {
        $validatedData = $request->validate([
            "kode_kendaraan"=>'required',
            "no_kendaraan"=>'required',
         ]);
 
         try{
             $data = Kendaraan::create($validatedData);
 
             return response()->json([
                 'success' => true,
                 'message' => 'Kendaraan created successfully!',
                 'data' => $data
             ], Response::HTTP_CREATED);
         } catch (\Exception $e) {
             // Tangkap error jika ada
             return response()->json([
                 'success' => false,
                 'message' => 'Failed to create Kendaraan.',
                 'error' => $e->getMessage()
             ], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
    }


    public function getKendaraan()
    {
        $kendaraan = Kendaraan::select('uuid','kode_kendaraan','no_kendaraan')
        ->where('is_active', true)
        ->get();

        $data = [
            "kendaraan" =>$kendaraan,
            "message" => 'success'
        ];
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }
    
    public function deleteKendaraan(Request $request)
    {
        $kendaraan = $request->input('uuid');

        $updateData['is_active'] = false;
        Kendaraan::where('uuid', $kendaraan)->update($updateData);

    }

    public function addJadwalKeberangkatan(Request $request)
    {
        $validatedData = $request->validate([
            "tgl_keberangkatan"=>'required',
            "harga"=>'required',
            "kuota"=>'required',
            "id_rute"=>'required',
            "id_kendaraan"=>'required',
         ]);
 
         try{
             $data = Jadwal::create($validatedData);
 
             return response()->json([
                 'success' => true,
                 'message' => 'Jadwal created successfully!',
                 'data' => $data
             ], Response::HTTP_CREATED);
         } catch (\Exception $e) {
             return response()->json([
                 'success' => false,
                 'message' => 'Failed to create Jadwal.',
                 'error' => $e->getMessage()
             ], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
    }

    public function getJadwalKeberangkatan()
    {

        $jadwal = Jadwal::select('uuid', 'tgl_keberangkatan', 'harga', 'kuota', 'id_rute', 'id_kendaraan')
            ->with(['rute.kotaKeberangkatan', 'rute.kotaTujuan'])
            ->with(['kendaraan'])
            ->where('is_active', true)
            ->get()
            ->map(function ($item) {
                return [
                    'norec_jadwal' => $item->uuid,
                    'tgl_keberangkatan' => $item->tgl_keberangkatan,
                    'harga' => $item->harga,
                    'kuota' => $item->kuota,
                    'kode_kendaraan' => $item->kendaraan->kode_kendaraan,
                    'no_kendaraan' => $item->kendaraan->no_kendaraan,
                    'rute' => $item->rute->kotaKeberangkatan->nama_kota . " -> " . $item->rute->kotaTujuan->nama_kota ?? 'Data tidak ditemukan',
                ];
            });


        $data = [
            "jadwal" =>$jadwal,
            "message" => 'success'
        ];
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function deleteJadwal(Request $request)
    {
        $jadwal = $request->input('uuid');

        $updateData['is_active'] = false;
        Jadwal::where('uuid', $jadwal)->update($updateData);

    }

    public function getDataPesanan()
    {
        $pesanan = Pemesanan::select('uuid','jumlah_pesan', 'total_harga', 'tgl_order', 'status', 'id_jadwal')
        ->with([
            'jadwal.rute.kotaKeberangkatan', 
            'jadwal.rute.kotaTujuan', 
            'jadwal.kendaraan', 
        ])
        ->where('status', 'pending')
        ->where('is_active', true)
        ->get()
        ->map(function ($item) {
            return [
                'norec_pemesanan' => $item->uuid,
                'keberangkatan' => $item->jadwal->rute->kotaKeberangkatan->nama_kota,
                'tujuan' => $item->jadwal->rute->kotaTujuan->nama_kota,
                'tgl_keberangkatan' => $item->jadwal->tgl_keberangkatan,
                'kendaraan' => $item->jadwal->kendaraan->kode_kendaraan,
                'jumlah_pesanan' => $item->jumlah_pesan,
                'total_harga' => $item->total_harga,
                'tgl_order' => $item->tgl_order,
                'status' => $item->status,
            ];
        });

        $data = [
            "pemesanan" =>$pesanan,
            "message" => 'success'
        ];
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function updateStatusBayar(Request $request)
    {
        $pemesanan = $request->input('pemesanan');

        $dataPesanan = Pemesanan::with(['jadwal'])
                                  ->where('uuid', $pemesanan)->first();

        if ($dataPesanan->jadwal->kuota < $dataPesanan->jumlah_pesan) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota tidak mencukupi.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $updateData['status'] = "confirmed";
        Pemesanan::where('uuid', $pemesanan)->update($updateData);

        $updateKuota['kuota'] = $dataPesanan->jadwal->kuota - $dataPesanan->jumlah_pesan;
        Jadwal::where('uuid', $dataPesanan->id_jadwal)->update($updateKuota);

    }
}
