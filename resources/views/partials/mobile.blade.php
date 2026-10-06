{{-- <div id="mobile-drawer-overlay" class="fixed inset-0 bg-brand-secondary/70 z-[9999] hidden">
    <div id="mobile-drawer" class="fixed right-0 top-0 h-full w-80 bg-brand-light shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-brand-primary/30">
                <h2 class="text-lg font-semibold text-brand-secondary">Menu</h2>
                <button id="mobile-drawer-close" class="p-2 rounded-lg hover:bg-brand-light/50 transition-colors">
                    <i class="fas fa-times text-brand-secondary"></i>
                </button>
            </div>

            <div class="p-2 border-b border-brand-primary/30">
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-brand-primary/20 transition">
                    <div class="w-12 h-12 bg-brand-primary rounded-full flex items-center justify-center text-white font-bold">
                        {{ \Illuminate\Support\Str::of(Auth::user()->nome)->explode(' ')->first()[0] }}{{ \Illuminate\Support\Str::of(Auth::user()->nome)->explode(' ')->last()[0] }}
                    </div>
                    <div>
                        <div class="font-medium text-brand-secondary">{{ Auth::user()->nome }}</div>
                        <div class="text-sm text-brand-primary">Ver perfil</div>
                    </div>
                </a>
            </div>

            <div class="flex-1 overflow-y-auto p-4">
                <nav class="space-y-2">
                    <a href="{{ url('/home') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-brand-primary/20 hover:text-white">
                        <i class="fa-solid fa-home w-5"></i>
                        <span>Dashboard</span>
                    </a>
                </nav>
            </div>

            <div class="p-2 border-t border-brand-primary/30">
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" 
                   class="flex items-center space-x-3 px-3 py-2 rounded text-brand-accent2 hover:bg-brand-accent2/20">
                    <i class="fas fa-power-off w-5"></i>
                    <span>Sair</span>
                </a>
                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div> --}}



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
                    {{ substr(Auth::user()->nome, 0, 1) }}
                </div>
                <div class="font-medium">{{ Auth::user()->nome }}</div>
            </li>

            <!-- Logout -->
            <li>
                <a href="#" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="flex items-center space-x-2 px-4 py-2 bg-red-600 hover:bg-red-500 hover:text-white rounded transition font-medium">
                    <i class="fas fa-power-off"></i>
                    <span>Sair</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </li>
        </ul>

        <!-- Mobile Toggle -->
        @auth
        <div class="lg:hidden">
            <button id="mobile-drawer-toggle" class="p-2 rounded-lg bg-[#F2B84B]/20 hover:bg-[#F2B84B]/40 transition">
                <i class="fas fa-bars text-white text-lg"></i>
            </button>
        </div>
        @endauth
    </div>
</header>

<!-- Mobile Drawer Overlay -->
<div id="mobile-drawer-overlay" class="fixed inset-0 bg-black/50 z-[9999] hidden lg:hidden"></div>

<!-- Mobile Drawer -->
<div id="mobile-drawer" class="fixed right-0 top-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-[10000]">
    <div class="flex flex-col h-full">
        <!-- Drawer Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
            <button id="mobile-drawer-close" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-times text-gray-800 text-xl"></i>
            </button>
        </div>

        <!-- User Info -->
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('img/yada.png') }}" class="w-12 h-12 rounded-full border-2 border-[#F2B84B]">
                <div>
                    <p class="font-semibold text-gray-800">{{ Auth::user()->nome }}</p>
                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="flex-1 overflow-y-auto p-4">
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ url('/home') }}" 
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-700 {{ request()->routeIs('home.*') ? 'bg-blue-50 text-blue-600' : '' }}"
                   onclick="closeMobileDrawer()">
                    <i class="fa-solid fa-home w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Utilizadores -->
                <div class="mb-2">
                    <div class="flex items-center px-3 py-2 text-gray-500 text-sm font-medium">
                        <i class="fa-solid fa-users w-5 mr-3"></i>
                        <span>UTILIZADORES</span>
                    </div>
                    <div class="ml-8 space-y-1">
                        <a href="{{ route('admin.users.create') }}" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-user-plus w-4 mr-3 text-green-600"></i>
                            <span>Novo Utilizador</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-list w-4 mr-3 text-purple-600"></i>
                            <span>Listar Utilizadores</span>
                        </a>
                    </div>
                </div>

                <!-- Produtos/Serviços -->
                <div class="mb-2">
                    <div class="flex items-center px-3 py-2 text-gray-500 text-sm font-medium">
                        <i class="fa-solid fa-boxes-stacked w-5 mr-3"></i>
                        <span>PRODUTOS/SERVIÇOS</span>
                    </div>
                    <div class="ml-8 space-y-1">
                        <a href="{{ route('gestao.servicos.add') }}" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-plus w-4 mr-3 text-green-600"></i>
                            <span>Novo Produto/Serviço</span>
                        </a>
                        <a href="{{ route('gestao.servicos.showAll') }}" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-list-alt w-4 mr-3 text-blue-600"></i>
                            <span>Catálogo</span>
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-tags w-4 mr-3 text-orange-600"></i>
                            <span>Categorias</span>
                        </a>
                        <a href="{{ route('gestao.servicos.catalogo') }}" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-download w-4 mr-3 text-orange-600"></i>
                            <span>Baixar Catálogo</span>
                        </a>
                        <a href="{{ route('gestao.servicos.cartao') }}" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-download w-4 mr-3 text-orange-600"></i>
                            <span>Baixar Cartão</span>
                        </a>
                    </div>
                </div>

                <!-- Cotações -->
                <div class="mb-2">
                    <div class="flex items-center px-3 py-2 text-gray-500 text-sm font-medium">
                        <i class="fa-solid fa-file-signature w-5 mr-3"></i>
                        <span>COTAÇÕES</span>
                    </div>
                    <div class="ml-8 space-y-1">
                        <a href="{{ route('gestao.cotacoes.create') }}" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-plus-circle w-4 mr-3 text-green-600"></i>
                            <span>Nova Cotação</span>
                        </a>
                        <a href="{{ route('gestao.cotacoes.listar') }}" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-clock w-4 mr-3 text-yellow-600"></i>
                            <span>Cotações emitidas</span>
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-history w-4 mr-3 text-blue-600"></i>
                            <span>Histórico</span>
                        </a>
                    </div>
                </div>

                <!-- Faturas -->
                <div class="mb-2">
                    <div class="flex items-center px-3 py-2 text-gray-500 text-sm font-medium">
                        <i class="fa-solid fa-file-invoice-dollar w-5 mr-3"></i>
                        <span>FATURAS</span>
                    </div>
                    <div class="ml-8 space-y-1">
                        <a href="{{ route('gestao.facturas.create') }}" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-plus-circle w-4 mr-3 text-green-600"></i>
                            <span>Nova Fatura</span>
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-exclamation-triangle w-4 mr-3 text-red-600"></i>
                            <span>Pendentes de Pagamento</span>
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-receipt w-4 mr-3 text-purple-600"></i>
                            <span>Histórico de Faturas</span>
                        </a>
                    </div>
                </div>

                <!-- Relatórios -->
                <div class="mb-2">
                    <div class="flex items-center px-3 py-2 text-gray-500 text-sm font-medium">
                        <i class="fa-solid fa-chart-column w-5 mr-3"></i>
                        <span>RELATÓRIOS</span>
                    </div>
                    <div class="ml-8 space-y-1">
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-money-bill-trend-up w-4 mr-3 text-green-600"></i>
                            <span>Financeiro</span>
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-users-line w-4 mr-3 text-blue-600"></i>
                            <span>Clientes</span>
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-600 text-sm"
                           onclick="closeMobileDrawer()">
                            <i class="fa-solid fa-chart-line w-4 mr-3 text-purple-600"></i>
                            <span>Vendas</span>
                        </a>
                    </div>
                </div>

                <!-- Configurações -->
                <a href="#" 
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-700"
                   onclick="closeMobileDrawer()">
                    <i class="fa-solid fa-gear w-5 mr-3"></i>
                    <span>Configurações</span>
                </a>
            </nav>
        </div>

        <!-- Logout -->
        <div class="p-4 border-t border-gray-200">
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit(); closeMobileDrawer();" 
               class="flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition font-medium w-full">
                <i class="fas fa-power-off mr-2"></i>
                <span>Sair</span>
            </a>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </div>
</div>

<!-- Script para hora/data e drawer mobile -->
<script>
    // Função para atualizar hora e data
    function updateDateTime() {
        const now = new Date();
        const time = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        const date = now.toLocaleDateString();
        document.getElementById('current-time').textContent = time;
        document.getElementById('current-date').textContent = date;
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();

    // Funções para controlar o drawer mobile
    function openMobileDrawer() {
        document.getElementById('mobile-drawer-overlay').classList.remove('hidden');
        document.getElementById('mobile-drawer').classList.remove('translate-x-full');
    }

    function closeMobileDrawer() {
        document.getElementById('mobile-drawer-overlay').classList.add('hidden');
        document.getElementById('mobile-drawer').classList.add('translate-x-full');
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobile-drawer-toggle');
        const closeBtn = document.getElementById('mobile-drawer-close');
        const overlay = document.getElementById('mobile-drawer-overlay');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', openMobileDrawer);
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closeMobileDrawer);
        }

        if (overlay) {
            overlay.addEventListener('click', closeMobileDrawer);
        }

        // Fechar drawer ao pressionar ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileDrawer();
            }
        });
    });

    // Fechar drawer automaticamente em resoluções maiores
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            closeMobileDrawer();
        }
    });
</script>