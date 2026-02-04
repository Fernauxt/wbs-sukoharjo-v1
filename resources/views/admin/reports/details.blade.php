@extends('layouts.admin')

@section('title', 'Detail Laporan')

@section('content')
    <div class="bg-white p-3 sm:p-4 lg:p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-3 sm:mb-4 lg:mb-4">
            <h2 class="text-lg sm:text-xl lg:text-xl font-semibold text-gray-700">Detail Laporan</h2>
            <a href="{{ route('admin.reports.index') }}" 
                class="text-blue-600 hover:text-blue-800 hover:underline text-xs sm:text-sm lg:text-sm font-medium flex items-center gap-1">
                <i class="fas fa-arrow-left"></i>
                <span class="hidden sm:inline">Kembali</span>
                <span class="sm:hidden">Kembali</span>
            </a>
        </div>

        <!--- General Info --->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-6">
            <div class="bg-gray-50 p-3 sm:p-4 lg:p-4 rounded-lg shadow">
                <h3 class="text-base sm:text-lg lg:text-lg font-semibold text-gray-700 mb-2 sm:mb-3">Informasi Laporan</h3>
                <p class="text-xs sm:text-sm lg:text-sm mb-2"><strong>Subjek:</strong> {{ $report->subject }}</p>
                <p class="text-xs sm:text-sm lg:text-sm mb-2"><strong>Tanggal Lapor:</strong> {{ $report->reported_at->format('d M Y H:i') }}</p>
                <p class="text-xs sm:text-sm lg:text-sm mb-2"><strong>Terlapor:</strong>
                    <br>
                <ul class="list-disc list-inside pl-4">
                    @foreach ($report->reportedParties as $reported)
                        <li class="text-xs sm:text-sm lg:text-sm">{{ $reported->reported_name }} - {{ $reported->reported_unit }}</li>
                    @endforeach
                </ul>
                </p>
                <p class="text-xs sm:text-sm lg:text-sm mb-2"><strong>Kategori:</strong> {{ $report->category->name ?? '-' }}</p>
                <p class="text-xs sm:text-sm lg:text-sm mb-2"><strong>Status:</strong> {{ $report->status->name }}</p>
                <p class="text-xs sm:text-sm lg:text-sm mb-2"><strong>Terakhir Diubah:</strong> {{ $report->followUp?->updated_at?->format('d M Y H:i') ?? '-' }} </p>
                <p class="mt-2 text-xs sm:text-sm lg:text-sm mb-2"><strong>Pelapor:</strong> {{ $report->informant->name ?? 'Anonim' }}</p>
                <p class="text-xs sm:text-sm lg:text-sm mb-2"><strong>Email:</strong> {{ $report->informant->email ?? '-' }} </p>
                <p class="text-xs sm:text-sm lg:text-sm"><strong>Telepon:</strong> {{ $report->informant->phone ?? '-' }}</p>

                <button type="button" id="followUpButton"
                    class="btn bg-blue-600 text-white rounded-md hover:bg-blue-800 text-xs sm:text-sm lg:text-sm mt-4 sm:mt-6 lg:mt-6 w-full sm:w-auto">
                    Tindaklanjuti Laporan
                </button>
            </div>

            @if ($report->attachments->isNotEmpty())
                <div class="bg-gray-50 p-3 sm:p-4 lg:p-4 rounded-lg shadow">
                    <h3 class="text-base sm:text-lg lg:text-lg font-semibold text-gray-700 mb-2 sm:mb-3">Lampiran</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-2 gap-2 sm:gap-3">
                        @foreach ($report->attachments as $attachment)
                            @if (Str::startsWith($attachment->file_type, 'image/'))
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="block">
                                    <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                        alt="{{ $attachment->file_name }}" class="w-24 h-24 sm:w-32 sm:h-32 lg:w-40 lg:h-40 object-cover rounded-md">
                                </a>
                            @else
                                <div class="flex items-center space-x-2">
                                    @if (Str::contains($attachment->file_type, 'pdf'))
                                        <i class="fas fa-file-pdf text-red-500 text-xl sm:text-2xl lg:text-2xl"></i>
                                    @elseif(Str::contains($attachment->file_type, 'word') || Str::endsWith($attachment->file_name, ['.doc', '.docx']))
                                        <i class="fas fa-file-word text-blue-500 text-xl sm:text-2xl lg:text-2xl"></i>
                                    @elseif(Str::contains($attachment->file_type, 'zip') || Str::endsWith($attachment->file_name, ['.zip', '.rar']))
                                        <i class="fas fa-file-archive text-yellow-500 text-xl sm:text-2xl lg:text-2xl"></i>
                                    @else
                                        <i class="fas fa-file-alt text-gray-500 text-xl sm:text-2xl lg:text-2xl"></i>
                                    @endif

                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                                        class="text-blue-600 hover:underline text-xs sm:text-sm lg:text-sm break-all">
                                        {{ $attachment->file_name }}
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-4 sm:mt-6 lg:mt-6 bg-gray-50 p-3 sm:p-4 lg:p-4 rounded-lg shadow">
            <h3 class="text-base sm:text-lg lg:text-lg font-semibold text-gray-700 mb-2 sm:mb-3">Deskripsi Pelanggaran</h3>
            <p class="text-xs sm:text-sm lg:text-sm text-gray-600 break-words">{{ $report->description }}</p>
        </div>

        <!-- Modal -->
        <div id="followUpModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
            <div class="bg-white rounded-lg shadow-lg w-full sm:w-11/12 md:w-3/4 lg:w-1/2 p-4 sm:p-6 lg:p-6 max-h-screen overflow-y-auto">
                <h2 class="text-lg sm:text-xl lg:text-xl font-bold mb-3 sm:mb-4 lg:mb-4">Tindaklanjuti Laporan</h2>
                <form method="POST" action="{{ route('admin.reports.update', $report->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Radio Button -->
                    <fieldset class="mb-4 sm:mb-6 lg:mb-6">
                        <legend class="text-base sm:text-lg lg:text-lg font-semibold mb-2 sm:mb-3">Status Tindak Lanjut</legend>
                        <div class="flex flex-col sm:flex-row sm:flex-wrap gap-2 sm:gap-3 lg:gap-4">
                            <label class="flex items-center text-xs sm:text-sm lg:text-sm cursor-pointer">
                                <input type="radio" name="status" value="diproses" class="mr-2"> Ditinjau (Proses)
                            </label>
                            <label class="flex items-center text-xs sm:text-sm lg:text-sm cursor-pointer">
                                <input type="radio" name="status" value="perlu-klarifikasi" class="mr-2"> Perlu Klarifikasi
                            </label>
                            <label class="flex items-center text-xs sm:text-sm lg:text-sm cursor-pointer">
                                <input type="radio" name="status" value="selesai" class="mr-2"> Selesai
                            </label>
                            <label class="flex items-center text-xs sm:text-sm lg:text-sm cursor-pointer">
                                <input type="radio" name="status" value="ditolak" class="mr-2"> Tolak
                            </label>
                        </div>
                    </fieldset>

                    <!-- Textarea -->
                    <fieldset class="mb-4 sm:mb-6 lg:mb-6">
                        <legend class="text-base sm:text-lg lg:text-lg font-semibold mb-2">Catatan</legend>
                        <textarea name="notes" class="textarea w-full h-24 sm:h-32 lg:h-32 text-xs sm:text-sm lg:text-sm" placeholder="Tambahkan catatan..."></textarea>
                    </fieldset>

                    <!-- File Upload -->
                    <fieldset class="mb-4 sm:mb-6 lg:mb-6">
                        <legend class="text-base sm:text-lg lg:text-lg font-semibold mb-2">Upload Bukti Pendukung</legend>
                        <input type="file" name="evidence[]" class="input w-full text-xs sm:text-sm lg:text-sm"
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip" multiple>
                        <p class="text-xs sm:text-xs lg:text-xs text-gray-500 mt-1">Format yang didukung: jpg, png, pdf. Maks 10 file.</p>
                    </fieldset>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 lg:gap-4 justify-end">
                        <button type="button" id="closeModalButton"
                            class="btn bg-gray-500 text-white rounded-md hover:bg-red-700 text-xs sm:text-sm lg:text-sm order-2 sm:order-1 w-full sm:w-auto">Batal</button>
                        <button type="submit"
                            class="btn bg-blue-600 text-white rounded-md hover:bg-blue-800 text-xs sm:text-sm lg:text-sm order-1 sm:order-2 w-full sm:w-auto">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
