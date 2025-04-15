<nav class="flex flex-col space-y-4">
    <a href="{{ route('admin.dashboard') }}"
        class="py-2 px-4 rounded-md hover:bg-gray-100 @if (request()->routeIs('admin.dashboard')) bg-gray-200 font-semibold @endif">
        🏠 Dashboard
    </a>

    <a href="{{ route('admin.reports.index') }}"
        class="py-2 px-4 rounded-md hover:bg-gray-100 @if (request()->routeIs('admin.reports.*')) bg-gray-200 font-semibold @endif">
        📄 Daftar Laporan
    </a>

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="py-2 px-4 rounded-md w-full text-left text-red-600 hover:bg-red-100">
            🚪 Logout
        </button>
    </form>
</nav>
