<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\ReportCategory;
use App\Models\InformantType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);

        Status::insertOrIgnore([
            ['id' => 1, 'name' => 'Terkirim', 'color' => 'secondary'],
            ['id' => 2, 'name' => 'Diverifikasi', 'color' => 'info'],
            ['id' => 3, 'name' => 'Diproses', 'color' => 'warning'],
            ['id' => 4, 'name' => 'Selesai', 'color' => 'success'],
            ['id' => 5, 'name' => 'Ditolak', 'color' => 'danger'],
        ]);

        ReportCategory::insertOrIgnore([
            ['name' => 'Pelanggaran Disiplin PNS'],
            ['name' => 'Korupsi / Pungli'],
            ['name' => 'Penyalahgunaan Wewenang'],
            ['name' => 'Pelayanan Publik Buruk'],
            ['name' => 'Lainnya'],
        ]);

        InformantType::insertOrIgnore([
            ['name' => 'Masyarakat Umum'],
            ['name' => 'PNS / ASN'],
            ['name' => 'Pegawai Swasta'],
        ]);
    }
}