@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card: Total Laporan -->
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 transition-transform duration-300 hover:shadow-lg hover:bg-red-50 hover:scale-[1.02]">
            <i class="fas fa-file-alt text-4xl text-red-600"></i>
            <div>
                <h3 class="text-sm text-gray-500">Total Laporan</h3>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ $totalReports }}</p>
            </div>
        </div>

        <!-- Card: Laporan Terkirim -->
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 transition-transform duration-300 hover:shadow-lg hover:bg-blue-50 hover:scale-[1.02]">
            <i class="fas fa-paper-plane text-4xl text-blue-600"></i>
            <div>
                <h3 class="text-sm text-gray-500">Terkirim</h3>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $sentReports }}</p>
            </div>
        </div>

        <!-- Card: Laporan Diproses -->
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 transition-transform duration-300 hover:shadow-lg hover:bg-yellow-50 hover:scale-[1.02]">
            <i class="fas fa-spinner text-4xl text-yellow-500 animate-spin"></i>
            <div>
                <h3 class="text-sm text-gray-500">Diproses</h3>
                <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $inProgressReports }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <!-- Card: Laporan Butuh Klarifikasi -->
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 transition-transform duration-300 hover:shadow-lg hover:bg-orange-50 hover:scale-[1.02]">
            <i class="fas fa-question-circle text-4xl text-orange-500"></i>
            <div>
                <h3 class="text-sm text-gray-500">Butuh Klarifikasi</h3>
                <p class="text-3xl font-bold text-orange-500 mt-1">{{ $needClarifyReports }}</p>
            </div>
        </div>

        <!-- Card: Laporan Selesai -->
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 transition-transform duration-300 hover:shadow-lg hover:bg-green-50 hover:scale-[1.02]">
            <i class="fas fa-check-circle text-4xl text-green-600"></i>
            <div>
                <h3 class="text-sm text-gray-500">Selesai</h3>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $completedReports }}</p>
            </div>
        </div>
    </div>

    <!-- Selamat Datang -->
    <div class="mt-10 bg-white p-6 shadow rounded-xl transition duration-300 hover:shadow-md hover:bg-gray-50">
        <h2 class="text-lg font-semibold text-gray-700"><i class="fas fa-user-shield mr-2 text-gray-500"></i>Halo, Admin!</h2>
        <p class="text-gray-600 mt-2">Selamat datang di panel pengelolaan pengaduan. Gunakan menu di sebelah kiri untuk mengakses data laporan.</p>
    </div>
@endsection
