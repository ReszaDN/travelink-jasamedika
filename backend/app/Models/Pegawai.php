<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai_mt';

    protected $fillable = [
        'is_active',
        'nama',
        'tgl_lahir',
        'alamat',
        'id_user',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id_user' , 'uuid');
    // }
}
