<!-- Mobile Toggle Button -->
<input type="checkbox" id="sidebar-toggle" class="hidden peer" />

<div class="lg:hidden flex items-center justify-between p-4 bg-white border-b">
    <label for="sidebar-toggle" class="inline-flex items-center justify-center w-10 h-10 bg-amber-600 hover:bg-amber-700 text-white rounded-md cursor-pointer transition-colors duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </label>
    <span class="text-sm font-semibold text-gray-700">Menu</span>
</div>

<!-- Overlay for Mobile -->
<label for="sidebar-toggle" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden peer-checked:block lg:hidden"></label>

<!-- Sidebar Navigation -->
<nav class="fixed left-0 top-0 h-screen w-64 bg-white shadow-lg transform -translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-in-out z-30 lg:static lg:transform-none lg:translate-x-0 lg:h-auto lg:w-auto lg:bg-transparent lg:shadow-none lg:p-0 flex flex-col space-y-2 p-6 pt-20 lg:pt-0 lg:space-y-3">
    
    <!-- Close Button (Mobile Only) -->
    <label for="sidebar-toggle" class="lg:hidden absolute top-4 right-4 inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-700 cursor-pointer">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </label>

    <!-- Navigation Items -->
    <a href="{{ route('admin.dashboard') }}"
        class="py-2.5 px-4 rounded-md text-sm lg:text-base hover:bg-gray-100 transition-colors duration-200 @if (request()->routeIs('admin.dashboard')) bg-gray-200 font-semibold @endif">
        🏠 Dashboard
    </a>

    <a href="{{ route('admin.reports.index') }}"
        class="py-2.5 px-4 rounded-md text-sm lg:text-base hover:bg-gray-100 transition-colors duration-200 @if (request()->routeIs('admin.reports.*')) bg-gray-200 font-semibold @endif">
        📄 Daftar Laporan
    </a>

    <form action="{{ route('admin.logout') }}" method="POST" class="pt-4 border-t border-gray-200 lg:border-t-0 lg:pt-0">
        @csrf
        <button type="submit" class="py-2.5 px-4 rounded-md w-full text-left text-sm lg:text-base text-red-600 hover:bg-red-100 transition-colors duration-200">
            🚪 Logout
        </button>
    </form>
</nav>
