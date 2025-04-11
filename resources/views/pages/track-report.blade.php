@extends('layouts.main')

@section('title', 'Lacak Pengaduan')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-base-200 to-base-300">
        <div class="hero-content">
            <div class="max-w-9xl mt-32">
                <h1 class="text-7xl font-bold mt-4">Lacak Pengaduan</h1>
                <p class="text-2xl text-gray-500 mt-5">Masukkan token unik yang anda terima setelah berhasil mengirim aduan.
                </p>
                <form action="{{ route('report.track') }}" method="POST" id="track-form">
                    @csrf
                    <input type="text" name="token" id="token" placeholder="Masukkan Token Anda"
                        class="input input-bordered w-full mt-5" required />
                    <button class="btn btn-lg rounded-2xl mt-4 bg-amber-600 hover:bg-red-800 text-white">Lacak</button>
                </form>

            </div>
        </div>

        @if ($report)
            <div id="result-section" class="max-w-7xl mx-auto mt-16 bg-white p-12 rounded-2xl shadow-md">
                <h2 class="text-3xl font-bold mb-6 text-center">Detail Laporan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kolom Kiri -->
                    <div>
                        <h3 class="text-2xl font-semibold underline decoration-red-700 mb-2">Hasil Aduan</h3>
                        <p class="text-lg"><strong>Subjek Pelanggaran:</strong> {{ $report->subject }}</p>

                        <p class="mt-4 text-lg"><strong>Nama & Unit Terlapor:</strong></p>
                        <ul class="list-disc list-inside text-base">
                            @foreach ($report->reportedParties as $party)
                                <li>
                                    {{ $party->reported_name }}{{ $party->reported_unit ? ' (' . $party->reported_unit . ')' : '' }}
                                </li>
                            @endforeach
                        </ul>

                        <p class="mt-4 text-lg"><strong>Deskripsi Pelanggaran</strong></p>
                        <blockquote class="mt-2 text-justify text-gray-700 italic border-l-4 border-red-500 pl-4 pe-5">
                            {{ $report->description }}
                        </blockquote>

                        <p class="mt-4 text-lg"><strong>Tanggal Pengaduan:</strong>
                            {{ $report->reported_at->format('d M Y, H:i') }}</p>
                        <p class="mt-2 text-lg"><strong>Status:</strong> {{ $report->status->name }}</p>
                    </div>

                    <!-- Kolom Kanan -->
                    <div>
                        <h3 class="text-2xl font-semibold underline decoration-blue-700 mb-2">Riwayat Tindak Lanjut</h3>

                        @if ($report->followUp)
                            <p class="text-lg"><strong>Status:</strong> {{ $report->followUp->status->name }}</p>

                            @if ($report->followUp->notes)
                                <p class="mt-2"><strong>Catatan:</strong> {{ $report->followUp->notes }}</p>
                            @endif

                            <p class="mt-2"><strong>Terakhir Diperbarui:</strong>
                                {{ \Carbon\Carbon::parse($report->followUp->modified_at)->format('d M Y, H:i') }}
                            </p>

                            @if ($report->followUp->attachments && $report->followUp->attachments->count())
                                <div class="mt-4">
                                    <h4 class="text-lg font-medium">Lampiran:</h4>
                                    <ul class="list-disc list-inside text-blue-700">
                                        @foreach ($report->followUp->attachments as $file)
                                            <li>
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                    class="underline hover:text-blue-900">
                                                    {{ $file->file_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @else
                            <p class="text-lg text-gray-500 italic">Belum ada tindak lanjut pada laporan ini.</p>
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
