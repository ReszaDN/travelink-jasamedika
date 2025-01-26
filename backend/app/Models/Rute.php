<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    use HasFactory;

    protected $table = 'rute_mt';

    protected $fillable = [
        'uuid',
        'is_active',
        'keberangkatan',
        'tujuan',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class,'id_rute');
    }

    public function kotaKeberangkatan()
    {
        return $this->belongsTo(Kota::class, 'keberangkatan', 'uuid');
    }

    public function kotaTujuan()
    {
        return $this->belongsTo(Kota::class, 'tujuan', 'uuid');
    }
}
