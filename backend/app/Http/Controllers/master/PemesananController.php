<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Jadwal;
use App\Models\Kota;
use App\Models\Rute;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;

class PemesananController extends Controller
{
    public function getKota()
    {
        $kota = Kota::select('uuid','is_active','nama_kota')
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

    public function getListJadwal(Request $request)
    {
        $keberangkatan = $request->input('keberangkatan');
        $tujuan = $request->input('tujuan');
        $tglKeberangkatan = $request->input('tgl_keberangkatan');

        if (empty($keberangkatan) || empty($tujuan)) {
            return response()->json(['message' => 'Kota keberangkatan dan tujuan wajib diisi'], 400);
        }

        $jadwal = Jadwal::whereHas('rute', function ($query) use ($keberangkatan, $tujuan) {
            $query->where('keberangkatan', $keberangkatan)
                  ->where('tujuan', $tujuan);
        })
        ->whereDate('tgl_keberangkatan', $tglKeberangkatan)
        ->with(['rute.kotaKeberangkatan', 'rute.kotaTujuan'])
        ->get()
        ->map(function ($item) {
            return [
                'norec_jadwal' => $item->uuid,
                'keberangkatan' => $item->rute->kotaKeberangkatan->nama_kota ?? 'Data tidak ditemukan',
                'tujuan' => $item->rute->kotaTujuan->nama_kota ?? 'Data tidak ditemukan',
                'tgl_keberangkatan' => $item->tgl_keberangkatan,
                'harga' => $item->harga,
                'kuota' => $item->kuota,
            ];
        });

        if ($jadwal->isEmpty()) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => ['jadwal' => $jadwal],
            'message' => 'success'
        ]);
    }

    public function pesanTiket(Request $request)
    {
        $jadwal = $request->input('jadwal');
        $jumlah_pesan = $request->input('jumlah_pesan');

        $jadwal = Jadwal::where('uuid', $jadwal)->first();
        if ($jadwal->kuota < $jumlah_pesan) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota tidak mencukupi.',
            ], Response::HTTP_BAD_REQUEST);
        }


        $total_harga = $jumlah_pesan * $jadwal->harga;
        $pemesanan = Pemesanan::create([
            'jumlah_pesan' => $jumlah_pesan,
            'total_harga' => $total_harga,
            'tgl_order' => now(),
            'id_jadwal' => $jadwal->uuid,
            'id_user' => auth()->user()->uuid,
        ]);

            $getLastID =  Pemesanan::max('id');
            $pemesananId = Pemesanan::select('uuid')
            ->where('id', $getLastID)
            ->where('id_user', auth()->user()->uuid)->first();

            $validated = $request->validate([
                'penumpang' => 'required|array|min:1',
                'penumpang.*.nama' => 'required|string',
                'penumpang.*.no_identitas' => 'required|string',
            ]);
            foreach ($validated['penumpang'] as $dataPenumpang) {
                PemesananDetail::create([
                    'nama_penumpang' => $dataPenumpang['nama'],
                    'no_identitas' => $dataPenumpang['no_identitas'],
                    'id_pemesanan' => $pemesananId->uuid
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Pemesanan berhasil!',
                'data' => $pemesanan
            ], Response::HTTP_OK);

    }
}
