<?php
namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModelEvent;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class MasterEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all records with optional pagination
        // $data = YourModel::paginate(10); // Ganti dengan kebutuhan Anda

        $event = ModelEvent::all();
        $data = [
            "event" =>$event,
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
        // Validasi data yang dikirim
        $request->validate([
            'title_event' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_start' => 'required|date',
            'tanggal_end' => 'required|date|after_or_equal:tanggal_start',
            'foto_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);

        try {
            // Proses upload foto jika ada
            if ($request->hasFile('foto_banner')) {
                // Upload foto ke folder 'public/foto_banners'
                $fotoPath = $request->file('foto_banner')->store('foto_banners', 'public');
            } else {
                $fotoPath = ''; // Jika tidak ada file gambar, kosongkan
            }

            // Simpan data ke dalam database
            $event = new ModelEvent();
            $event->title_event = $request->title_event;
            $event->deskripsi = $request->deskripsi;
            $event->tanggal_start = $request->tanggal_start;
            $event->tanggal_end = $request->tanggal_end;
            $event->foto_banner = $fotoPath; // Menyimpan path file foto
            $event->save();

            // Response sukses
            return response()->json([
                'success' => true,
                'message' => 'Event created successfully!',
                'data' => $event
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Tangkap error jika ada
            return response()->json([
                'success' => false,
                'message' => 'Failed to create event.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
    /**
     * Display the specified resource.
     */
public function show($id)
{
    // Cari event berdasarkan ID
    $event = ModelEvent::find($id);

    // Jika tidak ditemukan, kembalikan pesan kesalahan
    if (!$event) {
        return response()->json([
            'success' => false,
            'message' => 'Event not found.'
        ], Response::HTTP_NOT_FOUND);
    }

    // Jika ditemukan, kembalikan data event
    return response()->json([
        'success' => true,
        'data' => $event
    ], Response::HTTP_OK);
}



 public function update(Request $request, ModelEvent $event)
{
    // Validasi input jika ada
    $validated = $request->validate([
        'title' => 'sometimes|string|max:255',
        'deskripsi' => 'sometimes|string',
        'tanggal_start' => 'sometimes|date',
        'tanggal_end' => 'sometimes|date|after_or_equal:tanggal_start',
        'foto_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Update data event
    $event->update($validated);

    return response()->json([
        'success' => true,
        'data' => $event
    ], Response::HTTP_OK);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
// Menghapus data event
    $event = ModelEvent::find($id);

    if (!$event) {
        return response()->json([
            'success' => false,
            'message' => 'Event not found.'
        ], Response::HTTP_NOT_FOUND);
    }
    $event->delete();
return response()->json([
    'success' => true,
    'message' => 'Event deleted successfully.'
], Response::HTTP_OK);  // Ganti dengan Response::HTTP_OK atau kode status lainnya yang sesuai
}

}
