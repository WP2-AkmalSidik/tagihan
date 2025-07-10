<!-- Navigation -->
<nav class="bg-gradient-to-r from-blue-600 to-purple-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-4">
                @if(request()->is('tagihan*'))
                    <a href="{{ route('dashboard') }}"
                        class="bg-white/20 rounded-lg p-2 hover:bg-white/30 transition-colors">
                        <i class="fas fa-arrow-left text-white text-lg"></i>
                    </a>
                @endif
                <div class="bg-white/20 rounded-lg p-2">
                    <i class="fas fa-bolt text-yellow-300 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-white text-xl font-bold">PT Argo Industri</h1>
                    <p class="text-blue-100 text-sm">Sistem Listrik Pascabayar</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-white text-sm">
                    <i class="fas fa-user-circle mr-2"></i>
                    {{ auth()->user()->name }}
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
