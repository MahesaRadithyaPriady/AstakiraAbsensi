<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\IzinSakit;
use Illuminate\Database\Seeder;

class ClearAbsensiSeeder extends Seeder
{
    public function run(): void
    {
        IzinSakit::truncate();
        Absensi::truncate();

        $this->command->info('Semua data absensi dan izin/sakit PKL berhasil dihapus.');
    }
}
