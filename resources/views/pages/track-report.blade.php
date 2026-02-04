@extends('layouts.main')

@section('title', 'Lacak Pengaduan')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-base-200 to-base-300">
        <div class="hero-content px-4 sm:px-6 lg:px-12">
            <div class="max-w-4xl sm:max-w-7xl lg:max-w-9xl mt-16 sm:mt-24 lg:mt-32 w-full">
                <h1 class="text-3xl sm:text-5xl lg:text-7xl font-bold mt-2 sm:mt-4 lg:mt-4">Lacak Pengaduan</h1>
                <p class="text-sm sm:text-lg lg:text-2xl text-gray-500 mt-3 sm:mt-5 lg:mt-5">
                  Masukkan token unik yang anda terima setelah berhasil mengirim aduan.
                </p>
                <form action="{{ route('report.track') }}" method="POST" id="track-form">
                    @csrf
                    <input type="text" name="token" id="token" placeholder="Masukkan Token Anda"
                        class="input input-bordered w-full mt-3 sm:mt-5 lg:mt-5 text-xs sm:text-base" required />
                    <button class="btn btn-sm sm:btn-md lg:btn-lg rounded-xl sm:rounded-2xl lg:rounded-2xl mt-3 sm:mt-4 lg:mt-4 bg-amber-600 hover:bg-red-800 text-white w-full sm:w-auto">Lacak</button>
                </form>

            </div>
        </div>

        @if ($report)
            <div id="result-section" class="max-w-6xl sm:max-w-6xl lg:max-w-7xl mx-auto mt-8 sm:mt-12 lg:mt-16 bg-white p-4 sm:p-8 lg:p-12 rounded-lg sm:rounded-2xl lg:rounded-2xl shadow-md">
                <h2 class="text-2xl sm:text-3xl lg:text-3xl font-bold mb-4 sm:mb-6 lg:mb-6 text-center">Detail Laporan</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                    <!-- Kolom Kiri -->
                    <div class="px-2 sm:px-0">
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold underline decoration-red-700 mb-2 sm:mb-3 lg:mb-2">Hasil Aduan</h3>
                        <p class="text-xs sm:text-sm lg:text-lg"><strong>Subjek Pelanggaran:</strong> {{ $report->subject }}</p>

                        <p class="mt-3 sm:mt-4 lg:mt-4 text-xs sm:text-sm lg:text-lg"><strong>Nama & Unit Terlapor:</strong></p>
                        <ul class="list-disc list-inside text-xs sm:text-sm lg:text-base">
                            @foreach ($report->reportedParties as $party)
                                <li>
                                    {{ $party->reported_name }}{{ $party->reported_unit ? ' (' . $party->reported_unit . ')' : '' }}
                                </li>
                            @endforeach
                        </ul>

                        <p class="mt-3 sm:mt-4 lg:mt-4 text-xs sm:text-sm lg:text-lg"><strong>Deskripsi Pelanggaran</strong></p>
                        <blockquote class="mt-2 text-justify text-gray-700 italic border-l-4 border-red-500 pl-3 sm:pl-4 pe-3 sm:pe-5 text-xs sm:text-sm lg:text-base">
                            {{ $report->description }}
                        </blockquote>

                        <p class="mt-3 sm:mt-4 lg:mt-4 text-xs sm:text-sm lg:text-lg"><strong>Tanggal Pengaduan:</strong>
                            {{ $report->reported_at->format('d M Y, H:i') }}</p>
                        <p class="mt-2 text-xs sm:text-sm lg:text-lg"><strong>Status:</strong> {{ $report->status->name }}</p>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="px-2 sm:px-0 mt-4 lg:mt-0">
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold underline decoration-blue-700 mb-2 sm:mb-3 lg:mb-2">Riwayat Tindak Lanjut</h3>

                        @if ($report->followUp)
                            <p class="text-xs sm:text-sm lg:text-lg"><strong>Status:</strong> {{ $report->followUp->status->name }}</p>

                            @if ($report->followUp->notes)
                                <p class="mt-2 text-xs sm:text-sm lg:text-base"><strong>Catatan:</strong> {{ $report->followUp->notes }}</p>
                            @endif

                            <p class="mt-2 text-xs sm:text-sm lg:text-base"><strong>Terakhir Diperbarui:</strong>
                                {{ \Carbon\Carbon::parse($report->followUp->modified_at)->format('d M Y, H:i') }}
                            </p>

                            {{-- filepath: d:\intern_skh\wbs-sukoharjo-v1\resources\views\pages\track-report.blade.php --}}
                            <div class="mt-3 sm:mt-4 lg:mt-4">
                                <h4 class="text-xs sm:text-sm lg:text-lg font-medium mb-2 sm:mb-3 lg:mb-2">Lampiran:</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-1 sm:gap-2 lg:gap-2">
                                    @foreach ($report->followUp->attachments as $file)
                                        <div class="flex flex-col items-center">
                                            @if (in_array(pathinfo($file->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $file->file_path) }}"
                                                        alt="{{ $file->file_name }}"
                                                        class="w-20 h-24 sm:w-24 sm:h-32 lg:w-32 lg:h-48 object-cover rounded-md shadow-md">
                                                </a>
                                            @else
                                                <div class="flex flex-col items-center">
                                                    @if (Str::contains($file->file_path, ['pdf']))
                                                        <i class="fas fa-file-pdf text-red-500 text-2xl sm:text-3xl lg:text-4xl"></i>
                                                    @elseif (Str::contains($file->file_path, ['doc', 'docx']))
                                                        <i class="fas fa-file-word text-blue-500 text-2xl sm:text-3xl lg:text-4xl"></i>
                                                    @elseif (Str::contains($file->file_path, ['zip', 'rar']))
                                                        <i class="fas fa-file-archive text-yellow-500 text-2xl sm:text-3xl lg:text-4xl"></i>
                                                    @else
                                                        <i class="fas fa-file-alt text-gray-500 text-2xl sm:text-3xl lg:text-4xl"></i>
                                                    @endif
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                        class="mt-1 sm:mt-2 text-xs sm:text-sm underline hover:text-blue-900 text-center break-words">
                                                        {{ $file->file_name }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-xs sm:text-sm lg:text-lg text-gray-500 italic">Belum ada tindak lanjut pada laporan ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Modal jika token tidak ditemukan --}}
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold">Token Tidak Ditemukan</h3>
                <p class="py-4">Silakan periksa kembali token Anda</p>
                <div class="modal-action">
                    <form method="dialog">
                        <button class="btn bg-amber-700 hover:bg-red-800 text-white">Tutup</button>
                    </form>
                </div>
            </div>
        </dialog>
    </div>

    @if (session('error'))
        <script>
            window.onload = function() {
                const modal = document.getElementById('my_modal_1');
                if (modal?.showModal) {
                    modal.showModal();
                }

                // Hapus error dari history agar modal nggak kebuka lagi pas refresh
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            };
        </script>
    @endif
@endsection
