@extends('layouts.app')
@section('title', 'Dashboard Administrator')
@section('text', 'Selamat datang di sistem pengelolaan listrik pascabayar')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Users</p>
                    <p class="text-3xl font-bold">{{ $total_users }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Pelanggan</p>
                    <p class="text-3xl font-bold">{{ $total_pelanggan }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-user-friends text-2xl"></i>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Total Tarif</p>
                    <p class="text-3xl font-bold">{{ $total_tarif }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Total Tagihan</p>
                    <p class="text-3xl font-bold">{{ $total_tagihan }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-file-invoice text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
            <div class="flex items-center space-x-4 mb-4">
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Kelola User</h3>
            </div>
            <p class="text-gray-600 mb-4">Mengelola data pengguna sistem</p>
            <button onclick="showComingSoon()"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                <i class="fas fa-cog"></i>
                <span>Kelola</span>
            </button>
        </div>

        <div
            class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
            <div class="flex items-center space-x-4 mb-4">
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Kelola Tarif</h3>
            </div>
            <p class="text-gray-600 mb-4">Mengelola tarif listrik pascabayar</p>
            <button onclick="showComingSoon()"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                <i class="fas fa-cog"></i>
                <span>Kelola</span>
            </button>
        </div>

        <div
            class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100">
            <div class="flex items-center space-x-4 mb-4">
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-user-friends text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Kelola Pelanggan</h3>
            </div>
            <p class="text-gray-600 mb-4">Mengelola data pelanggan listrik</p>
            <button onclick="showComingSoon()"
                class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                <i class="fas fa-cog"></i>
                <span>Kelola</span>
            </button>
        </div>
    </div>

    <!-- Main Feature - Kelola Tagihan -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 rounded-full p-2">
                        <i class="fas fa-file-invoice text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Kelola Data Tagihan</h3>
                        <p class="text-indigo-100">Sistem pengelolaan tagihan listrik lengkap</p>
                    </div>
                </div>
                <a href="{{ route('tagihan.index') }}"
                    class="bg-white/20 hover:bg-white/30 text-white px-6 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Buka Aplikasi</span>
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Status Tagihan</h4>
                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                        <div class="flex items-center space-x-3">
                            <div class="bg-red-100 rounded-full p-2">
                                <i class="fas fa-exclamation-circle text-red-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-red-900">Belum Dibayar</p>
                                <p class="text-sm text-red-600">Tagihan pending</p>
                            </div>
                        </div>
                        <span class="text-2xl font-bold text-red-600">{{ $tagihan_belum_bayar }}</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-100 rounded-full p-2">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-green-900">Sudah Dibayar</p>
                                <p class="text-sm text-green-600">Tagihan lunas</p>
                            </div>
                        </div>
                        <span class="text-2xl font-bold text-green-600">{{ $tagihan_sudah_bayar }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Fitur Tersedia</h4>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-check text-green-500"></i>
                            <span>Lihat semua tagihan</span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-check text-green-500"></i>
                            <span>Tambah tagihan baru</span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-check text-green-500"></i>
                            <span>Edit & hapus tagihan</span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-check text-green-500"></i>
                            <span>Pencarian tagihan</span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-check text-green-500"></i>
                            <span>Proses pembayaran</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showComingSoon() {
            Swal.fire({
                icon: 'info',
                title: 'Coming Soon!',
                text: 'Fitur ini akan segera tersedia dalam update berikutnya.',
                confirmButtonColor: '#3B82F6',
            });
        }
    </script>
@endsection
