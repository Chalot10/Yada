<header class="bg-[#03588C] text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Logo + Nome da Instituição -->
        <div class="flex items-center space-x-3">
            <img src="{{ asset('img/yada.png') }}" alt="yada" class="w-12 h-12 rounded-full border-2 border-[#F2B84B]">
            <div>
                <h1 class="text-xl font-bold hover:text-[#F2B84B] transition">
                    {{ config('SIGEYADA') }}
                </h1>
                <p class="text-sm text-[#F2B84B]">Yada Key Consulting and Services</p>
            </div>
        </div>

        <!-- Desktop Navigation -->
        <ul class="hidden lg:flex items-center space-x-6">
            <!-- Hora e Data -->
            <li class="text-sm text-[#F2B84B] font-medium">
                <span id="current-time">--:--</span> | 
                <span id="current-date">--/--/----</span>
            </li>

            <!-- Último acesso -->
            <li class="text-sm text-[#F2B84B] font-medium">
                Último acesso: <span>{{ auth()->user()->last_login ?? 'Não registrado' }}</span>
            </li>

            <!-- User Info -->
            <li class="flex items-center space-x-2 bg-[#F2F2F2]/20 px-3 py-1.5 rounded-full hover:bg-[#F2B84B] hover:text-[#024059] transition">
                <div class="w-8 h-8 flex items-center justify-center rounded-full bg-[#F2B84B] text-[#024059] font-bold">
                    {{-- Francisco Novela --}}
                </div>
                <div class="font-medium">{{ Auth::user()->nome }}</div>

                {{-- <span class="font-medium"> Francisco Novela</span> --}}
            </li>

            <!-- Logout -->
            <li>
                <a href="#" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="flex items-center space-x-2 px-4 py-2 bg-red-600 hover:bg-red-500 hover:text-white rounded transition font-medium">
                    <i class="fas fa-power-off"></i>
                    <span>Sair</span>
                </a>
                <form  id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </li>
        </ul>

        <!-- Mobile Toggle -->
        {{-- @auth
        <div class="lg:hidden">
            <button id="mobile-drawer-toggle" class="p-2 rounded-lg bg-[#F2B84B]/20 hover:bg-[#F2B84B]/40 transition">
                <i class="fas fa-bars text-white text-lg"></i>
            </button>
        </div>
        @endauth --}}
    </div>
</header>

<!-- Script para atualizar hora e data -->
<script>
    function updateDateTime() {
        const now = new Date();
        const time = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        const date = now.toLocaleDateString();
        document.getElementById('current-time').textContent = time;
        document.getElementById('current-date').textContent = date;
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
