<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\ReportCategory;
use App\Models\InformantType;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);

        if (Status::count() == 0) {
            Status::insert([
                ['name' => 'Terkirim', 'slug' => 'terkirim', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Diproses', 'slug' => 'diproses', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Perlu Klarifikasi', 'slug' => 'perlu-klarifikasi', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Selesai', 'slug' => 'selesai', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Ditolak', 'slug' => 'ditolak', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (ReportCategory::count() == 0) {
            ReportCategory::insert([
                ['name' => 'Penyalahgunaan Wewenang', 'slug' => 'penyalahgunaan-wewenang', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Korupsi / Pungli', 'slug' => 'korupsi-pungli', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Pelanggaran Disiplin', 'slug' => 'pelanggaran-disiplin', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Gratifikasi', 'slug' => 'gratifikasi', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (InformantType::count() == 0) {
            InformantType::insert([
                ['name' => 'Masyarakat Umum', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'ASN / Pegawai', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}