@extends('../layouts.app')

@section('content')
<div class="p-6">
    <!-- Dashboard Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Painel de Gestão</h1>
                <p class="text-gray-600 mt-1">Bem-vindo, Francisco Bento Novela!</p>
                {{-- <p class="text-gray-600 mt-1">Bem-vindo, {{ \Illuminate\Support\Str::of(Auth::user()->name)->explode(' ')->first() }}!</p> --}}
            </div>
            <div class="mt-4 sm:mt-0 flex space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-brand-primary">
                    <i class="fa-solid fa-user-tie mr-2"></i>
                    {{-- {{ Auth::user()->role->name ?? 'Utilizador' }} --}}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fa-solid fa-calendar-day mr-2"></i>
                    {{ date('d/m/Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Mensagens de Sistema -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border-l-4 border-green-500 text-green-800 flex items-center shadow-sm">
            <i class="fa-solid fa-circle-check mr-3 text-green-600 text-lg"></i>
            <div class="flex-1">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="ml-4 text-green-600 hover:text-green-800">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-800 shadow-sm">
            <div class="flex items-center mb-2">
                <i class="fa-solid fa-triangle-exclamation mr-3 text-red-600 text-lg"></i>
                <strong class="text-lg">Ocorreram erros:</strong>
            </div>
            <ul class="list-disc list-inside space-y-1 ml-8">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('status'))
        <div class="mb-6 p-4 rounded-lg bg-blue-50 border-l-4 border-brand-primary text-blue-800 flex items-center shadow-sm">
            <i class="fa-solid fa-info-circle mr-3 text-brand-primary text-lg"></i>
            <div class="flex-1">
                <p class="font-medium">{{ session('status') }}</p>
            </div>
        </div>
    @endif

    <!-- Cards de Estatísticas Financeiras -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Receita do Mês -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-gradient-to-br from-green-500 to-green-600 text-white">
                    <i class="fa-solid fa-money-bill-wave text-lg"></i>
                </div>
                <span class="text-sm font-medium text-green-600">+15%</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">125.450,00 MT</h3>
            <p class="text-gray-600 text-sm">Receita do Mês</p>
        </div>

        <!-- Card 2: Cotações Pendentes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-gradient-to-br from-[#F2B84B] to-[#D97B29] text-white">
                    <i class="fa-solid fa-file-invoice-dollar text-lg"></i>
                </div>
                <span class="text-sm font-medium text-red-600">8 pendentes</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">24</h3>
            <p class="text-gray-600 text-sm">Cotações Pendentes</p>
        </div>

        <!-- Card 3: Faturas por Pagar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-gradient-to-br from-brand-primary to-[#024059] text-white">
                    <i class="fa-solid fa-receipt text-lg"></i>
                </div>
                <span class="text-sm font-medium text-orange-600">Atrasadas: 3</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">18</h3>
            <p class="text-gray-600 text-sm">Faturas por Pagar</p>
        </div>

        <!-- Card 4: Clientes Ativos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-gradient-to-br from-purple-500 to-purple-700 text-white">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
                <span class="text-sm font-medium text-green-600">+5 este mês</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">156</h3>
            <p class="text-gray-600 text-sm">Clientes Ativos</p>
        </div>
    </div>

    <!-- Gráficos e Tabelas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Gráfico de Receitas -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Receita Mensal (Últimos 6 meses)</h2>
                <select class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent">
                    <option>2024</option>
                    <option>2023</option>
                </select>
            </div>
            <div class="h-64 flex items-end space-x-2">
                @php
                    $months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'];
                    $values = [85, 92, 78, 105, 120, 125];
                    $max = max($values);
                @endphp
                @foreach($values as $index => $value)
                    <div class="flex-1 flex flex-col items-center">
                        <div 
                            class="w-10 bg-gradient-to-t from-brand-primary to-[#03588C] rounded-t-lg transition-all duration-300 hover:opacity-90 cursor-pointer"
                            style="height: {{ ($value / $max) * 100 }}%"
                            title="{{ $months[$index] }}: {{ number_format($value, 0, ',', '.') }}.000 MT"
                        ></div>
                        <span class="text-xs text-gray-600 mt-2">{{ $months[$index] }}</span>
                        <span class="text-xs font-medium text-gray-900">{{ number_format($value, 0, ',', '.') }}K</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Status de Pagamentos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Status de Pagamentos</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                        <span class="text-gray-700">Pagas</span>
                    </div>
                    <div class="text-right">
                        <span class="font-semibold">42</span>
                        <span class="text-gray-500 text-sm ml-1">(65%)</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-3"></div>
                        <span class="text-gray-700">Pendentes</span>
                    </div>
                    <div class="text-right">
                        <span class="font-semibold">18</span>
                        <span class="text-gray-500 text-sm ml-1">(28%)</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-red-500 mr-3"></div>
                        <span class="text-gray-700">Atrasadas</span>
                    </div>
                    <div class="text-right">
                        <span class="font-semibold">5</span>
                        <span class="text-gray-500 text-sm ml-1">(8%)</span>
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-200">
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-500 via-yellow-500 to-red-500 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabelas de Cotações e Faturas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Cotações Recentes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Cotações Recentes</h2>
                <a href="#" class="text-sm font-medium text-brand-primary hover:text-brand-secondary">Ver todas</a>
                {{-- <a href="{{ url('/cotacoes') }}" class="text-sm font-medium text-brand-primary hover:text-brand-secondary">Ver todas</a> --}}
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm font-medium text-gray-500 border-b border-gray-200">
                            <th class="pb-3">Número</th>
                            <th class="pb-3">Cliente</th>
                            <th class="pb-3">Valor</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @for($i = 1; $i <= 5; $i++)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3">
                                <div class="font-medium text-gray-900">COT-2024-00{{ $i }}</div>
                                <div class="text-xs text-gray-500">{{ now()->subDays($i)->format('d/m/Y') }}</div>
                            </td>
                            <td class="py-3">Cliente {{ $i }} Ltda.</td>
                            <td class="py-3 font-medium">{{ number_format(rand(5000, 50000), 2, ',', '.') }} MT</td>
                            <td class="py-3">
                                @php
                                    $statuses = ['pendente', 'aprovada', 'recusada'];
                                    $status = $statuses[array_rand($statuses)];
                                    $statusColors = [
                                        'pendente' => 'bg-yellow-100 text-yellow-800',
                                        'aprovada' => 'bg-green-100 text-green-800',
                                        'recusada' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$status] }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Faturas Pendentes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Faturas Pendentes</h2>
                <a href="#" class="text-sm font-medium text-brand-primary hover:text-brand-secondary">Ver todas</a>
            </div>
            <div class="space-y-4">
                @for($i = 1; $i <= 3; $i++)
                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-brand-primary hover:bg-blue-50 transition-all duration-200">
                    <div>
                        <div class="font-medium text-gray-900">FAT-2024-00{{ $i }}</div>
                        <div class="text-sm text-gray-600">Cliente {{ $i }} Ltda.</div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-gray-900">{{ number_format(rand(10000, 100000), 2, ',', '.') }} MT</div>
                        <div class="text-xs {{ $i == 1 ? 'text-red-600' : 'text-orange-600' }}">
                            @if($i == 1)
                                <i class="fa-solid fa-exclamation-triangle mr-1"></i>Vence hoje
                            @else
                                Vence em {{ rand(2, 10) }} dias
                            @endif
                        </div>
                    </div>
                </div>
                @endfor
                
                <!-- Ação Rápida -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <a href="#" class="flex items-center justify-center p-3 rounded-lg bg-gradient-to-r from-brand-primary to-[#024059] text-white hover:opacity-90 transition-all duration-200">
                        <i class="fa-solid fa-plus-circle mr-2"></i>
                        Criar Nova Fatura
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="mt-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ações Rápidas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="#" class="p-4 rounded-xl border border-gray-200 bg-white hover:border-brand-primary hover:shadow-md transition-all duration-200 group">
                <div class="p-3 rounded-lg bg-blue-100 text-brand-primary inline-flex group-hover:bg-brand-primary group-hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-file-signature text-lg"></i>
                </div>
                <h3 class="font-medium text-gray-900 mt-3 group-hover:text-brand-primary">Nova Cotação</h3>
                <p class="text-sm text-gray-600 mt-1">Criar proposta comercial</p>
            </a>

            <a href="#" class="p-4 rounded-xl border border-gray-200 bg-white hover:border-green-600 hover:shadow-md transition-all duration-200 group">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 inline-flex group-hover:bg-green-600 group-hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-user-plus text-lg"></i>
                </div>
                <h3 class="font-medium text-gray-900 mt-3 group-hover:text-green-600">Novo Cliente</h3>
                <p class="text-sm text-gray-600 mt-1">Adicionar cliente</p>
            </a>

            <a href="#" class="p-4 rounded-xl border border-gray-200 bg-white hover:border-[#D97B29] hover:shadow-md transition-all duration-200 group">
                <div class="p-3 rounded-lg bg-orange-100 text-[#D97B29] inline-flex group-hover:bg-[#D97B29] group-hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-boxes-stacked text-lg"></i>
                </div>
                <h3 class="font-medium text-gray-900 mt-3 group-hover:text-[#D97B29]">Catálogo</h3>
                <p class="text-sm text-gray-600 mt-1">Gerir produtos/serviços</p>
            </a>

            <a href="#" class="p-4 rounded-xl border border-gray-200 bg-white hover:border-purple-600 hover:shadow-md transition-all duration-200 group">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600 inline-flex group-hover:bg-purple-600 group-hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-chart-column text-lg"></i>
                </div>
                <h3 class="font-medium text-gray-900 mt-3 group-hover:text-purple-600">Relatórios</h3>
                <p class="text-sm text-gray-600 mt-1">Análise financeira</p>
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes progressBar {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Remover loading overlay
        const loadingOverlay = document.getElementById('loading-overlay');
        if (loadingOverlay) {
            setTimeout(() => {
                loadingOverlay.style.opacity = '0';
                setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                }, 300);
            }, 500);
        }

        // Gráfico interativo
        document.querySelectorAll('.hover-lift').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection

<!-- Incluir o footer -->
@include('partials.footer')
@endsection