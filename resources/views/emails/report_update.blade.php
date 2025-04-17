@extends('layouts.endpage')

@section('title', 'Pengaduan Diperbarui')

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo-wbs.png') }}" alt="Logo WBS" class="h-16">
        </div>

        <h1 class="text-xl font-bold mb-4 text-center">Hai {{ $report->informant->name }}</h1>

        <p class="mb-2">Status laporan dengan subjek:</p>
        <p class="font-semibold">"{{ $report->subject }}"</p>

        <p class="mt-4">Telah diperbarui menjadi:</p>
        <div class="text-lg font-bold text-blue-600">{{ ucwords(str_replace('-', ' ', $statusName)) }}</div>

        @if ($notes)
            <div class="mt-4">
                <p class="font-semibold">Catatan dari Admin:</p>
                <p class="bg-gray-100 p-3 rounded text-sm text-gray-700 italic">{{ $notes }}</p>
            </div>
        @endif

        @if(Route::has('track.report'))
            <p class="mt-6">Klik tombol berikut untuk melihat status laporan Anda secara lengkap:</p>
            <a href="{{ route('track.report', ['token' => $report->token]) }}"
               class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                Cek Status Laporan
            </a>
        @endif

        <p class="mt-6 text-sm text-gray-500">Terima kasih,<br>Tim Whistle Blowing System</p>
    </div>
@endsection