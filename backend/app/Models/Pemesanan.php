<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_tt';

    protected $fillable = [
        'uuid', 
        'is_active',
        'tgl_order',
        'jumlah_pesan',
        'total_harga',
        'status',
        'id_jadwal',
        'id_user',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPesanan()
    {
        return $this->hasMany(PemesananDetail::class, 'id_pemesanan');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'uuid');
    }
}
