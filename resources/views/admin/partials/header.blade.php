<header class="bg-white shadow p-4 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-semibold capitalize">
            Admin Panel WBS Kabupaten Sukoharjo
        </h2>
    </div>

    <div class="flex items-center space-x-4">
        <span class="text-gray-600 text-sm">
            👤 {{ session('admin_id') ? 'Admin #' . session('admin_id') : 'Guest' }}
        </span>
        {{-- Bisa diganti nanti pakai nama admin --}}
    </div>
</header>
