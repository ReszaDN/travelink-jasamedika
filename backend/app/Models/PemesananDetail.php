<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananDetail extends Model
{
    use HasFactory;

    protected $table = 'pemesanandetail_tt';

    protected $fillable = [
        'is_active',
        'nama_penumpang',
        'no_identitas',
        'id_pemesanan',
    ];
    

    public function pesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'uuid');
    }
}
