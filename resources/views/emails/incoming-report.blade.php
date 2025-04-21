@extends('layouts.endpage')

@section('title', 'Detail Laporan Baru')

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('https://wbs.sukoharjokab.go.id/images/wbs.png') }}" alt="Logo WBS" class="h-16">
        </div>

        <h1 class="text-2xl font-bold mb-4">Halo {{ $admin->username }}</h1>
        <p class="mb-4">Ada laporan baru yang diterima. Berikut adalah detail singkatnya:</p>

        <p class="mb-2 font-semibold">Judul Laporan:</p>
        <div class="text-lg bg-gray-100 p-3 rounded border border-gray-200">
            {{ $report->subject }}
        </div>

        <p class="mt-4 mb-2 font-semibold">Deskripsi Singkat:</p>
        <div class="text-sm bg-gray-100 p-3 rounded border border-gray-200">
            {{ Str::limit($report->description, 150) }}
        </div>

        <p class="mt-4 mb-2 font-semibold">Tanggal Laporan:</p>
        <div class="text-sm bg-gray-100 p-3 rounded border border-gray-200">
            {{ $report->reported_at->format('d M Y H:i') }}
        </div>

        <p class="mt-4 mb-2 font-semibold">Token Laporan:</p>
        <div class="text-xl font-mono bg-gray-100 p-3 rounded text-blue-600 border border-blue-200">
            {{ $report->token }}
        </div>

        @if(Route::has('report.details'))
            <p class="mt-6">Untuk melihat detail lengkap laporan, klik tombol berikut:</p>
            <a href="{{ route('report.details', ['token' => $report->token]) }}"
               class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                Lihat Detail Laporan
            </a>
        @endif

        <p class="mt-6 text-sm text-gray-500">Salam,<br>Tim Whistle Blowing System</p>
    </div>
@endsection