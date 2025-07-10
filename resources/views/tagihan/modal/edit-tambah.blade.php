<div id="tagihanModal"
    class="modal fixed inset-0 z-50 flex items-center justify-center hidden bg-white/90 dark:bg-gray-900/80 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 ease-in-out opacity-0 translate-y-10"
        id="modalContent">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800" id="modalTitle">Tambah Tagihan</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="tagihanForm" method="POST">
                @csrf
                <div id="formMethod"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="pelanggan_id" class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                        <select id="pelanggan_id" name="pelanggan_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Pelanggan</option>
                            @foreach (App\Models\Pelanggan::all() as $pelanggan)
                                <option value="{{ $pelanggan->id }}"
                                    data-tarif="{{ $pelanggan->tarif->harga_per_kwh }}">
                                    {{ $pelanggan->nama_pelanggan }} ({{ $pelanggan->nomor_meter }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="kode_tagihan" class="block text-sm font-medium text-gray-700 mb-1">Kode
                            Tagihan</label>
                        <input type="text" id="kode_tagihan" name="kode_tagihan" readonly
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="periode_tagihan" class="block text-sm font-medium text-gray-700 mb-1">Periode
                            Tagihan</label>
                        <input type="month" id="periode_tagihan" name="periode_tagihan" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="meter_awal" class="block text-sm font-medium text-gray-700 mb-1">Meter Awal
                            (kWh)</label>
                        <input type="number" step="0.01" id="meter_awal" name="meter_awal" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="meter_akhir" class="block text-sm font-medium text-gray-700 mb-1">Meter Akhir
                            (kWh)</label>
                        <input type="number" step="0.01" id="meter_akhir" name="meter_akhir" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemakaian (kWh)</label>
                        <div class="px-4 py-2 bg-gray-100 rounded-lg" id="pemakaianDisplay">0</div>
                        <input type="hidden" id="pemakaian" name="pemakaian">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Tagihan</label>
                        <div class="px-4 py-2 bg-gray-100 rounded-lg" id="totalTagihanDisplay">Rp 0</div>
                        <input type="hidden" id="total_tagihan" name="total_tagihan">
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelModal"
                        class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
