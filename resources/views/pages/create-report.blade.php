@extends('layouts.main')

@section('title', 'Pengaduan')

@section('content')
    <div class="bg-base-200 min-h-screen">
        <div class="p-8 lg:p-24 min-h-screen items-center">
            <h1 class="text-2xl lg:text-7xl font-bold mt-4 text-center">Form Pengaduan</h1>
            <div class="mt-8 text-center">
                <ul class="steps">
                    <li class="step step-success" id="step1Indicator">Identitas Pelapor</li>
                    <li class="step" id="step2Indicator">Detail Kejadian</li>
                    <li class="step" id="step3Indicator">Bukti Pendukung</li>
                    <li class="step" id="step4Indicator">Konfirmasi</li>
                </ul>
            </div>

            <div class="bg-white px-8 py-12 rounded-xl shadow-lg m-8 max-w-4xl mx-auto">
                <!-- Step 1: Identitas Pelapor -->
                <div id="step1" class="step-content">
                    <h2 class="text-xl lg:text-3xl font-bold mb-4 text-center">Identitas Pelapor</h2>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend text-lg">Nama Pelapor</legend>
                        <input type="text" class="input w-full" placeholder="Dapat menggunakan nama samaran" />
                        <p class="fieldset-label text-red-600 mt-1">Wajib Diisi</p>
                    </fieldset>
                    <legend class="mt-2 fieldset-legend text-lg">Gunakan Email dan Nomor Telepon </legend>
                    <input type="checkbox" id="toggleContact" class="toggle toggle-error" checked />
                    <div id="contactFields" class="mt-4 transition-all duration-500 opacity-100 scale-100">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend text-lg">Alamat Email</legend>
                            <input type="email" class="input w-full" placeholder="Email" />
                            <p class="fieldset-label text-red-600 mt-1">Wajib Diisi</p>
                        </fieldset>
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend text-lg">Nomor Telepon</legend>
                            <input type="tel" class="input w-full" placeholder="Nomor Telepon" />
                            <p class="fieldset-label text-red-600 mt-1">Wajib Diisi</p>
                        </fieldset>
                    </div>
                </div>

                <!-- Step 2: Detail Kejadian (Hidden by default) -->
                <div id="step2" class="step-content hidden">
                    <h2 class="text-xl lg:text-3xl font-bold mb-4 text-center">Detail Kejadian</h2>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend text-lg">Jenis Pelanggaran</legend>
                        <select class="input w-full">
                            <option>- Pilih Jenis Pelanggaran -</option>
                        </select>
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend text-lg">Nama Terlapor</legend>
                        <input type="text" class="input w-full" placeholder="Nama" />
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend text-lg">Unit Jabatan</legend>
                        <input type="text" class="input w-full" placeholder="Jabatan" />
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend text-lg">Deskripsi Pelanggaran</legend>
                        <textarea class="input w-full" placeholder="Deskripsi Pelanggaran"></textarea>
                    </fieldset>
                </div>

                <!-- Step 3: Bukti Pendukung (Hidden by default) -->
                <div id="step3" class="step-content hidden">
                    <h2 class="text-xl lg:text-3xl font-bold mb-4 text-center">Bukti Kejadian Pelanggaran</h2>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend text-lg">Upload Bukti Pendukung</legend>
                        <input type="file" class="input w-full" />
                        <p class="fieldset-label mt-1">Format yang didukung: jpg, png, pdf</p>
                    </fieldset>
                </div>

                <!-- Step 4: Konfirmasi (Hidden by default) -->
                <div id="step4" class="step-content hidden">
                    <h2 class="text-xl lg:text-3xl font-bold mb-4 text-center">Ringkasan Laporan</h2>
                    <h2 class="text-xl font-bold mb-4">Konfirmasi Laporan Anda</h2>
                    <p class="text-lg">Pastikan semua data yang Anda masukkan sudah benar sebelum mengirim laporan.</p>
                </div>

                <!-- Tombol Navigasi -->
                <div class="mt-6 flex justify-between items-center">
                    <button id="prevButton"
                        class="btn btn-secondary btn-lg px-6 py-2 text-white font-bold rounded-lg hidden">Sebelumnya</button>
                    <button id="nextButton"
                        class="btn btn-success btn-lg px-6 py-2 text-white font-bold rounded-lg">Selanjutnya</button>
                    <button id="submitButton"
                        class="btn btn-primary btn-lg px-6 py-2 text-white font-bold rounded-lg hidden">Kirim
                        Laporan</button>
                </div>
            </div>
        </div>
    @endsection
