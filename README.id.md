# Whistleblowing System (WBS) - Kabupaten Sukoharjo

[![Language](https://img.shields.io/badge/Lang-Indonesian-red)](README.id.md) [![Language](https://img.shields.io/badge/Lang-English-blue)](README.md)

> **[🇺🇸 Read English Version Here](README.md)**

Sistem pelaporan pelanggaran (Whistleblowing System) yang dirancang untuk transparansi dan keamanan pelapor.

**Konteks Proyek:**
Aplikasi ini merupakan **pengembangan lanjutan dari proyek magang**, yang kini difokuskan pada migrasi infrastruktur basis data dari **MySQL ke PostgreSQL** serta pembaruan teknologi ke **Laravel 12** untuk meningkatkan performa dan integritas data.

---

## ⚠️ Catatan Teknis & Batasan Demo (Vercel Deployment)

Proyek ini didistribusikan (deploy) menggunakan **Vercel** dengan lingkungan *Serverless*. Dikarenakan batasan sistem file (ephemeral file system) pada lingkungan serverless, terdapat beberapa penyesuaian pada demo ini:

* **Fitur Upload Bukti (Attachment)** saat ini **dinonaktifkan / tidak disimpan** pada versi live demo ini. Pengguna tetap dapat memilih file, namun file tersebut tidak akan disimpan secara permanen ke server.
* Seluruh fitur inti lainnya (CRUD Pengaduan, Validasi Input, Generate Token Unik, hingga Dashboard Admin) berjalan **100% normal** dan terintegrasi dengan database **PostgreSQL (Neon)**.

> **Catatan:** Fitur penyimpanan file (File Storage) berfungsi sepenuhnya dengan baik pada lingkungan pengembangan lokal (*Local Development Environment*) menggunakan penyimpanan standar Laravel.

---

## ⚠️ Development Notes & Known Limitations

Sebagai proyek portofolio yang sedang dalam tahap pengembangan aktif, terdapat beberapa catatan penting mengenai kondisi kode saat ini:

1.  **Desktop-First UI:**
    * Antarmuka pengguna (User Interface) saat ini dioptimalkan untuk penggunaan pada layar **Desktop/Laptop**.
    * Tampilan pada perangkat *mobile* (smartphone/tablet) mungkin belum responsif sepenuhnya dan memerlukan penyesuaian CSS lebih lanjut.

2.  **Database Migration Status:**
    * Proyek ini baru saja dimigrasikan dari **MySQL ke PostgreSQL** (Strict Mode).
    * Beberapa *slug* status di database menggunakan Bahasa Indonesia (`diproses`, `selesai`) untuk kompatibilitas dengan data lama, sementara penamaan variabel di kode menggunakan Bahasa Inggris. Hal ini akan distandarisasi pada versi berikutnya (v2).

3.  **Fitur Notifikasi:**
    * Fitur notifikasi WhatsApp (WablasService) saat ini dinonaktifkan (`commented out`) di controller dan digantikan sepenuhnya oleh notifikasi Email (SMTP).

---

## 🚀 Fitur Utama

### 🔒 Untuk Pelapor (Publik)
* **Anonimitas Terjamin:** Pelapor tidak wajib mencantumkan identitas pribadi.
* **Tracking System:** Menggunakan **Token Unik 6-Karakter** (contoh: `A1B2C3`) untuk melacak status laporan tanpa perlu login.
* **Bukti Pendukung:** Mendukung upload lampiran (Gambar, PDF, DOCX) dengan penyimpanan aman di `storage/private`.
* **Notifikasi Email:** Update status otomatis dikirim ke email pelapor (jika dicantumkan).

### 🛡️ Untuk Admin
* **Dashboard Statistik:** Ringkasan visual jumlah laporan berdasarkan kategori dan status.
* **Manajemen Laporan:** Ubah status laporan (Ditinjau, Perlu Klarifikasi, Selesai).
* **Tindak Lanjut:** Menambahkan catatan internal dan bukti tindak lanjut.
* **Sistem Validasi:** Validasi input yang ketat untuk mencegah *spam* atau data yang tidak lengkap.

---

## 📸 Galeri Tampilan

| Halaman Utama | Form Pelaporan |
| :---: | :---: |
| ![Halaman Utama](public/screenshots/home-wbs.png) | ![Form Pelaporan](public/screenshots/report-wbs.png) |

| Dashboard Admin | Lacak Laporan |
| :---: | :---: |
| ![Dashboard Admin](public/screenshots/home-admin-wbs.png) | ![Lacak Laporan](public/screenshots/track-report-wbs.png) |

---

## 🛠️ Teknologi

* **Backend:** Laravel 12.x
* **Database:** PostgreSQL (Strict Mode)
* **Frontend:** Blade Templates + Tailwind CSS
* **Security:** CSRF Protection, Encrypted Sessions, Secure File Storage

---

## 📥 Panduan Instalasi (Local Development)

Ikuti langkah ini untuk menjalankan proyek di komputer lokal Anda:

### 1. Prasyarat
Pastikan Anda sudah menginstal:
* PHP >= 8.2
* Composer
* PostgreSQL
* Node.js & NPM

### 2. Instalasi
```bash
# Clone repository
git clone [https://github.com/username-anda/wbs-sukoharjo-v1.git](https://github.com/username-anda/wbs-sukoharjo-v1.git)
cd wbs-sukoharjo-v1

# Install dependencies PHP & JS
composer install
npm install
```

### 3. Konfigurasi Lingkungan
Salin .env.example menjadi .env dan atur koneksi PostgreSQL anda:
```bash
cp .env.example .env
```

Edit .env
```ini,toml
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=wbs_sukoharjo
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 4. Database Setup
Generate app key dan jalankan migrasi serta seeder (penting untuk data awal):
```bash
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```

### 5. Jalankan Aplikasi
Buka dua terminal terpisah untuk menjalankan server Laravel dan build aset frontend:
```bash
# Terminal 1
npm run dev

# Terminal 2
php artisan serve
```

---

## 🔑 Akun Demo (Default)
Jika Anda menjalankan perintah --seed, gunakan akun berikut untuk login ke panel Admin:
* **URL:** /admin
* **Username | Password :** admin | admin

---

## 👨‍💻 Author
Dikembangkan oleh **Mieke** sebagai bagian dari portofolio pengembangan Full-Stack Web.
