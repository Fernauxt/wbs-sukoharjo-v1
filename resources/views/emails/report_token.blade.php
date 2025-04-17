@extends('layouts.endpage')

@section('title', 'Pengaduan Terkirim')

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('https://wbs.sukoharjokab.go.id/images/wbs.png') }}" alt="Logo WBS" class="h-16">
        </div>

        <h1 class="text-2xl font-bold mb-4">Halo {{ $report->informant->name }}</h1>
        <p class="mb-4">Terima kasih telah mengirim laporan ke sistem kami.</p>

        <p class="mb-2 font-semibold">Token laporan Anda:</p>
        <div class="text-xl font-mono bg-gray-100 p-3 rounded text-blue-600 border border-blue-200">
            {{ $report->token }}
        </div>

        @if(Route::has('track.report'))
            <p class="mt-6">Untuk mengecek status laporan, klik tombol berikut:</p>
            <a href="{{ route('track.report', ['token' => $report->token]) }}"
               class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                Cek Status Laporan
            </a>
        @endif

        <p class="mt-6 text-sm text-gray-500">Salam,<br>Tim Whistle Blowing System</p>
    </div>
@endsection