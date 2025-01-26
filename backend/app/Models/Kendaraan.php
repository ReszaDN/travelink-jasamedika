<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan_mt';

    protected $fillable = [
        'uuid',
        'is_active',
        'kode_kendaraan',
        'no_kendaraan',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class,'id_kendaraan');
    }
}
