<form method="GET" action="#" class="flex flex-col md:flex-row md:items-center gap-4 mb-6">
    <div class="flex-1 relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
            <i class="fas fa-search"></i>
        </div>
        <input type="text" name="search" value="{{ request('search') }}"
            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition-all"
            placeholder="Cari berdasarkan nama, nomor meter, atau kode tagihan...">
    </div>
    <div class="flex gap-2">
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2.5 rounded-lg font-medium flex items-center gap-2 transition-colors">
            <i class="fas fa-search"></i>
            <span>Cari</span>
        </button>
        <a href="{{ route('tagihan.index') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg font-medium flex items-center gap-2 transition-colors">
            <i class="fas fa-refresh"></i>
            <span>Reset</span>
        </a>
    </div>
</form>
