<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('kategori')->insert([
        ['kategori' => 'Besar'],
        ['kategori' => 'Kecil'],
        ['kategori' => 'Mega D&B'],
        ['kategori' => 'Mega Non D&B'],
        ['kategori' => 'Menengah'],
    ]);

    DB::table('departement')->insert([
        ['departement' => 'HSR Departement'],
        ['departement' => 'Operation 1 Departement'],
        ['departement' => 'Operation 2 Departement'],
    ]);

    DB::table('status')->insert([
        ['status' => 'Proyek JO'],
        ['status' => 'Proyek Non JO'],
    ]);

    DB::table('strategic')->insert([
        ['strategic' => 'AIRPORT'],
        ['strategic' => 'BENDUNGAN'],
        ['strategic' => 'JALAN & JEMBATAN'],
        ['strategic' => 'RAILWAY'],
        ['strategic' => 'WATER INFRASTRUCTURE'],
        ['strategic' => 'Proyek Non JO'],
    ]);
}

}
