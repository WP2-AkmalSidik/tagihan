@extends('layouts.app')

@section('title', 'Tagihan Listrik')
@section('text', 'Kelola semua tagihan listrik pelanggan dengan mudah')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 rounded-full p-2">
                        <i class="fas fa-file-invoice text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Data Tagihan Listrik</h3>
                    </div>
                </div>
                <button onclick="showCreateModal()"
                    class="bg-white/20 hover:bg-white/30 text-white px-6 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Tagihan</span>
                </button>
            </div>
        </div>
        <!-- tagihan -->
        <!-- Search Form -->
        <div class="p-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
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

                <!-- Table -->
                <div class="border border-gray-100 rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr
                                class="text-left text-sm font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                <th class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-hashtag text-gray-400"></i>
                                        <span>Kode Tagihan</span>
                                    </div>
                                </th>
                                <th class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user text-gray-400"></i>
                                        <span>Pelanggan</span>
                                    </div>
                                </th>
                                <th class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                        <span>Periode</span>
                                    </div>
                                </th>
                                <th class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-tachometer-alt text-gray-400"></i>
                                        <span>Pemakaian</span>
                                    </div>
                                </th>
                                <th class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-money-bill-wave text-gray-400"></i>
                                        <span>Total</span>
                                    </div>
                                </th>
                                <th class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-info-circle text-gray-400"></i>
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-cog text-gray-400"></i>
                                        <span>Aksi</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($tagihan as $item)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-800">{{ $item->kode_tagihan }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-800">
                                                {{ $item->pelanggan->nama_pelanggan }}
                                            </div>
                                            <div class="text-gray-500 text-xs mt-0.5">{{ $item->pelanggan->nomor_meter }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-800">{{ $item->periode_tagihan->format('M Y') }}</div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-800">{{ number_format($item->pemakaian, 0) }} kWh
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-800">Rp
                                            {{ number_format($item->total_tagihan, 0) }}</div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if ($item->status == 'belum_bayar')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                                Belum Bayar
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-600 border border-green-100">
                                                <i class="fas fa-check-circle mr-1.5"></i>
                                                Sudah Bayar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-1.5">
                                            <button onclick="showDetailModal({{ $item->id }})"
                                                class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors"
                                                title="Detail">
                                                <i class="fas fa-eye text-xs"></i>
                                            </button>
                                            @if ($item->status == 'belum_bayar')
                                                <button onclick="konfirmasiBayar({{ $item->id }})"
                                                    class="p-2 rounded-lg bg-green-100 hover:bg-green-200 text-green-600 transition-colors"
                                                    title="Bayar">
                                                    <i class="fas fa-money-bill-wave text-xs"></i>
                                                </button>
                                            @endif
                                            <button onclick="showEditModal({{ $item->id }})"
                                                class="p-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-600 transition-colors"
                                                title="Edit">
                                                <i class="fas fa-edit text-xs"></i>
                                            </button>
                                            <button onclick="konfirmasiHapus({{ $item->id }})"
                                                class="p-2 rounded-lg bg-red-100 hover:bg-red-200 text-red-600 transition-colors"
                                                title="Hapus">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3 text-gray-400">
                                            <i class="fas fa-inbox text-3xl"></i>
                                            <div>
                                                <p class="font-medium">Tidak ada data tagihan</p>
                                                <p class="text-sm">Silakan tambahkan tagihan baru</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagination -->
    @if ($tagihan->hasPages())
        <div class="mt-8 flex justify-center">
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                {{-- Previous Page Link --}}
                @if ($tagihan->onFirstPage())
                    <span
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 bg-white cursor-not-allowed">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $tagihan->previousPageUrl() }}"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-700 ring-1 ring-inset ring-gray-300 bg-white hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($tagihan->links()->elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 bg-white">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $tagihan->currentPage())
                                <span aria-current="page"
                                    class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 bg-white hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($tagihan->hasMorePages())
                    <a href="{{ $tagihan->nextPageUrl() }}"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-700 ring-1 ring-inset ring-gray-300 bg-white hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 bg-white cursor-not-allowed">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </nav>
        </div>
    @endif
    <!-- Modal Tambah/Edit Tagihan -->
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
                            <label for="pelanggan_id"
                                class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
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

    <!-- Modal Detail Tagihan -->
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
    <script>
        // Modal Control
        function showCreateModal() {
            const modal = document.getElementById('tagihanModal');
            const modalContent = document.getElementById('modalContent');
            const form = document.getElementById('tagihanForm');


            document.getElementById('modalTitle').textContent = 'Tambah Tagihan';
            form.action = "{{ route('tagihan.store') }}";
            document.getElementById('formMethod').innerHTML = '';
            form.reset();
            document.getElementById('kode_tagihan').value = 'TGH-' + Math.random().toString(36).substr(2, 8).toUpperCase();
            document.getElementById('pemakaianDisplay').textContent = '0';
            document.getElementById('totalTagihanDisplay').textContent = 'Rp 0';


            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('opacity-0');
                modalContent.classList.remove('translate-y-10');
            }, 20);
        }

        function showEditModal(id) {
            const modal = document.getElementById('tagihanModal');
            const modalContent = document.getElementById('modalContent');
            const form = document.getElementById('tagihanForm');

            // Tampilkan modal segera (tanpa menunggu fetch selesai)
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('opacity-0');
                modalContent.classList.remove('translate-y-10');
            }, 20);

            // Tambahkan loading state jika perlu
            document.getElementById('modalTitle').textContent = 'Memuat...';

            fetch(`/tagihan/${id}/edit`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Set form action dan method
                    form.action = `/tagihan/${id}`;
                    document.getElementById('formMethod').innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
            `;

                    // Isi form dengan data
                    document.getElementById('modalTitle').textContent = 'Edit Tagihan';
                    document.getElementById('pelanggan_id').value = data.pelanggan_id;
                    document.getElementById('kode_tagihan').value = data.kode_tagihan;
                    document.getElementById('periode_tagihan').value = data.periode_tagihan.substring(0, 7);
                    document.getElementById('meter_awal').value = data.meter_awal;
                    document.getElementById('meter_akhir').value = data.meter_akhir;
                    document.getElementById('pemakaian').value = data.pemakaian;
                    document.getElementById('pemakaianDisplay').textContent = data.pemakaian;
                    document.getElementById('total_tagihan').value = data.total_tagihan;
                    document.getElementById('totalTagihanDisplay').textContent = 'Rp ' +
                        new Intl.NumberFormat('id-ID').format(data.total_tagihan);
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data tagihan',
                    });
                    closeModal();
                });
        }

        function showDetailModal(id) {
            const modal = document.getElementById('detailModal');
            const modalContent = modal.querySelector('div');


            fetch(`/tagihan/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailKodeTagihan').textContent = data.kode_tagihan;
                    document.getElementById('detailStatus').innerHTML = data.status === 'belum_bayar' ?
                        '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Belum Bayar</span>' :
                        '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Sudah Bayar</span>';


                    document.getElementById('detailPelanggan').textContent = data.pelanggan.nama_pelanggan;
                    document.getElementById('detailNomorMeter').textContent = data.pelanggan.nomor_meter;
                    document.getElementById('detailPeriode').textContent = new Date(data.periode_tagihan)
                        .toLocaleDateString('id-ID', {
                            month: 'long',
                            year: 'numeric'
                        });
                    document.getElementById('detailPemakaian').textContent = data.pemakaian + ' kWh';
                    document.getElementById('detailTarif').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                        data.pelanggan.tarif.harga_per_kwh);
                    document.getElementById('detailTotalTagihan').textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                        .format(data.total_tagihan);


                    if (data.tanggal_bayar) {
                        document.getElementById('detailTanggalBayar').textContent = new Date(data.tanggal_bayar)
                            .toLocaleDateString('id-ID');
                    } else {
                        document.getElementById('detailTanggalBayar').textContent = '-';

                    }

                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modalContent.classList.remove('opacity-0');
                        modalContent.classList.remove('translate-y-10');
                    }, 20);
                });
        }

        // Close modal functions
        function closeModal() {
            const modal = document.getElementById('tagihanModal');
            const modalContent = document.getElementById('modalContent');


            modalContent.classList.add('opacity-0');
            modalContent.classList.add('translate-y-10');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            const modalContent = modal.querySelector('div');


            modalContent.classList.add('opacity-0');
            modalContent.classList.add('translate-y-10');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Event listeners
        document.getElementById('closeModal').addEventListener('click', closeModal);
        document.getElementById('cancelModal').addEventListener('click', closeModal);
        document.getElementById('closeDetailModal').addEventListener('click', closeDetailModal);
        document.getElementById('closeDetailBtn').addEventListener('click', closeDetailModal);

        // Hitung pemakaian dan total tagihan secara otomatis
        document.getElementById('meter_akhir').addEventListener('input', calculateUsage);
        document.getElementById('meter_awal').addEventListener('input', calculateUsage);
        document.getElementById('pelanggan_id').addEventListener('change', calculateUsage);

        function calculateUsage() {
            const meterAwal = parseFloat(document.getElementById('meter_awal').value) || 0;
            const meterAkhir = parseFloat(document.getElementById('meter_akhir').value) || 0;
            const pelangganSelect = document.getElementById('pelanggan_id');
            const tarif = parseFloat(pelangganSelect.options[pelangganSelect.selectedIndex]?.dataset.tarif) || 0;


            if (meterAkhir < meterAwal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Meter akhir tidak boleh kurang dari meter awal',
                });
                document.getElementById('meter_akhir').value = '';
                return;
            }


            const pemakaian = meterAkhir - meterAwal;
            const totalTagihan = pemakaian * tarif;


            document.getElementById('pemakaian').value = pemakaian;
            document.getElementById('pemakaianDisplay').textContent = pemakaian.toFixed(2);
            document.getElementById('total_tagihan').value = totalTagihan;
            document.getElementById('totalTagihanDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                totalTagihan);
        }

        function konfirmasiBayar(id) {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin ingin memproses pembayaran ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#EF4444',
                confirmButtonText: 'Ya, Bayar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/tagihan/${id}/bayar`;

                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';
                    form.appendChild(token);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus tagihan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/tagihan/${id}`;

                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';
                    form.appendChild(token);

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3B82F6',
            });
        @endif
    </script>
@endsection
