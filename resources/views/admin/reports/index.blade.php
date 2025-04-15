@extends('layouts.admin')

@section('title', 'Daftar Laporan')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Daftar Laporan</h2>

        <!-- Filter Dropdown -->
        <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-4">
            <div class="flex items-center space-x-4">
                <label for="status" class="text-sm font-medium text-gray-600">Filter Status:</label>
                <select name="status" id="status" class="p-2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                    Terapkan Filter
                </button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-600">
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Tanggal Lapor</th>
                        <th class="px-4 py-2">Pelapor</th>
                        <th class="px-4 py-2">Kategori</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Terakhir Diubah</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $report->reported_at ? $report->reported_at->format('d M Y') : '-' }}</td>
                            <td class="px-4 py-3">
                                {{ $report->informant->name ?? 'Anonim' }}
                            </td>
                            <td class="px-4 py-3">{{ $report->category->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
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
                            <td>
                                {{ optional($report->followUp->modified_at)->format('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.reports.show', $report->id) }}"
                                   class="text-blue-600 hover:underline text-sm font-medium">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection