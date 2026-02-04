<header class="bg-white shadow p-3 sm:p-4 lg:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 lg:gap-6">
    <div class="flex-1">
        <h2 class="text-base sm:text-lg lg:text-xl font-semibold capitalize break-words">
            Admin Panel WBS Kabupaten Sukoharjo
        </h2>
    </div>

    <div class="flex items-center space-x-2 sm:space-x-3 lg:space-x-4 flex-shrink-0">
        <span class="text-gray-600 text-xs sm:text-sm lg:text-base whitespace-nowrap">
            👤 {{ session('admin_id') ? 'Admin #' . session('admin_id') : 'Guest' }}
        </span>
    </div>
</header>
