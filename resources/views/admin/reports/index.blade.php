@extends('layouts.admin')

@section('title', 'Daftar Laporan')

@section('content')
    <div class="bg-white p-3 sm:p-4 lg:p-6 rounded-xl shadow">
        <h2 class="text-lg sm:text-xl lg:text-xl font-semibold text-gray-700 mb-3 sm:mb-4 lg:mb-4">Daftar Laporan</h2>

        <!-- Filter Dropdown -->
        <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-4 sm:mb-6 lg:mb-4">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 lg:gap-4 items-start sm:items-center">
                <label for="status" class="text-xs sm:text-sm lg:text-sm font-medium text-gray-600 pt-2 sm:pt-0">Filter Status:</label>
                <select name="status" id="status" class="p-2 sm:p-2 lg:p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 text-xs sm:text-sm lg:text-base w-full sm:w-auto">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sm sm:btn-md lg:btn-md bg-blue-600 text-white rounded-md hover:bg-blue-700 text-xs sm:text-sm lg:text-sm w-full sm:w-auto">
                    Terapkan Filter
                </button>
            </div>
        </form>

        <!-- Table Responsive Wrapper -->
        <div class="overflow-x-auto -mx-3 sm:-mx-4 lg:-mx-0">
            <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm lg:text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left font-semibold text-gray-600">
                        <th class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 hidden lg:table-cell">No.</th>
                        <th class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2">Subjek</th>
                        <th class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 hidden md:table-cell">Tanggal</th>
                        <th class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 hidden md:table-cell">Kategori</th>
                        <th class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 hidden lg:table-cell">Pelapor</th>
                        <th class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 hidden lg:table-cell">Status</th>
                        <th class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2 hidden lg:table-cell">Terakhir Diubah</th>
                        <th class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-3 font-medium hidden lg:table-cell">{{ $loop->iteration }}</td>
                            <td class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-3">
                                @php
                                    $subjectWords = explode(' ', $report->subject ?? 'Laporan');
                                    $displaySubject = count($subjectWords) > 2 
                                        ? implode(' ', array_slice($subjectWords, 0, 2)) . '...' 
                                        : $report->subject;
                                @endphp
                                <span class="text-gray-700 font-medium" title="{{ $report->subject }}">{{ $displaySubject }}</span>
                            </td>
                            <td class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-3 hidden md:table-cell text-gray-600">{{ $report->reported_at ? $report->reported_at->format('d M Y') : '-' }}</td>
                            <td class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-3 hidden md:table-cell text-gray-600">{{ $report->category->name ?? '-' }}</td>
                            <td class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-3 hidden lg:table-cell text-gray-600">
                                {{ $report->informant->name ?? 'Anonim' }}
                            </td>
                            <td class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-3 hidden lg:table-cell">
                                <span class="px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap
                                    @switch($report->status->id)
                                        @case(1) bg-blue-100 text-blue-800 @break
                                        @case(2) bg-yellow-100 text-yellow-800 @break
                                        @case(3) bg-orange-100 text-orange-800 @break
                                        @case(4) bg-green-100 text-green-800 @break
                                        @default bg-gray-100 text-gray-600
                                    @endswitch
                                ">
                                    {{ $report->status->name }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-3 hidden lg:table-cell text-gray-600">
                                {{ $report->followUp?->updated_at?->format('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="px-3 sm:px-4 lg:px-4 py-2 sm:py-3 lg:py-3">
                                <a href="{{ route('admin.reports.show', $report->id) }}"
                                   class="text-blue-600 hover:underline text-xs sm:text-sm lg:text-sm font-medium whitespace-nowrap">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-3 sm:px-4 lg:px-4 py-4 text-center text-gray-500 text-xs sm:text-sm lg:text-sm">Belum ada laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection