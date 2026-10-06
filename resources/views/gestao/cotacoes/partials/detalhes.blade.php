{{-- resources/views/gestao/cotacoes/partials/detalhes.blade.php --}}
<div class="bg-white rounded-lg">
    <!-- Cabeçalho -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-t-lg">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center mb-2">
                    <i class="fa-solid fa-file-invoice-dollar text-3xl mr-3"></i>
                    <div>
                        <h1 class="text-2xl font-bold">COTAÇÃO #{{ $cotacao->numero_cotacao }}</h1>
                        <p class="opacity-90">Detalhes da cotação</p>
                    </div>
                </div>
            </div>
            <div class="text-right">
                @php
                    $statusClasses = [
                        0 => 'bg-yellow-100 text-yellow-800',
                        1 => 'bg-green-100 text-green-800',
                        2 => 'bg-red-100 text-red-800',
                        3 => 'bg-blue-100 text-blue-800'
                    ];
                    $statusClass = $statusClasses[$cotacao->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusClass }}">
                    {{ $cotacao->status_texto }}
                </span>
            </div>
        </div>
    </div>

    <!-- Informações Principais -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Dados do Cliente -->
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 pb-2 border-b border-gray-300">
                    <i class="fa-solid fa-user-tie mr-2 text-blue-600"></i>
                    DADOS DO CLIENTE
                </h3>
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">Nome:</span>
                        <span class="font-semibold">{{ $cotacao->cliente->nome ?? 'N/A' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">NUIT:</span>
                        <span class="font-semibold">{{ $cotacao->cliente->nuit ?? 'N/A' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">Contacto:</span>
                        <span class="font-semibold">{{ $cotacao->cliente->contacto ?? 'N/A' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">Endereço:</span>
                        <span class="font-semibold">{{ $cotacao->cliente->endereco ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Dados da Cotação -->
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 pb-2 border-b border-gray-300">
                    <i class="fa-solid fa-file-contract mr-2 text-blue-600"></i>
                    DETALHES DA COTAÇÃO
                </h3>
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-40 text-gray-600 font-medium">Data Emissão:</span>
                        <span class="font-semibold">{{ \Carbon\Carbon::parse($cotacao->data_emissao)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-40 text-gray-600 font-medium">Validade:</span>
                        <span class="font-semibold">
                            {{ \Carbon\Carbon::parse($cotacao->data_validade)->format('d/m/Y') }}
                            <span class="text-sm">({{ $cotacao->validade_dias }} dias)</span>
                        </span>
                    </div>
                    <div class="flex">
                        <span class="w-40 text-gray-600 font-medium">Serviço:</span>
                        <span class="font-semibold">{{ $cotacao->servico->nomeService ?? 'N/A' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-40 text-gray-600 font-medium">Categoria:</span>
                        <span class="font-semibold">{{ $cotacao->servico->categoria ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalhes do Serviço -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">
                <i class="fa-solid fa-list-check mr-2 text-blue-600"></i>
                DETALHES DO SERVIÇO
            </h3>
            
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-lg border border-gray-300">
                        <h4 class="font-semibold text-gray-700 mb-2">Quantidade</h4>
                        <p class="text-2xl font-bold text-blue-600">{{ $cotacao->quantidade ?? 1 }}</p>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg border border-gray-300">
                        <h4 class="font-semibold text-gray-700 mb-2">Preço Unitário</h4>
                        <p class="text-2xl font-bold text-green-600">
                            MZN {{ number_format($cotacao->preco_unitario ?? 0, 2, ',', '.') }}
                        </p>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg border border-gray-300">
                        <h4 class="font-semibold text-gray-700 mb-2">Valor Total</h4>
                        <p class="text-2xl font-bold text-brand-primary">
                            MZN {{ number_format($cotacao->valor_total, 2, ',', '.') }}
                        </p>
                    </div>
                </div>
                
                @if($cotacao->servico)
                <div class="mt-4 bg-white p-4 rounded-lg border border-gray-300">
                    <h4 class="font-semibold text-gray-700 mb-2">Descrição do Serviço</h4>
                    <p class="text-gray-600">{{ $cotacao->servico->nomeService }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        Categoria: {{ $cotacao->servico->categoria }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Observações -->
        @if($cotacao->observacoes)
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                <i class="fa-solid fa-comment mr-2 text-blue-600"></i>
                OBSERVAÇÕES
            </h3>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-gray-700">{{ $cotacao->observacoes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Rodapé -->
    <div class="bg-gray-100 p-4 border-t border-gray-200 rounded-b-lg">
        <div class="flex justify-between items-center text-sm text-gray-600">
            <div>
                <p><i class="fa-solid fa-calendar mr-1"></i> 
                    Emitido em: {{ \Carbon\Carbon::parse($cotacao->created_at)->format('d/m/Y H:i') }}
                </p>
            </div>
            <div class="text-right">
                <p><i class="fa-solid fa-user mr-1"></i> 
                    Criado por: {{ $cotacao->user->name ?? 'Sistema' }}
                </p>
            </div>
        </div>
    </div>
</div>