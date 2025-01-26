<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Insert data ke tabel pertama
            $userId = DB::table('users')->insertGetId([
                'name' => 'ReszaDN',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $userUuid = DB::table('users')
                        ->where('id', $userId)
                        ->value('uuid');

            // Insert data ke tabel kedua
            DB::table('pegawai_mt')->insert([
                'nama' => 'Resza',
                'tgl_lahir' => '2000-03-14',
                'alamat' => 'Cihampelas',
                'id_user' => $userUuid,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $userId2 = DB::table('users')->insertGetId([
                'name' => 'customer1',
                'email' => 'customer1@gmail.com',
                'password' => Hash::make('customer01'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
            $userUuid2 = DB::table('users')
                           ->where('id', $userId2)
                           ->value('uuid');
        
            DB::table('customer_mt')->insert([
                'nama' => 'Customer 1',
                'tgl_lahir' => '1995-05-20',
                'alamat' => 'Cikutra',
                'jenis_kelamin' => 'Laki-laki',
                'id_user' => $userUuid2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
