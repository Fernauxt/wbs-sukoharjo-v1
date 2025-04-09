@extends('layouts.main')

@section('title', 'Pengaduan Berhasil')

@section('content')
    <div class="hero min-h-screen bg-gradient-to-b from-base-200 to-base-100">
        <div class="hero-content flex flex-col items-center text-center">
            <div class="max-w-9xl" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="text-1xl font-base text-gray-900 lg:text-5xl lg:pt-10" data-aos="fade-down" data-aos-delay="100"
                    data-aos-duration="1000">
                    Laporan Anda Telah Dikirim
                </h1>
                <h1 class="text-2xl font-bold uppercase text-gray-900 pt-4 lg:text-6xl" data-aos="zoom-in"
                    data-aos-delay="200" data-aos-duration="1000">
                    Whistleblowing System <br> Kabupaten Sukoharjo
                </h1>
                <p class="pt-7 text-base text-gray-900 lg:text-xl" data-aos="fade-in" data-aos-delay="300"
                    data-aos-duration="1000">
                    Terima kasih telah mendukung transparansi pemerintahan yang bersih dan terpercaya.
                </p>
                <p class="text-sm pt-1 text-gray-900 lg:text-lg" data-aos="fade-in" data-aos-delay="400"
                    data-aos-duration="1000">
                    Identitas Anda aman dan dirahasiakan. Laporan Anda akan segera diproses.
                </p>

                @if (session('token'))
                    <div class="mt-6 p-6 rounded-xl bg-white shadow-lg border border-amber-300 max-w-md mx-auto"
                        data-aos="zoom-in-up" data-aos-delay="500" data-aos-duration="1000">
                        <h2 class="text-xl font-semibold text-gray-800">Kode Laporan Anda:</h2>
                        <div class="text-3xl font-bold text-amber-600 tracking-widest mt-2">
                            {{ session('token') }}
                        </div>
                        <p class="mt-2 text-gray-600 text-sm">Catat atau simpan kode ini untuk memantau perkembangan laporan
                            Anda.</p>
                    </div>
                @endif

                <a href="{{ route('report') }}"
                    class="btn bg-amber-600 rounded-4xl mt-8 p-6 text-lg text-white font-semibold hover:bg-red-700 hover:scale-105 transition-all duration-500 ease-in-out">
                    Buat Pengaduan Baru
                </a>
            </div>

            <div class="mt-10" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
                <img src="{{ asset('img/img-hero.png') }}" alt="Ilustrasi Input Laporan" class="h-105" />
            </div>
        </div>
    </div>
@endsection
