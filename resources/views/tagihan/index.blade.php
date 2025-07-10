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
        <div class="p-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Search Form -->
                @include('tagihan.pencarian')

                <!-- Table -->
                @include('tagihan.table')
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @include('tagihan.pagination')

    <!-- Modal Tambah/Edit Tagihan -->
    @include('tagihan.modal.edit-tambah')

    <!-- Modal Detail Tagihan -->
    @include('tagihan.modal.detail')

    @include('tagihan.js.script')
@endsection
