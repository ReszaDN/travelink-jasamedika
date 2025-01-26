<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;
    protected $table = 'kota_mt';

    protected $fillable = [
        'uuid',
        'is_active',
        'nama_kota',
    ];

    public function ruteKeberangkatan()
    {
        return $this->hasMany(Rute::class, 'keberangkatan');
    }

    public function ruteTujuan()
    {
        return $this->hasMany(Rute::class, 'tujuan');
    }

}
