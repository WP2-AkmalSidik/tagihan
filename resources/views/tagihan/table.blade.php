<div class="border border-gray-100 rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr class="text-left text-sm font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100">
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
