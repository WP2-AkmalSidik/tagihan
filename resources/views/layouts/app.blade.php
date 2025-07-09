<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplikasi Penggajian - PT Argo Industri</title>
    
    @vite('resources/css/app.css')
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-emerald-600 text-white shadow-lg">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                    <span class="text-xl font-bold">PT Argo Industri</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-200 transition">
                        <i class="fas fa-home mr-2"></i> Dashboard
                    </a>
                    <a href="{{ route('karyawan.index') }}" class="hover:text-emerald-200 transition">
                        <i class="fas fa-users mr-2"></i> Karyawan
                    </a>
                    <a href="{{ route('jabatan.index') }}" class="hover:text-emerald-200 transition">
                        <i class="fas fa-briefcase mr-2"></i> Jabatan
                    </a>
                    <a href="{{ route('gaji.index') }}" class="hover:text-emerald-200 transition">
                        <i class="fas fa-calculator mr-2"></i> Penggajian
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="hidden md:block">
                        <span class="mr-2">{{ Auth::user()->name }}</span>
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 px-3 py-1 rounded transition">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} PT Argo Industri. All rights reserved.</p>
            </div>
        </footer>
    </div>

    @stack('scripts')
    
    <script>
        // SweetAlert untuk pesan flash
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
        
        // Konfirmasi sebelum menghapus
        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit();
                }
            });
        }
    </script>
</body>
</html>