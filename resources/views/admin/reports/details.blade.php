@extends('layouts.admin')

@section('title', 'Detail Laporan')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Detail Laporan</h2>

        <!--- General Informasi --->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Laporan</h3>
                <p><strong>Subjek:</strong> {{ $report->subject }}</p>
                <p><strong>Tanggal Lapor:</strong> {{ $report->reported_at->format('d M Y H:i') }}</p>
                <p><strong>Terlapor:</strong>
                    <br>
                <ul class="list-disc list-inside pl-4">
                    @foreach ($report->reportedParties as $reported)
                        <li>{{ $reported->reported_name }} - {{ $reported->reported_unit }}</li>
                    @endforeach
                </ul>
                </p>
                <p class="mt-2"><strong>Pelapor:</strong> {{ $report->informant->name ?? 'Anonim' }}</p>
                <p><strong>Kategori:</strong> {{ $report->category->name ?? '-' }}</p>
                <p><strong>Status:</strong> {{ $report->status->name }}</p>
                <p><strong>Terakhir Diubah:</strong> {{ $report->followUp->updated_at->format('d M Y H:i') }} </p>
                <button type="button" id="followUpButton"
                    class="btn bg-blue-600 text-white rounded-md hover:bg-blue-800 text-sm mt-6">
                    Tindaklanjuti Laporan
                </button>
            </div>

            @if ($report->attachments->isNotEmpty())
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Lampiran</h3>
                    @foreach ($report->attachments as $attachment)
                        @if (Str::startsWith($attachment->file_type, 'image/'))
                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                    alt="{{ $attachment->file_name }}" class="w-48 h-48 object-cover rounded-md mb-2">
                            </a>
                        @else
                            <div class="flex items-center space-x-2 mb-2">
                                @if (Str::contains($attachment->file_type, 'pdf'))
                                    <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                                @elseif(Str::contains($attachment->file_type, 'word') || Str::endsWith($attachment->file_name, ['.doc', '.docx']))
                                    <i class="fas fa-file-word text-blue-500 text-2xl"></i>
                                @elseif(Str::contains($attachment->file_type, 'zip') || Str::endsWith($attachment->file_name, ['.zip', '.rar']))
                                    <i class="fas fa-file-archive text-yellow-500 text-2xl"></i>
                                @else
                                    <i class="fas fa-file-alt text-gray-500 text-2xl"></i>
                                @endif

                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                                    class="text-blue-600 hover:underline">
                                    {{ $attachment->file_name }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-6 bg-gray-50 p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Deskripsi Pelanggaran</h3>
            <p>{{ $report->description }}</p>
        </div>

        <!-- Modal -->
        <div id="followUpModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6">
                <h2 class="text-xl font-bold mb-4">Tindaklanjuti Laporan</h2>
                <form method="POST" action="{{ route('admin.reports.update', $report->id) }}" enctype="multipart/form-data" >
                    @csrf
                    <!-- Radio Button -->
                    <fieldset class="mb-4">
                        <legend class="text-lg font-semibold">Status Tindak Lanjut</legend>
                        <div class="flex items-center space-x-4">
                            <label>
                                <input type="radio" name="status" value="in-review" class="mr-2"> Ditinjau
                            </label>
                            <label>
                                <input type="radio" name="status" value="need-clarify" class="mr-2"> Perlu Klarifikasi
                            </label>
                            <label>
                                <input type="radio" name="status" value="resolved" class="mr-2"> Selesai
                            </label>
                        </div>
                    </fieldset>
                    
                    <!-- Textarea -->
                    <fieldset class="mb-4">
                        <legend class="text-lg font-semibold">Catatan</legend>
                        <textarea name="notes" class="textarea w-full h-32" placeholder="Tambahkan catatan..."></textarea>
                    </fieldset>

                    <!-- File Upload -->
                    <fieldset class="mb-4">
                        <legend class="text-lg font-semibold">Upload Bukti Pendukung</legend>
                        <input type="file" name="evidence[]" class="input w-full" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip" multiple>
                        <p class="text-sm text-gray-500 mt-1">Format yang didukung: jpg, png, pdf. Maks 10 file.</p>
                    </fieldset>

                    <!-- Tombol -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" id="closeModalButton"
                            class="btn bg-gray-500 text-white rounded-md hover:bg-red-700">Batal</button>
                        <button type="submit"
                            class="btn bg-blue-600 text-white rounded-md hover:bg-blue-800">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
