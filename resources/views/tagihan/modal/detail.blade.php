<div id="detailModal"
    class="modal fixed inset-0 z-50 flex items-center justify-center hidden bg-white/90 dark:bg-gray-900/80 backdrop-blur-sm">
    <div
        class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 ease-in-out opacity-0 translate-y-10">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Detail Tagihan</h3>
                <button id="closeDetailModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <h4 class="text-lg font-semibold text-gray-800" id="detailKodeTagihan"></h4>
                    <p class="text-sm text-gray-500" id="detailStatus"></p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Pelanggan</p>
                        <p class="font-medium" id="detailPelanggan"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nomor Meter</p>
                        <p class="font-medium" id="detailNomorMeter"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Periode</p>
                        <p class="font-medium" id="detailPeriode"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Bayar</p>
                        <p class="font-medium" id="detailTanggalBayar">-</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between mb-2">
                        <p class="text-sm text-gray-500">Pemakaian</p>
                        <p class="font-medium" id="detailPemakaian"></p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-sm text-gray-500">Tarif per kWh</p>
                        <p class="font-medium" id="detailTarif"></p>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-blue-600">
                        <p>Total Tagihan</p>
                        <p id="detailTotalTagihan"></p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button id="closeDetailBtn"
                    class="px-6 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
