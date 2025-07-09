<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Aplikasi Listrik Pascabayar</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl p-10 max-w-md w-full text-center transform transition-all duration-300 hover:scale-[1.02] border border-white/20">
        <div class="mb-8">
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center shadow-lg">
                <i class="fas fa-bolt text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">
                PT Argo Industri
            </h1>
            <p class="text-blue-100 text-lg">
                Sistem Pembayaran Listrik Pascabayar
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-blue-200"></i>
                </div>
                <input type="email" name="email" required 
                       class="w-full pl-10 pr-4 py-4 bg-white/10 border border-white/20 rounded-2xl placeholder-blue-200 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300"
                       placeholder="Email Address" value="{{ old('email') }}">
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-blue-200"></i>
                </div>
                <input type="password" name="password" required 
                       class="w-full pl-10 pr-4 py-4 bg-white/10 border border-white/20 rounded-2xl placeholder-blue-200 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300"
                       placeholder="Password">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-blue-100">
                    <input type="checkbox" name="remember" class="mr-2 rounded">
                    Ingat Saya
                </label>
                <a href="#" class="text-blue-200 hover:text-white transition-colors">
                    Lupa Password?
                </a>
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center space-x-2">
                <i class="fas fa-sign-in-alt"></i>
                <span>LOGIN</span>
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-blue-100 text-sm">
                Demo Login: admin@listrik.com / password
            </p>
        </div>
    </div>

    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal!',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#3B82F6',
            });
        @endif
    </script>
</body>
</html>