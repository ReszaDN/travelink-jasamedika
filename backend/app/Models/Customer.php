<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer_mt';

    protected $fillable = [
        'is_active',
        'nama',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'id_user',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id_user', 'uuid');
    // }
}
