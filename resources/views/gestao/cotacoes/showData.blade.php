@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6">

    <!-- Cabeçalho -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-brand-secondary">Cotações</h1>
            <p class="text-gray-600">Gerencie e visualize todas as cotações do sistema</p>
        </div>

        <a href="{{ route('gestao.cotacoes.create') }}"
           class="px-4 py-2 rounded-lg bg-brand-primary text-white font-semibold hover:bg-brand-primary/90 transition flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Nova Cotação
        </a>
    </div>

    <!-- Mensagens de Sucesso/Erro -->
    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-700">
            <div class="flex items-center">
                <i class="fa-solid fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
            <div class="flex items-center">
                <i class="fa-solid fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
            <div class="flex items-center">
                <i class="fa-solid fa-times-circle mr-2"></i>
                <span class="font-semibold">Erro ao processar:</span>
            </div>
            <ul class="list-disc list-inside mt-2 ml-4">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="filtro-status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">Todos</option>
                    <option value="pendente">Pendente</option>
                    <option value="aprovada">Aprovada</option>
                    <option value="rejeitada">Rejeitada</option>
                    <option value="convertida">Convertida em Fatura</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data Inicial</label>
                <input type="date" id="filtro-data-inicio" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data Final</label>
                <input type="date" id="filtro-data-fim" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                <input type="text" id="filtro-cliente" placeholder="Nome do cliente" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
        </div>
        
        <div class="flex justify-end mt-4">
            <button onclick="aplicarFiltros()" 
                    class="px-4 py-2 bg-brand-primary text-white rounded-lg hover:bg-brand-primary/90 transition">
                <i class="fa-solid fa-filter mr-2"></i> Aplicar Filtros
            </button>
        </div>
    </div>

    <!-- Tabela de Cotações -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Nº Cotação</th>
                        <th class="px-4 py-3 text-left font-semibold">Cliente</th>
                        <th class="px-4 py-3 text-left font-semibold">Data Emissão</th>
                        <th class="px-4 py-3 text-left font-semibold">Validade</th>
                        <th class="px-4 py-3 text-left font-semibold">Valor Total</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-center font-semibold">Acções</th>
                    </tr>
                </thead>

                <tbody class="divide-y" id="tabela-cotacoes">
                    @forelse($cotacoes as $cotacao)
                    <tr class="hover:bg-gray-50 transition" data-status="{{ strtolower($cotacao->status) }}"
                        data-cliente="{{ strtolower($cotacao->cliente->nome ?? '') }}"
                        data-data="{{ $cotacao->data_emissao }}">
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-800">{{ $cotacao->numero_cotacao }}</div>
                            <div class="text-xs text-gray-500">{{ $cotacao->categoria->categoria ?? 'N/A' }}</div>
                        </td>
                        
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $cotacao->cliente->nome ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $cotacao->cliente->contacto ?? '' }}</div>
                        </td>
                        
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($cotacao->data_emissao)->format('d/m/Y') }}
                        </td>
                        
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($cotacao->data_emissao)->addDays($cotacao->validade_dias)->format('d/m/Y') }}
                            <div class="text-xs {{ \Carbon\Carbon::parse($cotacao->data_emissao)->addDays($cotacao->validade_dias)->isPast() ? 'text-red-500' : 'text-green-500' }}">
                                ({{ $cotacao->validade_dias }} dias)
                            </div>
                        </td>
                        
                        <td class="px-4 py-3">
                            <div class="font-bold text-gray-800">MZN {{ number_format($cotacao->valor_total, 2, ',', '.') }}</div>
                            <div class="text-xs text-gray-500">IVA incl. (16%)</div>
                        </td>
                        
                        <td class="px-4 py-3">
                            @php
                                $statusClasses = [
                                    0 => 'bg-yellow-100 text-yellow-800',
                                    1 => 'bg-green-100 text-green-800', 
                                    2 => 'bg-red-100 text-red-800',
                                    3 => 'bg-blue-100 text-blue-800'
                                ];
                                $statusTexts = [
                                    0 => 'Pendente',
                                    1 => 'Aprovada',
                                    2 => 'Rejeitada',
                                    3 => 'Convertida'
                                ];
                                $statusClass = $statusClasses[$cotacao->status] ?? 'bg-gray-100 text-gray-800';
                                $statusText = $statusTexts[$cotacao->status] ?? 'Desconhecido';
                            @endphp
                            
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>                    
                        <td class="px-4 py-3">
                            <div class="flex justify-center space-x-2">
                                <!-- Visualizar -->
                                <button onclick="visualizarCotacao({{ $cotacao->id }})"
                                    class="px-3 py-1.5 rounded bg-blue-100 text-blue-600 hover:bg-blue-200 transition flex items-center text-xs"
                                    title="Visualizar Cotação">
                                    <i class="fa-solid fa-eye mr-1"></i>
                                </button>
                                
                                <!-- Editar -->
                                @if($cotacao->status == 0) <!-- 0 = Pendente -->
                                <button onclick="editarCotacao({{ $cotacao->id }})"
                                    class="px-3 py-1.5 rounded bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition flex items-center text-xs"
                                    title="Editar Cotação">
                                    <i class="fa-solid fa-pen mr-1"></i>
                                </button>
                                @endif
                                
                                <!-- Criar Fatura -->
                                @if(in_array($cotacao->status, [0, 1])) <!-- 0 = Pendente, 1 = Aprovada -->
                                <button onclick="criarFatura({{ $cotacao->id }})"
                                    class="px-3 py-1.5 rounded bg-green-100 text-green-600 hover:bg-green-200 transition flex items-center text-xs"
                                    title="Criar Fatura">
                                    <i class="fa-solid fa-file-invoice-dollar mr-1"></i>
                                </button>
                                @endif
                                
                                <!-- Remover -->
                                @if($cotacao->status == 0) <!-- 0 = Pendente -->
                                <button onclick="mostrarModalRemover({{ $cotacao->id }}, '{{ $cotacao->numero_cotacao }}')"
                                    class="px-3 py-1.5 rounded bg-red-100 text-red-600 hover:bg-red-200 transition flex items-center text-xs"
                                    title="Remover Cotação">
                                    <i class="fa-solid fa-trash mr-1"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-file-circle-exclamation text-4xl text-gray-300 mb-2"></i>
                                <p class="text-lg">Nenhuma cotação encontrada</p>
                                <p class="text-sm">Crie sua primeira cotação clicando em "Nova Cotação"</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginação -->
        @if($cotacoes->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $cotacoes->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal de Visualização -->
<div id="modalVisualizar" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fa-solid fa-file-invoice-dollar mr-2 text-brand-primary"></i>
                    Detalhes da Cotação
                </h2>
                <button onclick="fecharModal('modalVisualizar')" 
                        class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]" id="conteudoVisualizar">
                <!-- Conteúdo será carregado via AJAX -->
                <div class="flex justify-center items-center py-12">
                    <i class="fa-solid fa-spinner fa-spin text-3xl text-brand-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar Fatura -->
<div id="modalCriarFatura" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fa-solid fa-file-invoice mr-2 text-green-600"></i>
                    Criar Fatura a partir da Cotação
                </h2>
                <button onclick="fecharModal('modalCriarFatura')" 
                        class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="formCriarFatura" method="POST" action="#">
                @csrf
                <input type="hidden" name="cotacao_id" id="cotacao_id_fatura">
                
                <div class="p-6 space-y-4">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h3 class="font-semibold text-blue-800 mb-2">
                            <i class="fa-solid fa-info-circle mr-2"></i>
                            Informações Importantes
                        </h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• A fatura herdará os dados do cliente da cotação</li>
                            <li>• Os serviços serão copiados automaticamente</li>
                            <li>• Você poderá ajustar valores e prazos</li>
                            <li>• Após criar, a cotação será marcada como "convertida"</li>
                        </ul>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Número da Fatura *
                            </label>
                            <input type="text" name="numero_fatura" id="numero_fatura" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">Ex: FAC-2024-0001</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Data de Emissão *
                            </label>
                            <input type="date" name="data_emissao" id="data_emissao_fatura"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prazo de Pagamento *
                            </label>
                            <select name="prazo_pagamento" id="prazo_pagamento_fatura"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    required>
                                <option value="">Selecione</option>
                                <option value="7">7 dias</option>
                                <option value="15" selected>15 dias</option>
                                <option value="30">30 dias</option>
                                <option value="60">60 dias</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Método de Pagamento *
                            </label>
                            <select name="metodo_pagamento" id="metodo_pagamento"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    required>
                                <option value="">Selecione</option>
                                <option value="transferencia">Transferência Bancária</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="cheque">Cheque</option>
                                <option value="multicaixa">Multicaixa Express</option>
                                <option value="credito">Cartão de Crédito</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-semibold text-gray-700 mb-3">Opções Adicionais</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" name="aplicar_desconto" id="aplicar_desconto" class="mr-2">
                                <label for="aplicar_desconto" class="text-sm text-gray-700">
                                    Manter desconto da cotação
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="enviar_email" id="enviar_email" class="mr-2" checked>
                                <label for="enviar_email" class="text-sm text-gray-700">
                                    Enviar fatura por email ao cliente
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="gerar_pdf" id="gerar_pdf" class="mr-2" checked>
                                <label for="gerar_pdf" class="text-sm text-gray-700">
                                    Gerar PDF automaticamente
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 p-6 border-t border-gray-200">
                    <button type="button" onclick="fecharModal('modalCriarFatura')"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancelar
                    </button>
                    <button type="submit" id="btnCriarFatura"
                            class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                        <i class="fa-solid fa-file-invoice mr-2"></i>
                        Criar Fatura
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Remover -->
<div id="modalRemover" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                <i class="fa-solid fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">Confirmar Remoção</h2>
                <p class="text-sm text-gray-600">Esta ação não pode ser desfeita</p>
            </div>
        </div>

        <p class="text-gray-700 mb-6">
            Tem certeza que deseja remover a cotação
            <strong id="cotacao_numero_remover" class="text-red-600"></strong>?
        </p>

        <form id="formRemover" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="fecharModal('modalRemover')"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center">
                    <i class="fa-solid fa-trash mr-2"></i>
                    Remover
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
/* =========================================================
   FUNÇÕES GERAIS
========================================================= */

// Função para fechar modais
function fecharModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Função para abrir modais
function abrirModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Aplicar filtros na tabela
function aplicarFiltros() {
    const status = document.getElementById('filtro-status').value.toLowerCase();
    const cliente = document.getElementById('filtro-cliente').value.toLowerCase();
    const dataInicio = document.getElementById('filtro-data-inicio').value;
    const dataFim = document.getElementById('filtro-data-fim').value;
    
    const linhas = document.querySelectorAll('#tabela-cotacoes tr[data-status]');
    
    linhas.forEach(linha => {
        let mostrar = true;
        const linhaStatus = linha.getAttribute('data-status');
        const linhaCliente = linha.getAttribute('data-cliente');
        const linhaData = linha.getAttribute('data-data');
        
        // Filtrar por status
        if (status && linhaStatus !== status) {
            mostrar = false;
        }
        
        // Filtrar por cliente
        if (cliente && !linhaCliente.includes(cliente)) {
            mostrar = false;
        }
        
        // Filtrar por data
        if (dataInicio && new Date(linhaData) < new Date(dataInicio)) {
            mostrar = false;
        }
        if (dataFim && new Date(linhaData) > new Date(dataFim)) {
            mostrar = false;
        }
        
        // Mostrar/ocultar linha
        linha.style.display = mostrar ? '' : 'none';
    });
}

/* =========================================================
   FUNÇÕES DE AÇÕES DAS COTAÇÕES
========================================================= */

// // Visualizar cotação

async function visualizarCotacao(id) {
    try {
        // Mostrar loading no modal
        const conteudo = document.getElementById('conteudoVisualizar');
        conteudo.innerHTML = `
            <div class="flex justify-center items-center py-12">
                <i class="fa-solid fa-spinner fa-spin text-3xl text-brand-primary"></i>
                <span class="ml-3 text-gray-600">Carregando dados da cotação...</span>
            </div>
        `;
        
        // Abrir modal imediatamente
        abrirModal('modalVisualizar');
        
        // Carregar dados da cotação via AJAX
        const response = await fetch(`/cotacao/${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        // Verificar se a resposta foi bem sucedida
        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Erro ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        
        // Verificar se a resposta contém HTML
        if (data.success && data.html) {
            conteudo.innerHTML = data.html;
        } else if (data.message) {
            // Se houver mensagem de erro
            conteudo.innerHTML = `
                <div class="text-center py-8">
                    <i class="fa-solid fa-exclamation-circle text-4xl text-red-500 mb-4"></i>
                    <p class="text-lg text-gray-700">${data.message}</p>
                </div>
            `;
        } else {
            throw new Error('Resposta inválida do servidor');
        }
        
    } catch (error) {
        console.error('Erro detalhado:', error);
        
        const conteudo = document.getElementById('conteudoVisualizar');
        conteudo.innerHTML = `
            <div class="text-center py-8">
                <i class="fa-solid fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                <p class="text-lg text-gray-700">Erro ao carregar dados da cotação</p>
                <p class="text-sm text-gray-500 mt-2">Detalhes: ${error.message}</p>
                <button onclick="visualizarCotacao(${id})" 
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fa-solid fa-rotate-right mr-2"></i> Tentar Novamente
                </button>
            </div>
        `;
    }
}

// Editar cotação
function editarCotacao(id) {
    window.location.href = `{{ url('cotacao') }}/${id}/edit`;
}

// Mostrar modal para criar fatura
function criarFatura(id) {
    // Preencher dados do formulário
    document.getElementById('cotacao_id_fatura').value = id;
    
    // Gerar número de fatura automático
    const hoje = new Date();
    const ano = hoje.getFullYear();
    const mes = String(hoje.getMonth() + 1).padStart(2, '0');
    const sequencial = Math.floor(Math.random() * 1000).toString().padStart(4, '0');
    document.getElementById('numero_fatura').value = `FAC-${ano}${mes}-${sequencial}`;
    
    // Data atual
    document.getElementById('data_emissao_fatura').value = hoje.toISOString().split('T')[0];
    
    // Abrir modal
    abrirModal('modalCriarFatura');
}

// Mostrar modal de remoção
function mostrarModalRemover(id, numeroCotacao) {
    document.getElementById('cotacao_numero_remover').textContent = numeroCotacao;
    document.getElementById('formRemover').action = `{{ url('cotacao') }}/${id}`;
    abrirModal('modalRemover');
}

/* =========================================================
   SUBMISSÃO DO FORMULÁRIO DE CRIAÇÃO DE FATURA
========================================================= */

document.getElementById('formCriarFatura').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const btnCriar = document.getElementById('btnCriarFatura');
    const originalHTML = btnCriar.innerHTML;
    
    try {
        // Desabilitar botão e mostrar loading
        btnCriar.disabled = true;
        btnCriar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Criando...';
        
        // Enviar requisição
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Mostrar mensagem de sucesso
            mostrarNotificacao('success', data.message || 'Fatura criada com sucesso!');
            
            // Fechar modal
            fecharModal('modalCriarFatura');
            
            // Recarregar a página após 1 segundo
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            
        } else {
            // Mostrar erros de validação
            if (data.errors) {
                let mensagensErro = '';
                for (const campo in data.errors) {
                    mensagensErro += data.errors[campo].join('<br>') + '<br>';
                }
                mostrarNotificacao('error', mensagensErro);
            } else {
                throw new Error(data.message || 'Erro ao criar fatura');
            }
        }
        
    } catch (error) {
        console.error('Erro:', error);
        mostrarNotificacao('error', error.message || 'Erro ao criar fatura');
        
        // Restaurar botão
        btnCriar.disabled = false;
        btnCriar.innerHTML = originalHTML;
    }
});

/* =========================================================
   SUBMISSÃO DO FORMULÁRIO DE REMOÇÃO
========================================================= */

document.getElementById('formRemover').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const btnRemover = this.querySelector('button[type="submit"]');
    const originalHTML = btnRemover.innerHTML;
    
    try {
        // Desabilitar botão e mostrar loading
        btnRemover.disabled = true;
        btnRemover.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Removendo...';
        
        // Enviar requisição
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Mostrar mensagem de sucesso
            mostrarNotificacao('success', data.message || 'Cotação removida com sucesso!');
            
            // Fechar modal
            fecharModal('modalRemover');
            
            // Recarregar a página após 1 segundo
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            
        } else {
            throw new Error(data.message || 'Erro ao remover cotação');
        }
        
    } catch (error) {
        console.error('Erro:', error);
        mostrarNotificacao('error', error.message || 'Erro ao remover cotação');
        
        // Restaurar botão
        btnRemover.disabled = false;
        btnRemover.innerHTML = originalHTML;
    }
});

/* =========================================================
   FUNÇÕES AUXILIARES
========================================================= */

// Função para mostrar notificações
function mostrarNotificacao(tipo, mensagem) {
    // Remover notificações anteriores
    const notificacoesAntigas = document.querySelectorAll('.notificacao-flutuante');
    notificacoesAntigas.forEach(n => n.remove());
    
    // Cores para os tipos
    const cores = {
        success: 'bg-green-500 border-green-600',
        error: 'bg-red-500 border-red-600',
        warning: 'bg-yellow-500 border-yellow-600',
        info: 'bg-blue-500 border-blue-600'
    };
    
    // Criar notificação
    const notificacao = document.createElement('div');
    notificacao.className = `notificacao-flutuante fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-xl text-white ${cores[tipo] || cores.info} border-l-4`;
    notificacao.innerHTML = `
        <div class="flex items-center">
            <i class="fa-solid ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-3 text-xl"></i>
            <div>
                <p class="font-semibold">${mensagem}</p>
            </div>
            <button class="ml-6 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notificacao);
    
    // Remover automaticamente após 5 segundos
    setTimeout(() => {
        if (notificacao.parentElement) {
            notificacao.remove();
        }
    }, 5000);
}

// Adicionar evento para fechar modais com ESC
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModal('modalVisualizar');
            fecharModal('modalCriarFatura');
            fecharModal('modalRemover');
        }
    });
    
    // Clique fora para fechar modais
    document.querySelectorAll('#modalVisualizar, #modalCriarFatura, #modalRemover').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                fecharModal(this.id);
            }
        });
    });
    
    // Inicializar data dos filtros
    const hoje = new Date().toISOString().split('T')[0];
    const primeiroDiaMes = new Date();
    primeiroDiaMes.setDate(1);
    const primeiroDiaMesStr = primeiroDiaMes.toISOString().split('T')[0];
    
    document.getElementById('filtro-data-inicio').value = primeiroDiaMesStr;
    document.getElementById('filtro-data-fim').value = hoje;
});

</script>

<style>
/* Estilos para a tabela */
#tabela-cotacoes tr {
    transition: all 0.2s ease;
}

#tabela-cotacoes tr:hover {
    background-color: #f9fafb;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

/* Animações para modais */
#modalVisualizar,
#modalCriarFatura,
#modalRemover {
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

#modalVisualizar:not(.hidden),
#modalCriarFatura:not(.hidden),
#modalRemover:not(.hidden) {
    opacity: 1;
    pointer-events: all;
}

/* Estilos para notificações */
.notificacao-flutuante {
    animation: slideInRight 0.3s ease;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Estilo para botões desabilitados */
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endsection