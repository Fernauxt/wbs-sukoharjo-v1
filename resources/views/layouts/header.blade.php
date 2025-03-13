<header>
    <nav class="navbar bg-base-200 fixed top-0 z-50" data-aos="fade-down" data-aos-duration="1000">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="flex items-center" data-aos="fade-up-right" data-aos-duration="1000">
                <img src="https://wbs.sukoharjokab.go.id/images/wbs.png" class="h-9 sm:h-12 transition-transform duration-500 hover:scale-110" alt="Logo WBS" />
            </a>
            <!-- Tombol Hamburger -->
            <div class="navbar-end lg:hidden" data-aos="fade-up-left" data-aos-duration="1000">
                <label for="menu-toggle" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6h16.5M3.75 12h16.5m-7.5 6h7.5" />
                    </svg>
                </label>
            </div>
            <!-- Menu -->
            <input type="checkbox" id="menu-toggle" class="hidden peer" />
            <div class="hidden lg:flex gap-8 peer-checked:flex flex-col lg:flex-row absolute lg:static top-16 left-0 w-full lg:w-auto bg-base-100 lg:bg-transparent shadow-lg lg:shadow-none p-4 lg:p-0 transition-all duration-500 ease-in-out" data-aos="fade-up" data-aos-duration="1000">
                <a href="{{ route('home') }}" class="btn btn-ghost text-lg font-semibold mt-1.5 transition-colors duration-300 hover:text-amber-500 {{ request()->routeIs('home') ? 'text-amber-700' : '' }}">Beranda</a>
                <a href="#cara-pengaduan" class="btn btn-ghost text-lg font-semibold mt-1.5 transition-colors duration-300 hover:text-amber-500 {{ request()->is('#cara-pengaduan') ? 'text-amber-700' : '' }}">Tata Cara Pengaduan</a>
                <a href="{{ route('track-report') }}" class="btn btn-ghost text-lg font-semibold mt-1.5 transition-colors duration-300 hover:text-amber-500 {{ request()->routeIs('track-report') ? 'text-amber-700' : '' }}">Lacak Pengaduan</a>
                <a href="#kontak" class="btn btn-ghost text-lg font-semibold mt-1.5 transition-colors duration-300 hover:text-amber-500 {{ request()->is('#kontak') ? 'text-amber-700' : '' }}">Kontak</a>
                <button class="btn bg-amber-600 rounded-4xl p-6 text-lg text-white font-semibold hover:bg-red-700 hover:scale-105 transition-all duration-500 ease-in-out">Buat Pengaduan</button>
            </div>
        </div>
    </nav>
</header>
