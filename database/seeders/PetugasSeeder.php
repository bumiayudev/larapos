<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Petugas;


class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Petugas::create([
            'kd_ptg' => 'KD001',
            'nm_ptg' => 'jhondoe',
            'email' => 'jhondoe@mail.com',
            'password' => Hash::make('default123')
        ]);

        Petugas::create([
            'kd_ptg' => 'KD002',
            'nm_ptg' => 'putri',
            'email' => 'putri@mail.com',
            'password' => Hash::make('default123'),
            'status' => 'Kasir'
        ]);
    }
}
