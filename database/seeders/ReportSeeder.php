<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Informant;
use App\Models\InformantType;
use App\Models\ReportCategory;
use App\Models\ReportedParty;
use App\Models\Status;
use App\Models\FollowUp;
use App\Models\FollowUpAttachment;
use App\Models\Attachment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing related data
        $categories = ReportCategory::all();
        $statuses = Status::all();
        $informantTypes = InformantType::all();

        if ($categories->isEmpty() || $statuses->isEmpty() || $informantTypes->isEmpty()) {
            $this->command->warn('Please seed ReportCategorySeeder, StatusSeeder, and InformantTypeSeeder first!');
            return;
        }

        // Create dummy informants if none exist
        if (Informant::count() == 0) {
            $this->createDummyInformants($informantTypes);
        }

        $informants = Informant::all();

        if ($informants->isEmpty()) {
            $this->command->warn('No informants found. Please create informants first!');
            return;
        }

        // Sample report subjects and descriptions
        $reportData = [
            [
                'subject' => 'Penyalahgunaan Dana Desa',
                'description' => 'Terdapat dugaan penyalahgunaan dana desa untuk kepentingan pribadi oleh perangkat desa. Dana yang seharusnya digunakan untuk pembangunan infrastruktur tidak jelas penggunaannya.',
                'parties' => ['Kepala Desa', 'Sekretaris Desa'],
            ],
            [
                'subject' => 'Korupsi di Dinas Pendidikan',
                'description' => 'Diduga terjadi korupsi dalam pengadaan barang dan peralatan sekolah. Barang yang dikirimkan tidak sesuai dengan spesifikasi dan harga yang tertera dalam dokumen tender.',
                'parties' => ['Kepala Dinas Pendidikan', 'Pejabat Pengadaan'],
            ],
            [
                'subject' => 'Pungli di Kantor Kecamatan',
                'description' => 'Petugas loket di kantor kecamatan meminta biaya tambahan untuk pengurusan dokumen yang seharusnya gratis. Biaya tersebut tidak tercatat dalam sistem resmi.',
                'parties' => ['Petugas Loket', 'Kasubag TU'],
            ],
            [
                'subject' => 'Penyimpangan Perizinan',
                'description' => 'Pemberian izin usaha tanpa melalui prosedur yang benar dan sesuai dengan peraturan yang berlaku. Pemohon tidak memenuhi semua persyaratan tetap mendapatkan izin.',
                'parties' => ['Kepala BPMPTSP', 'Verifikator'],
            ],
            [
                'subject' => 'Pengaturan Proyek Konstruksi',
                'description' => 'Proyek pembangunan jalan dilakukan dengan kualitas yang tidak sesuai dengan standar namun tetap diterima sebagai pekerjaan yang selesai dengan baik.',
                'parties' => ['Kontraktor', 'Pengawas Proyek'],
            ],
            [
                'subject' => 'Perlakuan Diskriminatif',
                'description' => 'Pegawai pemerintah memberikan pelayanan yang berbeda kepada warga berdasarkan faktor tertentu seperti asal daerah atau koneksi keluarga.',
                'parties' => ['Pegawai Pelayanan'],
            ],
            [
                'subject' => 'Illegal Logging di Hutan Lindung',
                'description' => 'Terdapat aktivitas penebangan pohon ilegal di kawasan hutan lindung dengan melibatkan aparat setempat yang seharusnya melakukan pengawasan.',
                'parties' => ['Mantri Hutan', 'Penjual Kayu Ilegal'],
            ],
            [
                'subject' => 'Penyimpangan Anggaran Operasional',
                'description' => 'Dana operasional kantor digunakan untuk keperluan pribadi dan keluarga pejabat tanpa pertanggungjawaban yang jelas.',
                'parties' => ['Kepala Dinas', 'Bendahara'],
            ],
            [
                'subject' => 'Rekrutmen ASN Tidak Transparan',
                'description' => 'Proses rekrutmen aparatur sipil negara tidak mengikuti prosedur yang objektif dan terbuka. Dugaan ada intervensi dari pimpinan dalam proses seleksi.',
                'parties' => ['Panitia Rekrutmen', 'Pimpinan Dinas'],
            ],
            [
                'subject' => 'Kolusi Dalam Tender',
                'description' => 'Informasi tender bocor kepada peserta tertentu sebelum pengumuman resmi. Diduga ada kerjasama antara pejabat dan penyedia barang/jasa.',
                'parties' => ['Pejabat Pengadaan', 'Penyedia Barang'],
            ],
        ];

        // Create 10 dummy reports
        $reports = [];
        foreach ($reportData as $index => $data) {
            $category = $categories->random();
            $status = $statuses->random();
            $informant = $informants->random();

            // Generate random date within last 90 days
            $reportedDate = Carbon::now()
                ->subDays(rand(0, 90))
                ->subHours(rand(0, 23))
                ->subMinutes(rand(0, 59));

            $report = Report::create([
                'token' => Str::upper(Str::random(6)),
                'informant_id' => $informant->id,
                'category_id' => $category->id,
                'subject' => $data['subject'],
                'description' => $data['description'],
                'location' => $this->getRandomLocation(),
                'incident_time' => $reportedDate->copy()->subDays(rand(1, 30)),
                'status_id' => $status->id,
                'reported_at' => $reportedDate,
            ]);

            $reports[] = [
                'report' => $report,
                'reported_date' => $reportedDate,
            ];

            // Create ReportedParty data
            foreach ($data['parties'] as $partyName) {
                ReportedParty::create([
                    'report_id' => $report->id,
                    'reported_name' => $partyName,
                    'reported_unit' => $this->getRandomLocation(),
                ]);
            }

            // Create 1-3 Attachments for each report
            $attachmentCount = rand(1, 3);
            for ($i = 0; $i < $attachmentCount; $i++) {
                $fileTypes = ['pdf', 'doc', 'image'];
                $fileType = $fileTypes[array_rand($fileTypes)];

                $attachment = $this->generateAttachmentData($fileType);

                Attachment::create([
                    'report_id' => $report->id,
                    'file_path' => $attachment['path'],
                    'file_name' => $attachment['name'],
                    'file_type' => $attachment['type'],
                ]);
            }
        }

        // Create FollowUp records for 7 out of 10 reports
        $followUpNotes = [
            'Laporan telah diterima dan sedang dalam tahap verifikasi awal.',
            'Tim investigasi telah ditugaskan untuk melakukan penyelidikan lebih lanjut.',
            'Bukti telah dikumpulkan dan sedang dianalisis oleh tim ahli.',
            'Perlu dilakukan klarifikasi lebih lanjut dari pihak pelapor mengenai detail kronologi peristiwa.',
            'Hasil investigasi menunjukkan adanya indikasi pelanggaran sesuai peraturan yang berlaku.',
            'Berdasarkan hasil investigasi, kasus ini telah ditutup karena tidak ditemukan cukup bukti.',
            'Kasus telah diserahkan ke pihak berwajib untuk tindakan lanjutan sesuai prosedur hukum.',
        ];

        // Randomly create follow-ups for 7 reports
        $followUpReports = array_rand(array_flip(range(0, 9)), 7);
        $allStatuses = Status::all();

        foreach ($followUpReports as $reportIndex) {
            $reportData = $reports[$reportIndex];
            $report = $reportData['report'];
            $reportedDate = $reportData['reported_date'];

            // Create follow-up 1-10 days after report was made
            $followUpDate = $reportedDate->copy()->addDays(rand(1, 10));

            $followUpStatus = $allStatuses->random();
            $noteKey = array_rand($followUpNotes);

            $followUp = FollowUp::create([
                'report_id' => $report->id,
                'notes' => $followUpNotes[$noteKey],
                'status_id' => $followUpStatus->id,
            ]);

            // Update the follow-up record's timestamp to simulate when it was last updated
            FollowUp::where('report_id', $report->id)->update([
                'created_at' => $followUpDate,
                'updated_at' => $followUpDate,
            ]);

            // Create 1-3 FollowUp attachments for each follow-up
            $attachmentCount = rand(1, 3);
            for ($i = 0; $i < $attachmentCount; $i++) {
                $fileTypes = ['pdf', 'doc', 'image'];
                $fileType = $fileTypes[array_rand($fileTypes)];

                $attachment = $this->generateAttachmentData($fileType);

                FollowUpAttachment::create([
                    'follow_up_id' => $followUp->id,
                    'file_path' => $attachment['path'],
                    'file_name' => $attachment['name'],
                    'file_type' => $attachment['type'],
                ]);
            }
        }

        $this->command->info('Successfully created 10 dummy reports with reported parties!');
        $this->command->info('Created report attachments (10-30 attachment records)!');
        $this->command->info('Created follow-up records for 7 reports with various statuses!');
        $this->command->info('Created follow-up attachments with sample evidence files!');
    }

    /**
     * Create dummy informants
     */
    private function createDummyInformants($informantTypes): void
    {
        $informantNames = [
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@email.com', 'phone' => '081234567890'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@email.com', 'phone' => '081234567891'],
            ['name' => 'Ahmad Wijaya', 'email' => 'ahmad.wijaya@email.com', 'phone' => '081234567892'],
            ['name' => 'Ani Rahmawati', 'email' => 'ani.rahmawati@email.com', 'phone' => '081234567893'],
            ['name' => 'Rudi Hermawan', 'email' => 'rudi.hermawan@email.com', 'phone' => '081234567894'],
            ['name' => 'Anonim', 'email' => null, 'phone' => null],
            ['name' => 'Pegawai Intern', 'email' => 'pegawai.intern@email.com', 'phone' => '081234567895'],
            ['name' => 'Masyarakat Peduli', 'email' => 'masyarakat.peduli@email.com', 'phone' => '081234567896'],
        ];

        foreach ($informantNames as $data) {
            Informant::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'type_id' => $informantTypes->random()->id,
            ]);
        }

        $this->command->info('Created 8 dummy informants!');
    }

    /**
     * Get random location
     */
    private function getRandomLocation(): string
    {
        $locations = [
            'Kantor Bupati Sukoharjo',
            'Dinas Pendidikan',
            'Dinas Kesehatan',
            'Kantor Camat Sukoharjo',
            'Kantor Desa Jatirejo',
            'Kantor Desa Gajahan',
            'Dinas Pekerjaan Umum',
            'Kantor Pajak Daerah',
            'Dinas Perindustrian',
            'Kantor Agraria',
            'Dinas Pertanian',
            'Kantor Kelurahan Gajahan',
        ];

        return $locations[array_rand($locations)];
    }

    /**
     * Generate attachment data
     */
    private function generateAttachmentData($fileType): array
    {
        $pdfNames = [
            'Laporan_Investigasi_Awal.pdf',
            'Bukti_Transfer_Dana.pdf',
            'Surat_Pernyataan_Saksi.pdf',
            'Dokumen_Keuangan.pdf',
            'Catatan_Rapat_Investigasi.pdf',
        ];

        $docNames = [
            'Analisis_Temuan.docx',
            'Rekomendasi_Tindakan.docx',
            'Resume_Kasus.docx',
            'Pernyataan_Resmi.docx',
        ];

        $imageNames = [
            'foto_bukti_01.jpg',
            'foto_bukti_02.jpg',
            'tangkapan_layar.png',
            'dokumen_scan.jpg',
        ];

        if ($fileType === 'pdf') {
            $fileName = $pdfNames[array_rand($pdfNames)];
            $mimeType = 'application/pdf';
        } elseif ($fileType === 'doc') {
            $fileName = $docNames[array_rand($docNames)];
            $mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        } else { // image
            $fileName = $imageNames[array_rand($imageNames)];
            $mimeType = strpos($fileName, '.png') !== false ? 'image/png' : 'image/jpeg';
        }

        $filePath = 'attachments/follow_ups/' . Str::random(10) . '_' . $fileName;

        return [
            'name' => $fileName,
            'path' => $filePath,
            'type' => $mimeType,
        ];
    }
}
