@extends('layouts.endpage')

@section('title', 'Pengaduan Berhasil')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="bg-white shadow-xl rounded-2xl p-8 max-w-2xl w-full text-center">
        <div class="flex justify-center mb-4">
            <div class="bg-green-100 text-green-600 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold mb-2 text-gray-800">Laporan Terkirim!</h2>
        <p class="text-gray-600 mb-4">Terima kasih, laporan Anda telah berhasil dikirim.</p>

        <div class="bg-gray-100 rounded-xl px-4 py-3 mb-4 text-sm text-gray-800">
            Token Laporan Anda:<br>
            <span class="font-mono text-3xl font-semibold text-gray-900">{{ $token }}</span>
        </div>

        <p class="text-gray-500 mb-2">Simpan token ini untuk melihat status laporan Anda.</p>

        <a href="{{ route('home') }}"
            class="inline-block mt-4 px-6 py-2 bg-amber-600 text-white rounded-full hover:bg-amber-900 transition">
            Kembali ke Beranda
        </a>
        <a href="{{ route('report') }}"
            class="inline-block mt-4 px-6 py-2 bg-red-800 text-white rounded-full hover:bg-red-900 transition">
            Buat Pengaduan Baru
        </a>
    </div>
</div>
@endsection