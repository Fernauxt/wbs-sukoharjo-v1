@extends('layouts.main')

@section('title', 'Pengaduan')

@section('content')
    <form method="POST" id="form-laporan" action="{{ route('report.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="bg-base-200 min-h-screen">
            <div class="p-8 lg:p-24 min-h-screen items-center">
                <h1 class="text-2xl lg:text-7xl font-bold mt-4 text-center">Form Pengaduan</h1>
                <div class="mt-8 text-center">
                    <ul class="steps">
                        <li class="step step-error" id="step1Indicator">Identitas Pelapor</li>
                        <li class="step" id="step2Indicator">Detail Kejadian</li>
                        <li class="step" id="step3Indicator">Bukti Pendukung</li>
                        <li class="step" id="step4Indicator">Ringkasan Laporan</li>
                    </ul>
                </div>

                <div class="bg-white px-8 py-12 rounded-xl shadow-lg m-8 max-w-4xl mx-auto">
                    <!-- Step 1: Identitas Pelapor -->
                    <div id="step1" class="step-content">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend text-lg">Nama Pelapor</legend>
                            <input type="text" name="informant_name" id="informant_name" class="input w-full"
                                placeholder="Dapat menggunakan nama samaran" required />
                            <p class="fieldset-label text-red-600 mt-1" id="namaError"></p>

                            <legend class="fieldset-legend text-lg">Jenis Pelapor</legend>
                            <select name="informant_type_id" class="input w-full">
                                <option value="" disabled selected>- Pilih Jenis Pelapor -</option>
                                @foreach ($informant_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        <legend class="mt-2 fieldset-legend text-lg">Gunakan Email dan Nomor Telepon </legend>
                        <input type="checkbox" id="toggleContact" class="toggle toggle-error" />

                        <div id="contactFields" class="mt-4 transition-all duration-500 opacity-100 scale-100">
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend text-lg">Alamat Email</legend>
                                <input name="email" type="email" id="email" class="input w-full" placeholder="Email"
                                    required />
                                <p class="fieldset-label text-red-600 mt-1" id="emailError"></p>

                                <legend class="fieldset-legend text-lg">Nomor Telepon</legend>
                                <input name="phone" type="tel" id="phone" class="input w-full"
                                    placeholder="Nomor Telepon" />
                                <p class="fieldset-label text-red-600 mt-1" id="teleponError"></p>
                                <small>Pastikan nomor telepon aktif dan dapat dihubungi</small>
                            </fieldset>
                        </div>

                        <div id="infoFields" class="mt-4 transition-all duration-500 opacity-0 scale-95 hidden">
                            <p class="lg:text-xl">
                                Pencantuman email akan memudahkan kami dalam menyampaikan update status tindak lanjut
                                laporan Anda secara otomatis melalui email yang Anda cantumkan.
                            </p>
                            <p class="lg:text-xl my-4">
                                Jika Anda tidak mencantumkan email, Anda tetap dapat melakukan pemantauan laporan
                                secara manual melalui kode yang akan diberikan di akhir pelaporan.
                            </p>
                            <p class="lg:text-xl">Pastikan Anda menyimpan kode tersebut!</p>
                        </div>
                    </div>

                    <!-- Step 2: Detail Kejadian -->
                    <div id="step2" class="step-content hidden">
                        <!-- Pilih Jenis Pelanggaran -->
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend text-lg">Jenis Pelanggaran</legend>
                            <select name="category_id" class="input w-full">
                                <option value="" disabled selected>- Pilih Kategori Laporan -</option>
                                @foreach ($categories as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        <!-- Container untuk Nama Terlapor & Unit Jabatan -->
                        <div id="terlaporContainer">
                            <!-- Baris pertama default -->
                            <div class="terlapor-item flex space-x-4 mt-4">
                                <!-- Input Nama Terlapor -->
                                <fieldset class="fieldset w-1/2">
                                    <legend class="fieldset-legend text-lg">Nama Terlapor</legend>
                                    <input type="text" class="input w-full" name="reported_name[]"
                                        placeholder="Nama Terlapor" />
                                </fieldset>

                                <!-- Input Unit Jabatan -->
                                <fieldset class="fieldset w-1/2">
                                    <legend class="fieldset-legend text-lg">Unit Jabatan</legend>
                                    <input type="text" class="input w-full" name="reported_unit[]"
                                        placeholder="Jabatan" />
                                </fieldset>

                                <!-- Tombol "+" untuk menambah input baru -->
                                <button type="button" class="btn btn-outline btn-success px-3 py-2 mb-1 self-end"
                                    id="addTerlapor">
                                    +
                                </button>
                            </div>
                        </div>

                        <!-- Subjek Pelanggaran -->
                        <fieldset class="fieldset mt-4">
                            <legend class="fieldset-legend text-lg">Subjek Pelanggaran</legend>
                            <input type="text" class="input w-full" name="violation_subject"
                                placeholder="Nama Subjek Pelanggaran" />

                            <!-- Deskripsi Pelanggaran -->
                            <legend class="fieldset-legend text-lg">Deskripsi Pelanggaran</legend>
                            <textarea class="textarea w-full h-64" name="violation_desc" placeholder="Jelaskan secara rinci"></textarea>
                        </fieldset>
                    </div>


                    <!-- Step 3: Bukti Pendukung (Hidden by default) -->
                    <div id="step3" class="step-content hidden">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend text-lg">Lokasi Kejadian</legend>
                            <input type="text" name="location" id="location" class="input w-full"
                                placeholder="Masukkan lokasi kejadian" />
                            <legend class="fieldset-legend text-lg">Waktu Kejadian</legend>
                            <input type="datetime-local" name="datetime" id="datetime" class="input w-full" />
                            <legend class="fieldset-legend text-lg">Upload Bukti Pendukung</legend>
                            <input type="file" name="evidence[]" class="input w-full" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip" multiple/>
                            <p class="fieldset-label mt-1"></p>
                            <small>Format yang didukung: jpg, png, pdf. Maks 10 file. Maksimal 5MB per file</small>
                        </fieldset>
                    </div>

                    <!-- Step 4: Konfirmasi (Hidden by default) -->
                    <div id="step4" class="step-content hidden">
                        <h2 class="text-2xl font-bold mb-4">Ringkasan Laporan Anda</h2>
                        <p><strong>Nama Pelapor:</strong> <span id="summaryNama"></span></p>
                        <p><strong>Email:</strong> <span id="summaryEmail"></span></p>
                        <p><strong>Telepon:</strong> <span id="summaryTelepon"></span></p>
                        <p><strong>Jenis Pelanggaran:</strong> <span id="summaryJenis"></span></p>
                        <p><strong>Nama Terlapor:</strong> <span id="summaryTerlapor"></span></p>
                        <p><strong>Unit Jabatan:</strong> <span id="summaryJabatan"></span></p>
                        <p><strong>Deskripsi:</strong> <span id="summaryDeskripsi"></span></p>
                        <p><strong>Lokasi:</strong> <span id="summaryLokasi"></span></p>
                        <p><strong>Waktu:</strong> <span id="summaryWaktu"></span></p>
                    </div>

                    <!-- Tombol Navigasi -->
                    <div class="mt-6 flex justify-between items-center">
                        <button type="button" id="prevButton"
                            class="btn bg-amber-600 hover:bg-red-800 btn-lg text-white font-bold rounded-lg hidden">Sebelumnya</button>
                        <button type="button" id="nextButton"
                            class="btn bg-green-700 hover:bg-green-800 btn-lg text-white font-bold rounded-lg">Selanjutnya</button>
                        <button type="submit" id="submitButton"
                            class="btn bg-blue-600 hover:bg-blue-800 btn-lg text-white font-bold rounded-lg hidden">Kirim
                            Laporan</button>
                    </div>
                </div>

                <!-- Modal for Missing Required Inputs -->
                <div id="inputKosongModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="modal-box bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-bold mb-4">Form Tidak Lengkap</h3>
                        <p class="text-gray-700 mb-4">Harap isi semua kolom yang wajib diisi sebelum melanjutkan ke langkah berikutnya.</p>
                        <button id="closeModalButton" class="btn bg-red-600 hover:bg-red-800 text-white font-bold rounded-lg px-4 py-2">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
