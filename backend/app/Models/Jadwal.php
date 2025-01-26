<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal_mt';

    protected $fillable = [
        'uuid',
        'is_active',
        'tgl_keberangkatan',
        'harga',
        'kuota',
        'id_rute',
        'id_kendaraan',
    ];

    public function rute()
    {
        return $this->belongsTo(Rute::class, 'id_rute', 'uuid');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan', 'uuid');
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_jadwal');
    }

}
