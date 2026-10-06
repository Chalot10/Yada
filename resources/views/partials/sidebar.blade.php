<!-- Header Fixo com Botão de Menu -->
<header class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 p-4 z-50 lg:hidden">
    <div class="flex items-center">
        <button id="toggle-menu" class="px-3 py-2 hover:bg-gray-100 rounded">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
        <span class="ml-4 font-semibold text-gray-800">Menu</span>
    </div>
</header>

<!-- Sidebar -->
<aside id="sidebar" class="bg-white border-r border-gray-200 p-4 transition-all duration-300 fixed top-0 left-0 h-screen w-64 z-40 -translate-x-full lg:translate-x-0 lg:relative lg:block lg:h-auto lg:min-w-64 mt-16 lg:mt-0">

    <!-- User Info -->
    <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('img/yada.png') }}" class="w-16 h-16 lg:w-20 lg:h-20 rounded-full border-2 border-[#F2B84B] mb-2">
        <div class="text-center">
            <p class="font-semibold text-gray-800 text-sm lg:text-base">Francisco Novela</p>
        </div>
    </div>

    <!-- Menu Items -->
    <ul id="menu-items" class="space-y-2">
        <li>
            <a href="{{ url('/home') }}" class="flex px-4 py-2 hover:shadow-md hover:bg-blue-600 hover:text-white rounded items-center space-x-2 {{ request()->routeIs('home.*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-home w-5 text-center"></i>
                <span class="menu-text text-sm lg:text-base">Dashboard</span>
            </a>
        </li>
        
        <!-- Clientes Dropdown -->
        <li class="relative group">
            <a href="#" class="flex px-4 py-2 hover:shadow-md hover:bg-blue-600 hover:text-white rounded items-center space-x-2">
                <i class="fa-solid fa-users w-5 text-center"></i>
                <span class="menu-text text-sm lg:text-base">Utilizadores</span>
                <i class="fa-solid fa-chevron-down text-xs ml-auto transition-transform duration-200 group-hover:rotate-180"></i>
            </a>
            <div class="absolute left-0 mt-1 w-full lg:w-64 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-1">
                    <a href="{{ route('admin.users.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-user-plus w-5 text-green-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Novo Utilizador</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-list w-5 text-purple-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Listar Utilizadores</span>
                    </a>
                </div>
            </div>
        </li>

                <!-- Menu Produtos/Serviços -->
        <li class="relative group">
            <a href="#" class="flex px-4 py-2 hover:shadow-md hover:bg-blue-600 hover:text-white rounded items-center space-x-2 {{ request()->is('produtos*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-boxes-stacked w-5 text-center"></i>
                <span class="menu-text text-sm lg:text-base">Produtos/Serviços</span>
                <i class="fa-solid fa-chevron-down text-xs ml-auto transition-transform duration-200 group-hover:rotate-180"></i>
            </a>
            
            <div class="absolute left-0 mt-1 w-full lg:w-64 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-1">
                    <a href="{{ route('gestao.servicos.add') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-plus w-5 text-green-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Novo Produto/Serviço</span>
                    </a>

                    <a href="{{ route('gestao.servicos.showAll') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-list-alt w-5 text-blue-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Catálogo</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-tags w-5 text-orange-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Categorias</span>
                    </a>

                    <a href="{{ route('gestao.servicos.catalogo') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-download w-5 text-orange-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Baixar Catálogo</span>
                    </a>


                     <a href="{{ route('gestao.servicos.cartao') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-download w-5 text-orange-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Baixar Cartao</span>
                    </a>

                </div>
            </div>
        </li>



        <!-- Menu Cotações -->
        <li class="relative group">
            <a href="#" class="flex px-4 py-2 hover:shadow-md hover:bg-blue-600 hover:text-white rounded items-center space-x-2 {{ request()->is('cotacoes*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-file-signature w-5 text-center"></i>
                <span class="menu-text text-sm lg:text-base">Cotações</span>
                <i class="fa-solid fa-chevron-down text-xs ml-auto transition-transform duration-200 group-hover:rotate-180"></i>
            </a>
            
            <div class="absolute left-0 mt-1 w-full lg:w-64 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-1">
                    <a href="{{ route('gestao.cotacoes.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-plus-circle w-5 text-green-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Nova Cotação</span>
                    </a>
                    
                    <a href="{{ route('gestao.cotacoes.listar') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-clock w-5 text-yellow-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Cotações emitidas</span>
                    </a>
                                        
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-history w-5 text-blue-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Histórico</span>
                    </a>
                </div>
            </div>
        </li>

        <!-- Menu Faturas -->
        <li class="relative group">
            <a href="#" class="flex px-4 py-2 hover:shadow-md hover:bg-blue-600 hover:text-white rounded items-center space-x-2 {{ request()->is('faturas*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i>
                <span class="menu-text text-sm lg:text-base">Faturas</span>
                <i class="fa-solid fa-chevron-down text-xs ml-auto transition-transform duration-200 group-hover:rotate-180"></i>
            </a>
            
            <div class="absolute left-0 mt-1 w-full lg:w-64 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-1">
                    <a href="{{ route('gestao.facturas.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-plus-circle w-5 text-green-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Nova Fatura</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-exclamation-triangle w-5 text-red-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Pendentes de Pagamento</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-receipt w-5 text-purple-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Histórico de Faturas</span>
                    </a>
                </div>
            </div>
        </li>

        <!-- Menu Relatórios -->
        <li class="relative group">
            <a href="#" class="flex px-4 py-2 hover:shadow-md hover:bg-blue-600 hover:text-white rounded items-center space-x-2 {{ request()->is('relatorios*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-chart-column w-5 text-center"></i>
                <span class="menu-text text-sm lg:text-base">Relatórios</span>
                <i class="fa-solid fa-chevron-down text-xs ml-auto transition-transform duration-200 group-hover:rotate-180"></i>
            </a>
            
            <div class="absolute left-0 mt-1 w-full lg:w-64 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-1">
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-money-bill-trend-up w-5 text-green-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Financeiro</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-users-line w-5 text-blue-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Clientes</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                        <i class="fa-solid fa-chart-line w-5 text-purple-600 mr-3"></i>
                        <span class="text-xs lg:text-sm">Vendas</span>
                    </a>
                </div>
            </div>
        </li>

        <!-- Menu Configurações -->
        <li>
            <a href="#" class="flex px-4 py-2 hover:shadow-md hover:bg-blue-600 hover:text-white rounded items-center space-x-2 {{ request()->is('configuracoes*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-gear w-5 text-center"></i>
                <span class="menu-text text-sm lg:text-base">Configurações</span>
            </a>
        </li>
    </ul>
</aside>

<!-- Overlay para mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-25 z-30 hidden lg:hidden"></div>

<!-- Script para Toggle Sidebar -->
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleButton = document.getElementById('toggle-menu');
    const overlay = document.getElementById('sidebar-overlay');

    // Abre/fecha sidebar no mobile
    toggleButton.addEventListener('click', () => {
        const isHidden = sidebar.classList.contains('-translate-x-full');
        sidebar.classList.toggle('-translate-x-full', !isHidden);
        overlay.classList.toggle('hidden', isHidden);
    });

    // Fecha sidebar ao clicar no overlay
    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    // Fecha sidebar ao clicar em um item no mobile
    document.querySelectorAll('#menu-items a').forEach(link => {
        link.addEventListener('click', (e) => {
            // Se não for um link dropdown (que só tem #)
            if(link.getAttribute('href') !== '#' && window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
    });

    // Ajusta automaticamente em resize
    window.addEventListener('resize', () => {
        if(window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
        }
    });

    // Inicialização - garantir que no mobile comece fechado
    if(window.innerWidth < 1024) {
        sidebar.classList.add('-translate-x-full');
    }
</script>