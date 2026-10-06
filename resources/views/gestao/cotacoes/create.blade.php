@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-8 mt-8">
    <!-- Cabeçalho -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-brand-primary mb-2">
            <i class="fa-solid fa-file-invoice-dollar mr-3"></i>
            COTAÇÃO
        </h1>
    </div>

    <!-- Formulário -->
    <form id="cotacaoForm" method="POST" action="#" class="space-y-8">
        @csrf
        @method('POST')

        
        {{-- ===============================
            STEP 0 – DADOS DO CLIENTE
        ================================= --}}
        <div class="form-step" id="step-0">
            <div class="bg-blue-50 border-l-4 border-brand-primary p-4 mb-6">
                <h2 class="text-xl font-semibold text-brand-primary flex items-center">
                    <i class="fa-solid fa-user-tie mr-2"></i>
                    Informações do Cliente
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Campos do cliente (mantidos como estão) -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Nome do Cliente <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nome_cliente" id="nome_cliente" placeholder="Digite o nome completo"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition"
                        required>
                    <div id="error-nome_cliente" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        NUIT
                    </label>
                    <input type="text" name="nuit" id="nuit" placeholder="999999999"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition"
                        pattern="\d{9}" title="NUIT deve ter 9 dígitos">
                    <div id="error-nuit" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Endereço
                    </label>
                    <input type="text" name="endereco" id="endereco" placeholder="Rua, Número, Bairro"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Contacto <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">+258</span>
                        </div>
                        <input type="tel" name="contacto" id="contacto" placeholder="84 123 4567"
                            class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition"
                            pattern="(8[2-7]|8[2-7])\s?\d{3}\s?\d{3,4}" title="Contacto moçambicano válido (ex: 84 123 4567)"
                            required>
                    </div>
                    <p class="text-xs text-gray-500">Ex: 84 123 4567 ou 86 123 4567</p>
                    <div id="error-contacto" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
            </div>

            <div class="flex justify-between mt-8 pt-6 border-t">
                <button type="button" onclick="sair()"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center">
                    <i class="fa-solid fa-times mr-2"></i> Cancelar
                </button>

                <button type="button" id="next0"
                    class="px-6 py-3 bg-brand-primary text-white rounded-lg hover:bg-brand-primary/90 transition flex items-center">
                    Próximo <i class="fa-solid fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>

        {{-- ===============================
            STEP 1 – DADOS DA COTAÇÃO
        ================================= --}}
        <div class="form-step hidden" id="step-1">
            <div class="bg-blue-50 border-l-4 border-brand-primary p-4 mb-6">
                <h2 class="text-xl font-semibold text-brand-primary flex items-center">
                    <i class="fa-solid fa-file-contract mr-2"></i>
                    Detalhes da Cotação
                </h2>
                <p class="text-gray-600 text-sm mt-1">Configure os parâmetros da cotação</p>
            </div>

            <!-- Dados do Cliente (somente leitura) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                <h3 class="font-semibold text-gray-700 mb-2">Cliente Selecionado</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Nome:</span>
                        <span id="cliente_nome" class="font-semibold ml-2"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Contacto:</span>
                        <span id="cliente_contacto" class="font-semibold ml-2"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">NUIT:</span>
                        <span id="cliente_nuit" class="font-semibold ml-2"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Endereço:</span>
                        <span id="cliente_endereco" class="font-semibold ml-2"></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Campos básicos (mantidos) -->
                {{-- <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Número da Cotação <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="numero_cotacao" id="numero_cotacao" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 font-mono font-bold"
                            readonly required>
                        <button type="button" onclick="gerarNumeroCotacao()"
                            class="absolute right-2 top-2 px-3 py-1 bg-blue-100 text-blue-700 rounded text-sm hover:bg-blue-200 transition">
                            <i class="fa-solid fa-rotate mr-1"></i> Gerar
                        </button>
                    </div>
                    <p class="text-xs text-gray-500">Gerado automaticamente pelo sistema</p>
                </div> --}}

                  {{-- <!-- No início do formulário, adicione o campo hidden com o número -->
            <input type="hidden" name="numero_cotacao_gerado" id="numero_cotacao_gerado" value="{{ $numeroCotacao ?? '' }}">

            <!-- No campo do número da cotação, modifique para usar o valor do controller -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Número da Cotação <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" name="numero_cotacao" id="numero_cotacao" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 font-mono font-bold"
                        value="{{ $numeroCotacao ?? 'COT-' . date('Ymd') . '-00000' }}"
                        readonly required>
                    <button type="button" onclick="gerarNovoNumeroCotacao()"
                        class="absolute right-2 top-2 px-3 py-1 bg-blue-100 text-blue-700 rounded text-sm hover:bg-blue-200 transition">
                        <i class="fa-solid fa-rotate mr-1"></i> Gerar Novo
                    </button>
                </div>
                <p class="text-xs text-gray-500">Número sequencial gerado automaticamente ({{ $contador ?? '0' }})</p> --}}
            
                        <!-- No campo do número da cotação, use esta estrutura -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Número da Cotação <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="numero_cotacao" id="numero_cotacao" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 font-mono font-bold"
                            value="{{ $numeroCotacao ?? 'COT-' . date('Ymd') . '-00000' }}"
                            readonly required>
                        <button type="button" onclick="gerarNovoNumeroCotacao(event)"
                            class="absolute right-2 top-2 px-3 py-1 bg-blue-100 text-blue-700 rounded text-sm hover:bg-blue-200 transition">
                            <i class="fa-solid fa-rotate mr-1"></i> Gerar Novo
                        </button>
                    </div>
                    <p class="text-xs text-gray-500">Número sequencial gerado automaticamente</p>
                </div>

                <!-- Campo hidden para armazenar o número gerado -->
                <input type="hidden" name="numero_cotacao_gerado" id="numero_cotacao_gerado" value="{{ $numeroCotacao ?? '' }}">

            
            {{-- </div> --}}


                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Data de Emissão <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="date" name="data_emissao" id="data_emissao" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition"
                            required>
                        <div id="error-data_emissao" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Validade (dias) <span class="text-red-500">*</span>
                    </label>
                    <select name="validade_dias" id="validade_dias" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition"
                        required>
                        <option value="">Selecione a validade</option>
                        <option value="7">7 dias</option>
                        <option value="15" selected>15 dias</option>
                        <option value="30">30 dias</option>
                        <option value="60">60 dias</option>
                    </select>
                    <div id="error-validade_dias" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition"
                        required>
                        <option value="Pendente" selected>Pendente</option>
                        <option value="Aprovada">Aprovada</option>
                        <option value="Rejeitada">Rejeitada</option>
                    </select>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Categoria <span class="text-red-500">*</span>
                    </label>
                    <select name="categoria" id="categoria" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition"
                        required>
                        <option value="">Selecione uma categoria</option>
                        @foreach($dados as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>
                        @endforeach 
                    </select>
                    <div id="error-categoria" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
            </div>

            <!-- SEÇÃO DE SERVIÇOS -->
            <div class="mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fa-solid fa-list-check mr-2"></i>
                        Serviços da Cotação
                    </h3>
                    <button type="button" id="adicionar-servico-btn"
                        class="px-4 py-2 bg-brand-primary text-white rounded-lg hover:bg-brand-primary/90 transition flex items-center text-sm">
                        <i class="fa-solid fa-plus mr-2"></i> Adicionar Serviço
                    </button>
                </div>

                <!-- Container dos serviços selecionados -->
                <div id="servicos-selecionados-container" class="space-y-4 mb-6">
                    <!-- Os serviços serão adicionados aqui dinamicamente -->
                </div>

                <!-- Seletor de novos serviços -->
                <div id="seletor-servico" class="border border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Selecionar Serviço
                            </label>
                            <select id="selecionar-servico" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition">
                                <option value="">Escolha um serviço...</option>
                                @foreach($dados as $servico)
                                <option value="{{ $servico->id }}" 
                                        data-nome="{{ $servico->nomeService }}"
                                        data-preco="{{ $servico->precoServico }}"
                                        data-categoria="{{ $servico->id }}">
                                    {{ $servico->nomeService }} - MZN {{ number_format($servico->precoServico, 2, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Preço Personalizado (opcional)
                            </label>
                            <div class="flex items-center">
                                <span class="mr-2 text-gray-600">MZN</span>
                                <input type="number" id="preco-personalizado" step="0.01" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition"
                                    placeholder="Deixe em branco para usar o preço padrão">
                            </div>
                            <p id="preco-original" class="text-xs text-gray-500 mt-1 hidden"></p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <button type="button" id="adicionar-servico-selecionado"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                            <i class="fa-solid fa-check mr-2"></i> Adicionar à Lista
                        </button>
                    </div>
                </div>

                <!-- Lista de serviços já adicionados (para referência) -->
                <div id="servicos-adicionados" class="mt-4 space-y-2 hidden">
                    <h4 class="text-sm font-medium text-gray-700">Serviços na cotação:</h4>
                    <ul id="lista-servicos-adicionados" class="text-sm text-gray-600"></ul>
                </div>
            </div>

            <!-- Campos extras -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Desconto Global (%)
                    </label>
                    <div class="flex items-center space-x-2">
                        <input type="range" id="desconto_range" min="0" max="50" value="0" step="5"
                            class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        <input type="number" name="desconto" id="desconto" min="0" max="50" value="0"
                            class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-center">
                        <span class="text-gray-600">%</span>
                    </div>
                    <p class="text-xs text-gray-500">Máximo 50%</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Prazo de Pagamento <span class="text-red-500">*</span>
                    </label>
                    <select name="prazo_pagamento" id="prazoPagam" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent transition"
                        required>
                        <option value="">Selecione o prazo</option>
                        <option value="7">7 dias</option>
                        <option value="15" selected>15 dias</option>
                        <option value="30">30 dias</option>
                        <option value="60">60 dias</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                    <input type="date" name="prazo_personalizado" id="prazo_personalizado" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg mt-2 hidden">
                    <div id="error-prazo_pagamento" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
            </div>

            <!-- Resumo Rápido -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border">
                <h3 class="font-semibold text-gray-700 mb-2">Resumo da Cotação</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Subtotal:</span>
                        <span id="preview_subtotal" class="font-semibold ml-2">MZN 0.00</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Desconto:</span>
                        <span id="preview_desconto" class="font-semibold ml-2">0%</span>
                    </div>
                    <div>
                        <span class="text-gray-600">IVA (17%):</span>
                        <span id="preview_iva" class="font-semibold ml-2">MZN 0.00</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Total:</span>
                        <span id="preview_total" class="font-semibold ml-2 text-brand-primary">MZN 0.00</span>
                    </div>
                </div>
                
                <!-- Detalhes dos serviços -->
                <div id="detalhes-servicos" class="mt-4 pt-4 border-t border-gray-200 hidden">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Serviços incluídos:</h4>
                    <div id="lista-resumo-servicos" class="space-y-1 text-xs"></div>
                </div>
            </div>

            <div class="flex justify-between mt-8 pt-6 border-t">
                <button type="button" onclick="showStep(0)"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Voltar
                </button>

                <button type="button" id="processar"
                    class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    <i class="fa-solid fa-calculator mr-2"></i> Processar Cotação
                </button>
            </div>
        </div>

        {{-- FIM DOS STEPS --}}

        {{-- ===============================
            STEP 2 – RECIBO / VISUALIZAÇÃO PROFISSIONAL
        ================================= --}}
        <div class="form-step hidden" id="step-2">
            <div class="max-w-5xl mx-auto">
                <!-- Cabeçalho com ações -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            <i class="fa-solid fa-file-invoice-dollar mr-3 text-brand-primary"></i>
                            Recibo de Cotação
                        </h2>
                        <p class="text-gray-600">Visualize e gerencie a cotação gerada</p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="imprimirRecibo()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                            <i class="fa-solid fa-print mr-2"></i> Imprimir
                        </button>

                        <button type="button" onclick="gerarPDF()"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition flex items-center">
                            <i class="fa-solid fa-file-pdf mr-2"></i> Gerar PDF
                        </button>

                        <button type="button" onclick="abrirModalEscolha()"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                            <i class="fa-solid fa-paper-plane mr-2"></i> Enviar
                        </button>
                    </div>
                </div>

                <!-- RECIBO PRINCIPAL -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden mb-6">
                    <!-- Cabeçalho do Recibo -->
                    <div class="bg-gradient-to-r from-brand-primary to-blue-700 text-white p-8">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                                        {{-- <i class="fa-solid fa-scale-balanced text-2xl"></i> --}}
                                        <img src="{{ asset('img/yada.png') }}" alt="yada" class="w-12 h-12 rounded-full border-2 border-[#F2B84B]">

                                    </div>
                                    <div>
                                        <h1 class="text-3xl font-bold" id="empresa_nome">Nome da Empresa</h1>
                                        <p class="opacity-90">Consultoria & Serviços</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <p class="opacity-80">NUIT:</p>
                                        <p class="font-semibold" id="empresa_nuit">999999999</p>
                                    </div>
                                    <div>
                                        <p class="opacity-80">Endereço:</p>
                                        <p class="font-semibold" id="empresa_endereco">Maputo, Moçambique</p>
                                    </div>
                                    <div>
                                        <p class="opacity-80">Telefone:</p>
                                        <p class="font-semibold" id="empresa_telefone">+258 84 000 0000</p>
                                    </div>
                                    <div>
                                        <p class="opacity-80">Email:</p>
                                        <p class="font-semibold" id="empresa_email">contato@empresa.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="mb-4">
                                    <div id="status_badge" class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-white/20">
                                        Pendente
                                    </div>
                                </div>
                                <div class="text-4xl font-bold mb-2">COTAÇÃO</div>
                                <div class="text-2xl font-mono font-bold">#<span id="idCotacao">000000</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações da Cotação -->
                    <div class="p-8 border-b border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Dados do Cliente -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-200">
                                    <i class="fa-solid fa-user-tie mr-2"></i>
                                    DADOS DO CLIENTE
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex">
                                        <span class="w-32 text-gray-600">Nome:</span>
                                        <span class="font-semibold" id="v_nome">Francisco Bento Novela</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 text-gray-600">NUIT:</span>
                                        <span class="font-semibold" id="v_nuit">111111111</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 text-gray-600">Endereço:</span>
                                        <span class="font-semibold" id="v_endereco">Bairro 25 de Junho A</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 text-gray-600">Contacto:</span>
                                        <span class="font-semibold" id="v_contacto">849130222</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalhes da Cotação -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-200">
                                    <i class="fa-solid fa-file-contract mr-2"></i>
                                    DETALHES DA COTAÇÃO
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex">
                                        <span class="w-32 text-gray-600">Emissão:</span>
                                        <span class="font-semibold" id="v_data_emissao">28/12/2025</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 text-gray-600">Validade:</span>
                                        <span class="font-semibold" id="v_validade">12/01/2026</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 text-gray-600">Categoria:</span>
                                        <span class="font-semibold" id="v_categoria">Serviços Jurídicos</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 text-gray-600">Prazo Pagamento:</span>
                                        <span class="font-semibold" id="v_prazo">15 dias</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de Serviços -->
                    <div class="p-8 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">
                            <i class="fa-solid fa-list-check mr-2"></i>
                            SERVIÇOS SOLICITADOS
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-700 text-sm">
                                        <th class="px-4 py-3 text-left font-semibold rounded-l-lg">Descrição do Serviço</th>
                                        <th class="px-4 py-3 text-center font-semibold">Qtd.</th>
                                        <th class="px-4 py-3 text-right font-semibold">Preço Unitário</th>
                                        <th class="px-4 py-3 text-center font-semibold">Desc. %</th>
                                        <th class="px-4 py-3 text-right font-semibold rounded-r-lg">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="tabela-servicos">
                                    <!-- Serviços serão inseridos aqui via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Resumo de Valores -->
                    <div class="p-8">
                        <div class="max-w-md ml-auto">
                            <div class="space-y-4">
                                <div class="flex justify-between text-gray-700">
                                    <span>Subtotal:</span>
                                    <span class="font-semibold" id="subtotal">MZN 0.00</span>
                                </div>
                                
                                <div class="flex justify-between text-gray-700">
                                    <span>Desconto Global (<span id="v_desconto_percent">0</span>%):</span>
                                    <span class="font-semibold text-red-600" id="v_desconto">- MZN 0.00</span>
                                </div>
                                
                                <div class="pt-3 border-t border-gray-200">
                                    <div class="flex justify-between text-gray-700">
                                        <span>Subtotal com Desconto:</span>
                                        <span class="font-semibold">MZN 0.00</span>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between text-gray-700">
                                    <span>IVA (17%):</span>
                                    <span class="font-semibold" id="iva">MZN 0.00</span>
                                </div>
                                
                                <div class="pt-4 border-t border-gray-300">
                                    <div class="flex justify-between text-xl font-bold">
                                        <span>TOTAL:</span>
                                        <span class="text-brand-primary" id="total">MZN 0.00</span>
                                    </div>
                                    <p class="text-right text-sm text-gray-600 mt-1" id="total_extenso">
                                        Meticais zero e zero centavos
                                    </p>
                                </div>
                            </div>
                            
                            <!-- QR Code e Informações Adicionais -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div id="qr-code-container">
                                        <!-- QR Code será gerado aqui -->
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-700 mb-2">Observações:</h4>
                                        <p class="text-sm text-gray-600" id="observacoes">
                                            Esta cotação é válida até a data indicada acima. Para dúvidas, contacte-nos.
                                        </p>
                                        <div class="mt-4 text-xs text-gray-500">
                                            <p><i class="fa-solid fa-circle-info mr-2"></i> Cotação gerada automaticamente pelo sistema</p>
                                            <p><i class="fa-solid fa-clock mr-2"></i> Data de processamento: {{ date('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acções Finais -->
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="flex flex-wrap gap-4 justify-center">
                        <button type="button" onclick="showStep(1)"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center">
                            <i class="fa-solid fa-edit mr-2"></i> Editar Cotação
                        </button>

                        <button type="button" onclick="aprovarCotacao()"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                            <i class="fa-solid fa-check-circle mr-2"></i> Aprovar Cotação
                        </button>

                        <button type="button" onclick="salvarCotacao()" id="btn-salvar"
                            class="px-6 py-3 bg-brand-primary text-white rounded-lg hover:bg-brand-primary/90 transition flex items-center">
                            <i class="fa-solid fa-save mr-2"></i> Salvar no Sistema
                        </button>

                        <button type="button" onclick="novaCotacao()"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                            <i class="fa-solid fa-plus mr-2"></i> Nova Cotação
                        </button>
                    </div>
                    
                    <div class="mt-4 text-center text-sm text-gray-500">
                        <p><i class="fa-solid fa-lightbulb mr-2"></i> 
                            Dica: Após aprovar, você pode converter esta cotação em fatura ou enviar por email ao cliente.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>




    <!-- Modal de Escolha de Envio -->
    <div id="modalEscolhaEnvio" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    <i class="fa-solid fa-paper-plane mr-2 text-brand-primary"></i>
                    Enviar Cotação
                </h3>
                <button onclick="fecharModalEscolha()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            
            <p class="text-gray-600 mb-6">Escolha como deseja enviar esta cotação:</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Opção WhatsApp -->
                <button onclick="abrirModalWhatsApp()"
                        class="p-6 bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fa-brands fa-whatsapp text-4xl text-green-600"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1">WhatsApp</h4>
                        <p class="text-sm text-gray-600">Enviar via mensagem</p>
                        <div class="mt-3 text-xs text-green-700">
                            <i class="fa-solid fa-bolt mr-1"></i> Envio instantâneo
                        </div>
                    </div>
                </button>
                
                <!-- Opção Email -->
                <button onclick="abrirModalEmail()"
                        class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-envelope text-4xl text-blue-600"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1">Email</h4>
                        <p class="text-sm text-gray-600">Enviar via correio eletrônico</p>
                        <div class="mt-3 text-xs text-blue-700">
                            <i class="fa-solid fa-file-pdf mr-1"></i> Incluir PDF
                        </div>
                    </div>
                </button>
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200">
                <button onclick="fecharModalEscolha()"
                        class="w-full px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal WhatsApp -->
    <div id="modalWhatsApp" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    <i class="fa-brands fa-whatsapp mr-2 text-green-600"></i>
                    Enviar por WhatsApp
                </h3>
                <button onclick="fecharModalWhatsApp()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="whatsappForm">
                <div class="space-y-4">
                    <!-- Número do Cliente -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fa-solid fa-phone mr-2 text-gray-500"></i>
                            Número do WhatsApp
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">+258</span>
                            </div>
                            <input type="tel" id="whatsappNumero" 
                                class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="84 123 4567" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Digite o número com código de área</p>
                    </div>
                    
                    <!-- Mensagem -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fa-solid fa-comment-dots mr-2 text-gray-500"></i>
                            Mensagem
                        </label>
                        <textarea id="whatsappMensagem" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Prezado cliente, segue sua cotação..."></textarea>
                        <div class="mt-2 text-xs text-gray-500">
                            <i class="fa-solid fa-lightbulb mr-1"></i> A cotação será enviada como documento
                        </div>
                    </div>
                    
                    <!-- Opções -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-700 mb-3">Opções de Envio</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="whatsappResumo" class="mr-2" checked>
                                <label for="whatsappResumo" class="text-sm text-gray-700">
                                    Incluir resumo da cotação
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="whatsappImagem" class="mr-2" checked>
                                <label for="whatsappImagem" class="text-sm text-gray-700">
                                    Enviar imagem do recibo
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="whatsappLink" class="mr-2">
                                <label for="whatsappLink" class="text-sm text-gray-700">
                                    Incluir link para visualização online
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pré-visualização -->
                    <div id="whatsappPreview" class="bg-green-50 border border-green-200 rounded-lg p-4 hidden">
                        <h4 class="font-medium text-green-800 mb-2">
                            <i class="fa-solid fa-eye mr-2"></i>Pré-visualização
                        </h4>
                        <div class="text-sm text-green-700 bg-white p-3 rounded border border-green-100">
                            <p id="previewText"></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="fecharModalWhatsApp()"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" id="btnEnviarWhatsApp"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
                        <i class="fa-brands fa-whatsapp mr-2"></i>
                        Enviar WhatsApp
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Email (já existente, mas vou atualizar) -->
    <div id="modalEmail" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    <i class="fa-solid fa-envelope mr-2 text-blue-600"></i>
                    Enviar por Email
                </h3>
                <button onclick="fecharModalEmail()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="emailForm">
                <div class="space-y-4">
                    <!-- Email do Cliente -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fa-solid fa-at mr-2 text-gray-500"></i>
                            Email do Cliente
                        </label>
                        <input type="email" id="emailCliente" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="cliente@email.com" required>
                        <p class="text-xs text-gray-500 mt-1">Digite o email do cliente</p>
                    </div>
                    
                    <!-- Assunto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fa-solid fa-tag mr-2 text-gray-500"></i>
                            Assunto
                        </label>
                        <input type="text" id="assuntoEmail" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="Cotação de Serviços - Yada Key Consulting and Services" required>
                    </div>
                    
                    <!-- Mensagem -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fa-solid fa-comment mr-2 text-gray-500"></i>
                            Mensagem
                        </label>
                        <textarea id="mensagemEmail" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Prezado cliente, segue em anexo sua cotação..."></textarea>
                    </div>
                    
                    <!-- Opções -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-700 mb-3">Opções de Envio</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="enviarPDF" class="mr-2" checked>
                                <label for="enviarPDF" class="text-sm text-gray-700">
                                    Incluir PDF da cotação
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="enviarResumo" class="mr-2" checked>
                                <label for="enviarResumo" class="text-sm text-gray-700">
                                    Incluir resumo no corpo do email
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="enviarCC" class="mr-2">
                                <label for="enviarCC" class="text-sm text-gray-700">
                                    Enviar cópia para o meu email
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="fecharModalEmail()"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" id="btnEnviarEmail"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                        <i class="fa-solid fa-paper-plane mr-2"></i>
                        Enviar Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

/* =========================================================
   VARIÁVEIS GLOBAIS
========================================================= */
let currentStep = 0;
let cotacaoData = {};
let servicosSelecionados = new Set(); // Para controlar serviços duplicados
let servicoIndex = 0;

/* =========================================================
   FUNÇÃO PRINCIPAL DE NAVEGAÇÃO
========================================================= */
function showStep(step) {
    console.log(`Mudando para step: ${step}`);
    
    // Esconder todos os steps
    document.querySelectorAll('.form-step').forEach(s => {
        s.classList.add('hidden');
    });
    
    // Mostrar step atual
    const stepElement = document.getElementById(`step-${step}`);
    if (stepElement) {
        stepElement.classList.remove('hidden');
        currentStep = step;
        
        // Ações específicas para cada step
        switch(step) {
            case 1:
                preencherResumoCliente();
                break;
            case 2:
                // NÃO CHAME processarCotacao() AQUI!
                // Apenas mostre o recibo que já foi preenchido
                console.log('Mostrando recibo da cotação');
                break;
        }
        
        // Rolar para o topo suavemente
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        console.error(`Elemento step-${step} não encontrado!`);
    }
}


/* =========================================================
   INICIALIZAÇÃO
========================================================= */
/*
document.addEventListener('DOMContentLoaded', () => {
    console.log('Sistema de Cotação inicializado');
    
    // Inicializar datas
    initDatas();
    
    // Gerar número da cotação
    gerarNumeroCotacao();
    
    // Inicializar sistema de serviços
    inicializarServicos();
    
    // Configurar eventos
    bindEvents();
    
    // Mostrar primeiro step
    showStep(0);
});

*/
document.addEventListener('DOMContentLoaded', () => {
    console.log('Sistema de Cotação inicializado');
    
    // Inicializar datas
    initDatas();
    
    // NÃO chamar gerarNumeroCotacao() aqui, pois já vem do controller
    
    // Inicializar sistema de serviços
    inicializarServicos();
    
    // Configurar eventos
    bindEvents();
    
    // Mostrar primeiro step
    showStep(0);
});

function initDatas() {
    // Definir data atual como data de emissão
    const hoje = new Date().toISOString().split('T')[0];
    const dataEmissao = document.getElementById('data_emissao');
    if (dataEmissao) {
        dataEmissao.value = hoje;
    }
    
    // Definir data personalizada (se existir)
    const prazoPersonalizado = document.getElementById('prazo_personalizado');
    if (prazoPersonalizado) {
        const amanha = new Date();
        amanha.setDate(amanha.getDate() + 15);
        prazoPersonalizado.value = amanha.toISOString().split('T')[0];
        prazoPersonalizado.min = hoje;
    }
}

function gerarNovoNumeroCotacao(event) {
    // Prevenir comportamento padrão
    if (event) {
        event.preventDefault();
    }
    
    // Mostrar loading
    const btn = event ? event.currentTarget : document.querySelector('button[onclick*="gerarNovoNumeroCotacao"]');
    if (!btn) return;
    
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Gerando...';
    btn.disabled = true;
    
    // Fazer requisição AJAX
    fetch('/cotacao/proximo-numero', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            document.getElementById('numero_cotacao').value = data.numero_cotacao;
            document.getElementById('numero_cotacao_gerado').value = data.numero_cotacao;
            
            // Mostrar notificação de sucesso
            if (typeof mostrarNotificacao === 'function') {
                mostrarNotificacao('success', 'Novo número gerado: ' + data.numero_cotacao);
            } else {
                alert('Novo número gerado: ' + data.numero_cotacao);
            }
        } else {
            throw new Error(data.message || 'Erro ao gerar número');
        }
    })
    .catch(error => {
        console.error('Erro detalhado:', error);
        
        // Fallback: gerar número localmente em caso de erro
        const data = new Date();
        const ano = data.getFullYear();
        const mes = String(data.getMonth() + 1).padStart(2, '0');
        const dia = String(data.getDate()).padStart(2, '0');
        const random = Math.floor(Math.random() * 10000).toString().padStart(5, '0');
        const numeroFallback = `COT-${ano}${mes}${dia}-${random}`;
        
        document.getElementById('numero_cotacao').value = numeroFallback;
        document.getElementById('numero_cotacao_gerado').value = numeroFallback;
        
        if (typeof mostrarNotificacao === 'function') {
            mostrarNotificacao('warning', 'Usando número temporário: ' + numeroFallback);
        } else {
            alert('Usando número temporário: ' + numeroFallback);
        }
    })
    .finally(() => {
        // Restaurar botão
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    });
}

// Adicione também uma função para testar se a rota está acessível
function testarRotaNumero() {
    fetch('/cotacao/proximo-numero', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Status da rota:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Resposta da rota:', data);
        alert('Rota funcionando! Número: ' + data.numero_cotacao);
    })
    .catch(error => {
        console.error('Erro na rota:', error);
        alert('Erro na rota: ' + error.message);
    });
}

// Para testar, você pode chamar no console: testarRotaNumero()
/*
function gerarNovoNumeroCotacao() {
    // Mostrar loading
    const btn = event.currentTarget;
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Gerando...';
    btn.disabled = true;
    
    fetch('/cotacao/proximo-numero', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('numero_cotacao').value = data.numero_cotacao;
            document.getElementById('numero_cotacao_gerado').value = data.numero_cotacao;
            
            // Mostrar notificação de sucesso
            mostrarNotificacao('success', 'Novo número gerado: ' + data.numero_cotacao);
        } else {
            mostrarNotificacao('error', 'Erro ao gerar número');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        mostrarNotificacao('error', 'Erro ao gerar novo número');
    })
    .finally(() => {
        // Restaurar botão
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    });
}

*/

function inicializarServicos() {
    // Limpar containers
    const containerServicos = document.getElementById('servicos-selecionados-container');
    if (containerServicos) {
        containerServicos.innerHTML = '';
    }
    
    const listaServicos = document.getElementById('lista-servicos-adicionados');
    if (listaServicos) {
        listaServicos.innerHTML = '';
    }
    
    // Resetar variáveis
    servicosSelecionados.clear();
    servicoIndex = 0;
    
    // Atualizar UI
    atualizarBotaoProcessar();
    atualizarResumoServicos();
}

function bindEvents() {
    console.log('Configurando eventos...');
    
    // ===== BOTÕES DE NAVEGAÇÃO =====
    const btnNext0 = document.getElementById('next0');
    if (btnNext0) {
        btnNext0.addEventListener('click', validarStep0);
        console.log('Evento do botão next0 configurado');
    }
    
    const btnProcessar = document.getElementById('processar');
    if (btnProcessar) {
        btnProcessar.addEventListener('click', validarStep1);
        console.log('Evento do botão processar configurado');
    }
    
    // ===== EVENTOS DE SERVIÇOS =====
    const selectServico = document.getElementById('selecionar-servico');
    if (selectServico) {
        selectServico.addEventListener('change', atualizarPrecoOriginal);
        console.log('Evento do seletor de serviço configurado');
    }
    
    const inputPrecoPersonalizado = document.getElementById('preco-personalizado');
    if (inputPrecoPersonalizado) {
        inputPrecoPersonalizado.addEventListener('input', validarPrecoPersonalizado);
    }
    
    const btnAdicionarServico = document.getElementById('adicionar-servico-selecionado');
    if (btnAdicionarServico) {
        btnAdicionarServico.addEventListener('click', adicionarServico);
        console.log('Evento do botão adicionar serviço configurado');
    }
    
    const btnMostrarSeletor = document.getElementById('adicionar-servico-btn');
    if (btnMostrarSeletor) {
        btnMostrarSeletor.addEventListener('click', mostrarSeletor);
    }
    
    // ===== EVENTOS DE FORMULÁRIO =====
    const rangeDesconto = document.getElementById('desconto_range');
    if (rangeDesconto) {
        rangeDesconto.addEventListener('input', syncDescontoRange);
    }
    
    const inputDesconto = document.getElementById('desconto');
    if (inputDesconto) {
        inputDesconto.addEventListener('input', syncDescontoInput);
    }
    
    const selectPrazo = document.getElementById('prazoPagam');
    if (selectPrazo) {
        selectPrazo.addEventListener('change', togglePrazoPersonalizado);
    }
    
    const btnSair = document.querySelector('button[onclick="sair()"]');
    if (btnSair) {
        btnSair.addEventListener('click', sair);
    }
    
    // ===== EVENTOS DO MODAL =====
    const btnCloseModal = document.getElementById('closeErrorModal');
    if (btnCloseModal) {
        btnCloseModal.addEventListener('click', () => {
            document.getElementById('errorModal').classList.add('hidden');
        });
    }
    
    console.log('Todos os eventos configurados');
}

/* =========================================================
   FUNÇÕES DO STEP 0 - CLIENTE
========================================================= */
function validarStep0() {
    console.log('Validando dados do cliente...');
    
    // Limpar erros anteriores
    limparErros(['nome_cliente', 'contacto', 'nuit']);
    
    let valido = true;
    const nome = getVal('nome_cliente');
    const contacto = getVal('contacto');
    const nuit = getVal('nuit');

    // Validar nome (mínimo 3 caracteres)
    if (!nome || nome.length < 3) {
        erro('nome_cliente', 'Nome inválido (mínimo 3 caracteres)');
        valido = false;
    }

    // Validar contacto (formato moçambicano)
    if (!contacto || !validarContacto(contacto)) {
        erro('contacto', 'Contacto moçambicano inválido. Exemplo: 84 123 4567');
        valido = false;
    }

    // Validar NUIT (se preenchido)
    if (nuit && !/^\d{9}$/.test(nuit)) {
        erro('nuit', 'NUIT deve conter exatamente 9 dígitos');
        valido = false;
    }

    // Se tudo válido, avançar para step 1
    if (valido) {
        console.log('Dados do cliente válidos, avançando para step 1');
        showStep(1);
    } else {
        console.log('Dados do cliente inválidos');
        // Mostrar modal de erro
        mostrarErro('Por favor, corrija os erros no formulário.');
    }
}
/* =========================================================
   FUNÇÕES DO STEP 1 - COTAÇÃO
========================================================= */

function validarStep1() {
    console.log('Validando dados da cotação...');
    
    // Limpar erros anteriores
    limparErros(['data_emissao', 'validade_dias', 'categoria', 'prazoPagam']);
    
    let valido = true;

    // Validar data de emissão
    if (!getVal('data_emissao')) {
        erro('data_emissao', 'Data de emissão obrigatória');
        valido = false;
    }

    // Validar validade
    if (!getVal('validade_dias')) {
        erro('validade_dias', 'Validade obrigatória');
        valido = false;
    }

    // Validar categoria
    if (!getVal('categoria')) {
        erro('categoria', 'Selecione uma categoria');
        valido = false;
    }

    // Validar prazo de pagamento
    const prazo = getVal('prazoPagam');
    if (!prazo) {
        erro('prazoPagam', 'Prazo de pagamento obrigatório');
        valido = false;
    }

    if (prazo === 'personalizado' && !getVal('prazo_personalizado')) {
        erro('prazoPagam', 'Informe a data personalizada');
        valido = false;
    }

    // Validar se há serviços selecionados
    if (servicosSelecionados.size === 0) {
        mostrarNotificacao('error', 'Adicione pelo menos um serviço à cotação.');
        valido = false;
    }

    // Se tudo válido, processar cotação
    if (valido) {
        console.log('Dados da cotação válidos, processando...');
        processarCotacao(); // Isso agora não causa loop
    }
}



/* =========================================================
   FUNÇÕES DE SERVIÇOS
========================================================= */
function atualizarPrecoOriginal() {
    const select = document.getElementById('selecionar-servico');
    const opcao = select.options[select.selectedIndex];
    const precoOriginal = document.getElementById('preco-original');
    const btnAdicionar = document.getElementById('adicionar-servico-selecionado');
    
    if (opcao.value) {
        const preco = parseFloat(opcao.dataset.preco) || 0;
        precoOriginal.textContent = `Preço original: MZN ${preco.toFixed(2).replace('.', ',')}`;
        precoOriginal.classList.remove('hidden');
        
        // Habilitar botão de adicionar
        btnAdicionar.disabled = false;
        
        // Verificar se serviço já foi adicionado
        if (servicosSelecionados.has(parseInt(opcao.value))) {
            btnAdicionar.disabled = true;
            precoOriginal.innerHTML += ' <span class="text-red-500">(Já adicionado)</span>';
        }
        
        // Preencher preço personalizado com valor original
        const precoPersonalizado = document.getElementById('preco-personalizado');
        precoPersonalizado.value = preco.toFixed(2);
        precoPersonalizado.placeholder = preco.toFixed(2);
    } else {
        precoOriginal.classList.add('hidden');
        btnAdicionar.disabled = true;
    }
}

function validarPrecoPersonalizado(e) {
    const valor = parseFloat(e.target.value);
    const select = document.getElementById('selecionar-servico');
    const opcao = select.options[select.selectedIndex];
    
    if (!opcao.value) return;
    
    const precoOriginal = parseFloat(opcao.dataset.preco);
    
    if (isNaN(valor) || valor < 0) {
        e.target.value = precoOriginal.toFixed(2);
    }
}

function adicionarServico() {
    const select = document.getElementById('selecionar-servico');
    const opcao = select.options[select.selectedIndex];
    
    if (!opcao.value) {
        mostrarErro('Selecione um serviço primeiro.');
        return;
    }
    
    const servicoId = parseInt(opcao.value);
    
    // Verificar duplicado
    if (servicosSelecionados.has(servicoId)) {
        mostrarErro('Este serviço já foi adicionado à cotação.');
        return;
    }
    
    const servicoNome = opcao.dataset.nome;
    const precoOriginal = parseFloat(opcao.dataset.preco);
    const precoPersonalizado = document.getElementById('preco-personalizado').value;
    const precoFinal = precoPersonalizado ? parseFloat(precoPersonalizado) : precoOriginal;
    
    // Validar preço
    if (isNaN(precoFinal) || precoFinal <= 0) {
        mostrarErro('Preço inválido. Digite um valor maior que zero.');
        return;
    }
    
    // Adicionar ao Set de controle
    servicosSelecionados.add(servicoId);
    
    // Criar elemento HTML do serviço
    const servicoHTML = `
        <div class="servico-item bg-white border border-gray-200 rounded-lg p-4" 
             data-servico-id="${servicoId}" 
             data-index="${servicoIndex}">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h4 class="font-medium text-gray-800">${servicoNome}</h4>
                    <p class="text-sm text-gray-600">Preço unitário: MZN ${precoFinal.toFixed(2).replace('.', ',')}</p>
                    ${precoPersonalizado && precoFinal !== precoOriginal ? 
                        `<p class="text-xs text-green-600">Preço personalizado (Original: MZN ${precoOriginal.toFixed(2).replace('.', ',')})</p>` : 
                        ''}
                </div>
                <button type="button" 
                        class="remover-servico text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-50">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Quantidade</label>
                    <input type="number" 
                           name="servicos[${servicoIndex}][quantidade]" 
                           value="1" 
                           min="1" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md quantidade-servico"
                           required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Desconto (%)</label>
                    <input type="number" 
                           name="servicos[${servicoIndex}][desconto]" 
                           value="0" 
                           min="0" 
                           max="100" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md desconto-servico">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Subtotal</label>
                    <input type="text" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 subtotal-servico" 
                           value="MZN ${precoFinal.toFixed(2).replace('.', ',')}" 
                           readonly>
                </div>
            </div>
            
            <!-- Campos hidden para envio -->
            <input type="hidden" name="servicos[${servicoIndex}][servico_id]" value="${servicoId}">
            <input type="hidden" name="servicos[${servicoIndex}][nome]" value="${servicoNome}">
            <input type="hidden" name="servicos[${servicoIndex}][preco_unitario]" value="${precoFinal}">
            <input type="hidden" name="servicos[${servicoIndex}][preco_original]" value="${precoOriginal}">
        </div>
    `;
    
    // Adicionar ao container
    const container = document.getElementById('servicos-selecionados-container');
    container.insertAdjacentHTML('beforeend', servicoHTML);
    
    // Adicionar à lista de referência
    const lista = document.getElementById('lista-servicos-adicionados');
    const li = document.createElement('li');
    li.className = 'flex justify-between items-center py-1 border-b border-gray-100';
    li.innerHTML = `
        <span>${servicoNome}</span>
        <span class="text-green-600 font-medium">MZN ${precoFinal.toFixed(2).replace('.', ',')}</span>
    `;
    lista.appendChild(li);
    
    // Mostrar container de serviços adicionados
    document.getElementById('servicos-adicionados').classList.remove('hidden');
    
    // Limpar seletor
    select.value = '';
    document.getElementById('preco-personalizado').value = '';
    document.getElementById('preco-original').classList.add('hidden');
    document.getElementById('adicionar-servico-selecionado').disabled = true;
    
    // Incrementar índice
    servicoIndex++;
    
    // Atualizar UI
    atualizarBotaoProcessar();
    atualizarResumoServicos();
    adicionarEventosServico();
}

function adicionarEventosServico() {
    // Evento para remover serviço
    document.querySelectorAll('.remover-servico').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const item = this.closest('.servico-item');
            const servicoId = parseInt(item.dataset.servicoId);
            
            // Remover do Set
            servicosSelecionados.delete(servicoId);
            
            // Remover do DOM
            item.remove();
            
            // Atualizar lista de referência
            const lista = document.getElementById('lista-servicos-adicionados');
            const itens = Array.from(lista.children);
            const servicoNome = item.querySelector('h4').textContent;
            
            itens.forEach(li => {
                if (li.textContent.includes(servicoNome)) {
                    li.remove();
                }
            });
            
            // Esconder container se não houver serviços
            if (servicosSelecionados.size === 0) {
                document.getElementById('servicos-adicionados').classList.add('hidden');
            }
            
            // Atualizar UI
            atualizarBotaoProcessar();
            atualizarResumoServicos();
        });
    });
    
    // Eventos para quantidade e desconto
    document.querySelectorAll('.quantidade-servico, .desconto-servico').forEach(input => {
        input.addEventListener('input', function() {
            const item = this.closest('.servico-item');
            atualizarSubtotalServico(item);
            atualizarResumoServicos();
        });
    });
}

function atualizarSubtotalServico(item) {
    const quantidade = parseInt(item.querySelector('.quantidade-servico').value) || 1;
    const desconto = parseFloat(item.querySelector('.desconto-servico').value) || 0;
    const precoUnitario = parseFloat(item.querySelector('input[name$="[preco_unitario]"]').value);
    
    if (quantidade < 1) {
        item.querySelector('.quantidade-servico').value = 1;
        return;
    }
    
    if (desconto < 0) desconto = 0;
    if (desconto > 100) desconto = 100;
    
    let subtotal = quantidade * precoUnitario;
    if (desconto > 0) {
        subtotal -= subtotal * (desconto / 100);
    }
    
    item.querySelector('.subtotal-servico').value = `MZN ${subtotal.toFixed(2).replace('.', ',')}`;
}

function atualizarResumoServicos() {
    const servicosItems = document.querySelectorAll('.servico-item');
    const listaResumo = document.getElementById('lista-resumo-servicos');
    const detalhesContainer = document.getElementById('detalhes-servicos');
    
    if (servicosItems.length === 0) {
        detalhesContainer.classList.add('hidden');
        return;
    }
    
    detalhesContainer.classList.remove('hidden');
    
    let html = '';
    let subtotalTotal = 0;
    
    servicosItems.forEach(item => {
        const nome = item.querySelector('h4').textContent;
        const quantidade = item.querySelector('.quantidade-servico').value;
        const subtotalText = item.querySelector('.subtotal-servico').value;
        
        // Extrair valor numérico do subtotal
        const valorSubtotal = parseFloat(subtotalText.replace('MZN ', '').replace(',', '.'));
        subtotalTotal += valorSubtotal;
        
        html += `
            <div class="flex justify-between text-sm py-1">
                <span class="truncate">${nome}</span>
                <span class="font-medium whitespace-nowrap ml-2">${subtotalText}</span>
            </div>
        `;
    });
    
    listaResumo.innerHTML = html;
    
    // Atualizar preview geral
    const descontoGlobal = parseFloat(document.getElementById('desconto').value) || 0;
    const subtotalComDesconto = subtotalTotal - (subtotalTotal * (descontoGlobal / 100));
    const iva = subtotalComDesconto * 0.17;
    const total = subtotalComDesconto + iva;
    
    document.getElementById('preview_subtotal').textContent = `MZN ${subtotalTotal.toFixed(2).replace('.', ',')}`;
    document.getElementById('preview_desconto').textContent = `${descontoGlobal}%`;
    document.getElementById('preview_iva').textContent = `MZN ${iva.toFixed(2).replace('.', ',')}`;
    document.getElementById('preview_total').textContent = `MZN ${total.toFixed(2).replace('.', ',')}`;
}

function atualizarBotaoProcessar() {
    const btnProcessar = document.getElementById('processar');
    if (btnProcessar) {
        btnProcessar.disabled = servicosSelecionados.size === 0;
        
        if (servicosSelecionados.size === 0) {
            btnProcessar.title = 'Adicione pelo menos um serviço para continuar';
        } else {
            btnProcessar.title = 'Processar cotação';
        }
    }
}

    function mostrarSeletor() {
        const seletor = document.getElementById('seletor-servico');
        seletor.classList.toggle('hidden');
        
        // Focar no select
        if (!seletor.classList.contains('hidden')) {
            document.getElementById('selecionar-servico').focus();
        }
    }


    function processarCotacao() {
    console.log('Enviando dados via AJAX...');

    const btnProcessar = document.getElementById('processar');
    const form = document.getElementById('cotacaoForm');
    
    // Desabilitar botão para evitar múltiplos cliques
    btnProcessar.disabled = true;
    btnProcessar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processando...';

    const formData = new FormData(form);

    // Adicionar dados básicos corretamente
    formData.append('nome_cliente', getVal('nome_cliente'));
    formData.append('contacto', getVal('contacto'));
    formData.append('nuit', getVal('nuit'));
    formData.append('endereco', getVal('endereco'));
    formData.append('data_emissao', getVal('data_emissao'));
    formData.append('numero_cotacao', getVal('numero_cotacao'));
    formData.append('validade_dias', getVal('validade_dias'));
    formData.append('categoria', getVal('categoria'));
    formData.append('prazo_pagamento', getVal('prazoPagam'));
    formData.append('desconto', getVal('desconto'));
    formData.append('status', getVal('status') || 'Pendente');
    
    if (getVal('prazoPagam') === 'personalizado') {
        formData.append('prazo_personalizado', getVal('prazo_personalizado'));
    }

    // Adicionar os serviços selecionados CORRETAMENTE
    document.querySelectorAll('.servico-item').forEach((servico, index) => {
        const servicoId = servico.querySelector('input[name$="[servico_id]"]').value;
        const quantidade = servico.querySelector('.quantidade-servico').value;
        const desconto = servico.querySelector('.desconto-servico').value;
        const precoUnitario = servico.querySelector('input[name$="[preco_unitario]"]').value;
        const nome = servico.querySelector('input[name$="[nome]"]').value;
        const precoOriginal = servico.querySelector('input[name$="[preco_original]"]').value;

        formData.append(`servicos[${index}][servico_id]`, servicoId);
        formData.append(`servicos[${index}][quantidade]`, quantidade);
        formData.append(`servicos[${index}][desconto]`, desconto);
        formData.append(`servicos[${index}][preco_unitario]`, precoUnitario);
        formData.append(`servicos[${index}][nome]`, nome);
        formData.append(`servicos[${index}][preco_original]`, precoOriginal);
    });

    // DEBUG: Mostrar dados enviados
    console.log('=== DADOS ENVIADOS ===');
    for (let pair of formData.entries()) {
        console.log(`${pair[0]}: ${pair[1]}`);
    }

    // Obter URL da rota
    const url = "{{ route('cotacao.processar') }}";
    
    fetch(url, {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => {
        console.log('Status da resposta:', response.status);
        if (!response.ok) {
            // Tentar obter mais detalhes do erro
            return response.text().then(text => {
                console.error('Resposta do servidor:', text);
                throw new Error(`HTTP error! status: ${response.status}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Resposta completa:', data);
        
        if (!data.success) {
            throw new Error(data.message || 'Erro ao processar cotação');
        }
        
        cotacaoData = data;

        // Sucesso! Preencher o recibo com os dados retornados
        if (data.recibo) {
            preencherRecibo(data.recibo);
            
            // GERAR QR CODE AUTOMATICAMENTE AQUI!
            gerarQRCodeAutomaticamente(data.recibo);
            
            // Mostrar mensagem de sucesso
            mostrarNotificacao('success', '✅ Cotação processada com sucesso! QR Code gerado.');
            
            // Ir para step 2 após um breve delay
            setTimeout(() => {
                showStep(2);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 800);
        } else {
            throw new Error('Dados do recibo não recebidos');
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
        
        // Mostrar erro detalhado
        let mensagemErro = 'Erro ao processar cotação';
        if (error.message.includes('HTTP error')) {
            mensagemErro = 'Erro no servidor. Por favor, tente novamente.';
        } else if (error.message.includes('Failed to fetch')) {
            mensagemErro = 'Erro de conexão. Verifique sua internet.';
        } else {
            mensagemErro = error.message;
        }
        
        mostrarNotificacao('error', `❌ ${mensagemErro}`);
    })
    .finally(() => {
        // Restaurar botão
        btnProcessar.disabled = false;
        btnProcessar.innerHTML = '<i class="fa-solid fa-calculator mr-2"></i> Processar Cotação';
    });
}

    
    function preencherRecibo(dados) {
    console.log('Preenchendo recibo com dados:', dados);
    
    // ===== CABEÇALHO DO RECIBO =====
    document.getElementById('idCotacao').textContent = dados.cotacao.numero;
    document.getElementById('v_data_emissao').textContent = dados.cotacao.data_emissao;
    document.getElementById('v_validade').textContent = dados.cotacao.data_validade;
    
    // Status com badge colorido
    const statusBadge = document.getElementById('status_badge');
    if (statusBadge) {
        statusBadge.className = `px-4 py-2 rounded-full text-sm font-semibold ${dados.cotacao.status_badge[0]}`;
        statusBadge.textContent = dados.cotacao.status_badge[1];
    }
    
    // ===== INFORMAÇÕES DA EMPRESA =====
    document.getElementById('empresa_nome').textContent = dados.empresa.nome;
    document.getElementById('empresa_nuit').textContent = dados.empresa.nuit;
    document.getElementById('empresa_endereco').textContent = dados.empresa.endereco;
    document.getElementById('empresa_telefone').textContent = dados.empresa.telefone;
    document.getElementById('empresa_email').textContent = dados.empresa.email;
    
    // ===== INFORMAÇÕES DO CLIENTE =====
    document.getElementById('v_nome').textContent = dados.cliente.nome;
    document.getElementById('v_nuit').textContent = dados.cliente.nuit;
    document.getElementById('v_endereco').textContent = dados.cliente.endereco;
    document.getElementById('v_contacto').textContent = dados.cliente.contacto;
    
    // ===== DETALHES DA COTAÇÃO =====
    document.getElementById('v_categoria').textContent = 'Serviços Jurídicos';
    document.getElementById('v_prazo').textContent = dados.pagamento.prazo_dias;
    
    // ===== TABELA DE SERVIÇOS =====
    const tbodyServicos = document.getElementById('tabela-servicos');
    tbodyServicos.innerHTML = '';
    
    dados.servicos.forEach((servico, index) => {
        const tr = document.createElement('tr');
        tr.className = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
        tr.innerHTML = `
            <td class="px-4 py-3 text-sm">
                ${servico.nome}
            </td>
            <td class="px-4 py-3 text-center text-sm">
                ${servico.quantidade}
            </td>
            <td class="px-4 py-3 text-right text-sm">
                MZN ${servico.preco_formatado}
            </td>
            <td class="px-4 py-3 text-center text-sm">
                ${servico.desconto_percent}%
            </td>
            <td class="px-4 py-3 text-right text-sm font-medium">
                MZN ${servico.subtotal_formatado}
            </td>
        `;
        tbodyServicos.appendChild(tr);
    });
    
    // ===== RESUMO DE VALORES =====
    document.getElementById('subtotal').textContent = `MZN ${dados.valores.subtotal_formatado}`;
    document.getElementById('v_desconto_percent').textContent = dados.valores.desconto_global_percent;
    document.getElementById('v_desconto').textContent = `- MZN ${dados.valores.desconto_global_formatado}`;
    document.getElementById('iva').textContent = `MZN ${dados.valores.iva_formatado}`;
    document.getElementById('total').textContent = `MZN ${dados.valores.total_formatado}`;
    
    // ===== DETALHES ADICIONAIS =====
    document.getElementById('total_extenso').textContent = dados.valores.total_extenso;
    document.getElementById('observacoes').textContent = dados.observacoes;
    
    // ===== QR CODE =====
    // REMOVA A CHAMADA ANTIGA PARA atualizarQRCode()
    // O QR Code agora será gerado automaticamente em gerarQRCodeAutomaticamente()
    
    // Em vez disso, apenas prepare o container
    const qrContainer = document.getElementById('qr-code-container');
    if (qrContainer) {
        qrContainer.innerHTML = `
            <div class="text-center py-4">
                <div class="inline-block p-3 bg-gray-50 rounded-lg">
                    <i class="fa-solid fa-spinner fa-spin text-3xl text-blue-600"></i>
                    <p class="text-xs text-gray-600 mt-2">Gerando QR Code...</p>
                </div>
            </div>
        `;
    }
}


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
        notificacao.className = `notificacao-flutuante fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-xl text-white ${cores[tipo] || cores.info} border-l-4 transform transition-transform duration-300 translate-x-0`;
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
                notificacao.classList.add('translate-x-full');
                setTimeout(() => notificacao.remove(), 300);
            }
        }, 5000);
    }

// Função auxiliar para mostrar erros de validação
function mostrarErrosValidacao(errors) {
    let mensagem = 'Por favor, corrija os seguintes erros:\n\n';
    
    for (const campo in errors) {
        if (errors.hasOwnProperty(campo)) {
            mensagem += `• ${errors[campo].join(', ')}\n`;
        }
    }
    
    mostrarErro(mensagem);
}

// Função para mostrar mensagem de sucesso
function mostrarSucesso(mensagem) {
    // Você pode implementar um modal de sucesso ou usar alert
    alert(mensagem); // Substitua por um modal mais elegante
}



/* =========================================================
   FUNÇÕES AUXILIARES
========================================================= */
function getVal(id) {
    const elem = document.getElementById(id);
    return elem ? elem.value.trim() : '';
}

function erro(id, msg) {
    const input = document.getElementById(id);
    const errorSpan = document.getElementById(`error-${id}`);
    
    if (input) {
        input.classList.add('border-red-500');
        input.classList.add('input-error');
    }
    
    if (errorSpan) {
        errorSpan.textContent = msg;
        errorSpan.classList.remove('hidden');
    }
}

function limparErros(ids) {
    ids.forEach(id => {
        const input = document.getElementById(id);
        const errorSpan = document.getElementById(`error-${id}`);
        
        if (input) {
            input.classList.remove('border-red-500');
            input.classList.remove('input-error');
        }
        
        if (errorSpan) {
            errorSpan.classList.add('hidden');
        }
    });
}

function validarContacto(c) {
    // Remove espaços e valida formato moçambicano
    const limpo = c.replace(/\s/g, '');
    return /^(8[2-7])\d{7}$/.test(limpo);
}

function preencherResumoCliente() {
    document.getElementById('cliente_nome').textContent = getVal('nome_cliente');
    document.getElementById('cliente_contacto').textContent = getVal('contacto');
    document.getElementById('cliente_nuit').textContent = getVal('nuit') || '—';
    document.getElementById('cliente_endereco').textContent = getVal('endereco') || '—';
}

function gerarNumeroCotacao() {
    const d = new Date();
    const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
    const numero = `COT-${d.getFullYear()}${(d.getMonth()+1).toString().padStart(2, '0')}${d.getDate().toString().padStart(2, '0')}-${random}`;
    
    const inputNumero = document.getElementById('numero_cotacao');
    if (inputNumero) {
        inputNumero.value = numero;
    }
}

function syncDescontoRange(e) {
    document.getElementById('desconto').value = e.target.value;
    atualizarResumoServicos();
}

function syncDescontoInput(e) {
    let valor = parseInt(e.target.value);
    if (isNaN(valor)) valor = 0;
    if (valor < 0) valor = 0;
    if (valor > 50) valor = 50;
    
    e.target.value = valor;
    document.getElementById('desconto_range').value = valor;
    atualizarResumoServicos();
}

function togglePrazoPersonalizado(e) {
    const campoPersonalizado = document.getElementById('prazo_personalizado');
    if (campoPersonalizado) {
        if (e.target.value === 'personalizado') {
            campoPersonalizado.classList.remove('hidden');
            campoPersonalizado.required = true;
        } else {
            campoPersonalizado.classList.add('hidden');
            campoPersonalizado.required = false;
        }
    }
}

function formatarData(dataStr) {
    if (!dataStr) return '—';
    const data = new Date(dataStr);
    return data.toLocaleDateString('pt-MZ', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

function mostrarErro(mensagem) {
    const modal = document.getElementById('errorModal');
    const mensagemElem = document.getElementById('errorMessage');
    
    if (modal && mensagemElem) {
        mensagemElem.textContent = mensagem;
        modal.classList.remove('hidden');
    } else {
        alert(mensagem);
    }
}

function formatMZN(valor) {
    return `MZN ${valor.toFixed(2).replace('.', ',')}`;
}

/* =========================================================
   FUNÇÕES DO STEP 2 - VISUALIZAÇÃO/FINALIZAÇÃO
========================================================= */
function imprimirCotacao() {
    // Criar um formulário temporário para envio ao backend
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "{{ route('cotacao.pdf') }}";
    form.target = '_blank';
    
    // Adicionar token CSRF
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = "{{ csrf_token() }}";
    form.appendChild(csrf);
    
    // Coletar dados para impressão
    const dados = {
        numero_cotacao: getVal('numero_cotacao'),
        nome_cliente: getVal('nome_cliente'),
        nuit: getVal('nuit'),
        endereco: getVal('endereco'),
        contacto: getVal('contacto'),
        servico_nome: document.getElementById('v_servico').textContent,
        subtotal: document.getElementById('subtotal').textContent,
        desconto: getVal('desconto'),
        desconto_valor: document.getElementById('v_desconto').textContent,
        iva: document.getElementById('iva').textContent,
        total: document.getElementById('total').textContent,
        data_emissao: getVal('data_emissao'),
        validade_dias: getVal('validade_dias')
    };
    
    // Adicionar campos ao formulário
    for (const key in dados) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = dados[key];
        form.appendChild(input);
    }
    
    // Enviar formulário
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function salvarCotacao() {
    // Aqui você pode adicionar lógica para salvar via AJAX se necessário
    // Por padrão, o formulário será submetido normalmente
    document.getElementById('cotacaoForm').submit();
}

function novaCotacao() {
    if (confirm('Deseja criar uma nova cotação? Os dados atuais serão perdidos.')) {
        location.reload();
    }
}

function sair() {
    if (confirm('Tem certeza que deseja sair? Os dados não salvos serão perdidos.')) {
        window.location.href = "#";
    }
}

// Adicionar evento ao botão de salvar
document.addEventListener('DOMContentLoaded', function() {
    const btnSalvar = document.getElementById('btn-salvar');
    if (btnSalvar) {
        btnSalvar.addEventListener('click', salvarCotacao);
    }
});


	function imprimirCotacao() {
		const form = document.createElement('form');
		form.method = 'POST';
		form.action = "{{ route('cotacao.pdf') }}";
		form.target = '_blank';

		const csrf = document.createElement('input');
		csrf.type = 'hidden';
		csrf.name = '_token';
		csrf.value = "{{ csrf_token() }}";
		form.appendChild(csrf);

		const dados = {
			numero_cotacao: getVal('numero_cotacao'),
			nome_cliente: getVal('nome_cliente'),
			nuit: getVal('nuit'),
			endereco: getVal('endereco'),
			contacto: getVal('contacto'),
			servico_nome: document.getElementById('servico').selectedOptions[0].text,
			subtotal: document.getElementById('subtotal').textContent,
			desconto: getVal('desconto'),
			desconto_valor: document.getElementById('v_desconto').textContent,
			iva: document.getElementById('iva').textContent,
			total: document.getElementById('total').textContent,
			data_emissao: getVal('data_emissao'),
			validade_dias: getVal('validade_dias')
		};

		for (const key in dados) {
			const input = document.createElement('input');
			input.type = 'hidden';
			input.name = key;
			input.value = dados[key];
			form.appendChild(input);
		}

		document.body.appendChild(form);
		form.submit();
		document.body.removeChild(form);
	}







    /* =========================================================
   FUNÇÕES PARA MODAIS DE ENVIO
========================================================= */

// Variáveis globais para os modais
let cotacaoDados = null;

    // Função para abrir modal de escolha
    function abrirModalEscolha() {
        console.log('Abrindo modal de escolha...');
        console.log('cotacaoData:', cotacaoData);
        
        // Verificar se temos dados da cotação
        if (!cotacaoData || !cotacaoData.recibo) {
            console.error('Dados da cotação não disponíveis:', cotacaoData);
            mostrarNotificacao('error', 'Nenhuma cotação processada para envio! Processe a cotação primeiro.');
            return;
        }
        
        document.getElementById('modalEscolhaEnvio').classList.remove('hidden');
    }

function fecharModalEscolha() {
    document.getElementById('modalEscolhaEnvio').classList.add('hidden');
}

// Funções WhatsApp
function abrirModalWhatsApp() {
    fecharModalEscolha();
    
    // Preencher número do cliente automaticamente
    const whatsappNumero = document.getElementById('whatsappNumero');
    if (cotacaoData.recibo.cliente.contacto) {
        // Remover o +258 se existir e espaços
        const contacto = cotacaoData.recibo.cliente.contacto.replace('+258', '').replace(/\s/g, '');
        whatsappNumero.value = contacto;
    }
    
    // Gerar mensagem padrão
    const mensagemPadrao = gerarMensagemWhatsAppPadrao();
    document.getElementById('whatsappMensagem').value = mensagemPadrao;
    
    // Mostrar pré-visualização
    atualizarPreviewWhatsApp();
    
    document.getElementById('modalWhatsApp').classList.remove('hidden');
}

function fecharModalWhatsApp() {
    document.getElementById('modalWhatsApp').classList.add('hidden');
}

function gerarMensagemWhatsAppPadrao() {
    if (!cotacaoData.recibo) return '';
    
    const recibo = cotacaoData.recibo;
    let mensagem = `*COTAÇÃO DE SERVIÇOS*\n\n`;
    mensagem += `Olá ${recibo.cliente.nome},\n\n`;
    mensagem += `Segue sua cotação de serviços:\n\n`;
    mensagem += `*Número:* ${recibo.cotacao.numero}\n`;
    mensagem += `*Validade:* ${recibo.cotacao.data_validade}\n`;
    mensagem += `*Valor Total:* ${recibo.valores.total_formatado}\n\n`;
    mensagem += `*Detalhes:*\n`;
    
    recibo.servicos.forEach((servico, index) => {
        mensagem += `• ${servico.nome}: ${servico.subtotal_formatado}\n`;
    });
    
    mensagem += `\n*Resumo:*\n`;
    mensagem += `Subtotal: ${recibo.valores.subtotal_formatado}\n`;
    mensagem += `Desconto: ${recibo.valores.desconto_global_formatado}\n`;
    mensagem += `IVA (17%): ${recibo.valores.iva_formatado}\n`;
    mensagem += `*TOTAL: ${recibo.valores.total_formatado}*\n\n`;
    mensagem += `Esta cotação é válida até ${recibo.cotacao.data_validade}.\n`;
    mensagem += `Para aprovação ou dúvidas, entre em contato.\n\n`;
    mensagem += `Atenciosamente,\n`;
    mensagem += `${recibo.empresa.nome}\n`;
    mensagem += `${recibo.empresa.telefone}`;
    
    return mensagem;
}

function atualizarPreviewWhatsApp() {
    const preview = document.getElementById('whatsappPreview');
    const previewText = document.getElementById('previewText');
    const mensagem = document.getElementById('whatsappMensagem').value;
    
    if (mensagem.length > 0) {
        preview.classList.remove('hidden');
        previewText.textContent = mensagem.substring(0, 150) + (mensagem.length > 150 ? '...' : '');
    } else {
        preview.classList.add('hidden');
    }
}

// Funções Email
function abrirModalEmail() {
    fecharModalEscolha();
    
    // Preencher email do cliente se disponível (você pode adicionar campo de email no formulário)
    const emailCliente = document.getElementById('emailCliente');
    if (cotacaoData.recibo.cliente.email) {
        emailCliente.value = cotacaoData.recibo.cliente.email;
    }
    
    // Gerar mensagem padrão para email
    const mensagemPadrao = gerarMensagemEmailPadrao();
    document.getElementById('mensagemEmail').value = mensagemPadrao;
    
    document.getElementById('modalEmail').classList.remove('hidden');
}

function fecharModalEmail() {
    document.getElementById('modalEmail').classList.add('hidden');
}

function gerarMensagemEmailPadrao() {
    if (!cotacaoData.recibo) return '';
    
    const recibo = cotacaoData.recibo;
    let mensagem = `Prezado(a) ${recibo.cliente.nome},\n\n`;
    mensagem += `Segue em anexo a cotação de serviços solicitada.\n\n`;
    mensagem += `**Detalhes da Cotação:**\n`;
    mensagem += `- Número: ${recibo.cotacao.numero}\n`;
    mensagem += `- Data de Emissão: ${recibo.cotacao.data_emissao}\n`;
    mensagem += `- Validade: ${recibo.cotacao.data_validade}\n`;
    mensagem += `- Valor Total: ${recibo.valores.total_formatado}\n\n`;
    
    mensagem += `**Serviços Incluídos:**\n`;
    recibo.servicos.forEach((servico, index) => {
        mensagem += `• ${servico.nome} - ${servico.subtotal_formatado}\n`;
    });
    
    mensagem += `\n**Resumo Financeiro:**\n`;
    mensagem += `Subtotal: ${recibo.valores.subtotal_formatado}\n`;
    mensagem += `Desconto Global: ${recibo.valores.desconto_global_formatado}\n`;
    mensagem += `IVA (17%): ${recibo.valores.iva_formatado}\n`;
    mensagem += `**Total: ${recibo.valores.total_formatado}**\n\n`;
    
    mensagem += `Esta cotação é válida até ${recibo.cotacao.data_validade}.\n`;
    mensagem += `Para aprovação, dúvidas ou ajustes, entre em contato conosco.\n\n`;
    mensagem += `Atenciosamente,\n`;
    mensagem += `${recibo.empresa.nome}\n`;
    mensagem += `${recibo.empresa.telefone}\n`;
    mensagem += `${recibo.empresa.email}`;
    
    return mensagem;
}



/* =========================================================
   ENVIO VIA WHATSAPP
========================================================= */
document.getElementById('whatsappForm').addEventListener('submit', function(e) {
    e.preventDefault();
    enviarPorWhatsApp();
});

async function enviarPorWhatsApp() {
    const btnEnviar = document.getElementById('btnEnviarWhatsApp');
    const numeroInput = document.getElementById('whatsappNumero').value;
    const mensagem = document.getElementById('whatsappMensagem').value;
    
    // Validar número
    const numeroLimpo = numeroInput.replace(/\s/g, '').replace('+258', '');
    if (!/^(8[2-7])\d{7}$/.test(numeroLimpo)) {
        mostrarNotificacao('error', 'Número de WhatsApp inválido! Use formato: 84 123 4567');
        return;
    }
    
    if (!mensagem.trim()) {
        mostrarNotificacao('error', 'Digite uma mensagem para enviar!');
        return;
    }
    
    btnEnviar.disabled = true;
    btnEnviar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Enviando...';
    
    try {
        // Formatar número internacional
        const numeroInternacional = `258${numeroLimpo}`;
        
        // Criar mensagem final com formatação WhatsApp
        let mensagemFinal = mensagem;
        
        // Adicionar resumo se selecionado
        if (document.getElementById('whatsappResumo').checked) {
            mensagemFinal += `\n\n---\n*RESUMO RÁPIDO:*\n`;
            mensagemFinal += `Cotação: ${cotacaoData.recibo.cotacao.numero}\n`;
            mensagemFinal += `Valor: ${cotacaoData.recibo.valores.total_formatado}\n`;
            mensagemFinal += `Validade: ${cotacaoData.recibo.cotacao.data_validade}`;
        }
        
        // Codificar mensagem para URL
        const mensagemCodificada = encodeURIComponent(mensagemFinal);
        
        // Criar link do WhatsApp
        const whatsappLink = `https://wa.me/${numeroInternacional}?text=${mensagemCodificada}`;
        
        // Se quiser enviar imagem também
        if (document.getElementById('whatsappImagem').checked) {
            // Primeiro, gerar imagem do recibo
            await gerarImagemRecibo();
            // O link seria diferente para enviar imagem + texto
            // Para simplificar, vamos apenas abrir o link normal
        }
        
        // Abrir WhatsApp em nova aba
        window.open(whatsappLink, '_blank');
        
        mostrarNotificacao('success', '✅ WhatsApp aberto! Cole a mensagem e envie.');
        
        // Fechar modal após 2 segundos
        setTimeout(() => {
            fecharModalWhatsApp();
        }, 2000);
        
    } catch (error) {
        console.error('Erro ao enviar WhatsApp:', error);
        mostrarNotificacao('error', 'Erro ao preparar envio do WhatsApp.');
    } finally {
        btnEnviar.disabled = false;
        btnEnviar.innerHTML = '<i class="fa-brands fa-whatsapp mr-2"></i> Enviar WhatsApp';
    }
}

/* =========================================================
   ENVIO VIA EMAIL
========================================================= */
document.getElementById('emailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    enviarPorEmail();
});

async function enviarPorEmail() {
    const btnEnviar = document.getElementById('btnEnviarEmail');
    const emailCliente = document.getElementById('emailCliente').value;
    const assunto = document.getElementById('assuntoEmail').value;
    const mensagem = document.getElementById('mensagemEmail').value;
    
    if (!emailCliente) {
        mostrarNotificacao('error', 'Digite o email do cliente!');
        return;
    }
    
    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailCliente)) {
        mostrarNotificacao('error', 'Email inválido! Digite um email válido.');
        return;
    }
    
    btnEnviar.disabled = true;
    btnEnviar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Enviando...';
    
    try {
        // Preparar dados do email
        const dadosEmail = {
            to_email: emailCliente,
            subject: assunto,
            message: mensagem || gerarMensagemEmailPadrao(),
            cotacao_data: cotacaoData.recibo,
            enviar_pdf: document.getElementById('enviarPDF').checked,
            enviar_resumo: document.getElementById('enviarResumo').checked,
            enviar_cc: document.getElementById('enviarCC').checked
        };
        
        // Enviar para o backend
        const response = await fetch("{{ route('cotacao.enviar-email') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify(dadosEmail)
        });
        
        const data = await response.json();
        
        if (data.success) {
            mostrarNotificacao('success', '✅ Email enviado com sucesso!');
            
            // Fechar modal após 2 segundos
            setTimeout(() => {
                fecharModalEmail();
            }, 2000);
        } else {
            throw new Error(data.message || 'Erro ao enviar email');
        }
        
    } catch (error) {
        console.error('Erro ao enviar email:', error);
        mostrarNotificacao('error', '❌ Erro ao enviar email: ' + error.message);
    } finally {
        btnEnviar.disabled = false;
        btnEnviar.innerHTML = '<i class="fa-solid fa-paper-plane mr-2"></i> Enviar Email';
    }
}

/* =========================================================
   GERAR IMAGEM DO RECIBO PARA WHATSAPP
========================================================= */
async function gerarImagemRecibo() {
    try {
        // Usar html2canvas para capturar o recibo
        if (typeof html2canvas === 'undefined') {
            console.warn('html2canvas não carregado. Instale: npm install html2canvas');
            return null;
        }
        
        const reciboElement = document.querySelector('#step-2 .bg-white.border');
        if (!reciboElement) {
            console.warn('Elemento do recibo não encontrado');
            return null;
        }
        
        // Mostrar loading
        mostrarNotificacao('info', 'Gerando imagem do recibo...');
        
        const canvas = await html2canvas(reciboElement, {
            scale: 2,
            useCORS: true,
            logging: false,
            backgroundColor: '#ffffff'
        });
        
        // Converter para blob
        return new Promise((resolve) => {
            canvas.toBlob((blob) => {
                resolve(blob);
            }, 'image/jpeg', 0.9);
        });
        
    } catch (error) {
        console.error('Erro ao gerar imagem:', error);
        return null;
    }
}

/* =========================================================
   EVENT LISTENERS PARA OS FORMULÁRIOS
========================================================= */
document.addEventListener('DOMContentLoaded', function() {
    // Atualizar preview do WhatsApp em tempo real
    const whatsappMensagem = document.getElementById('whatsappMensagem');
    if (whatsappMensagem) {
        whatsappMensagem.addEventListener('input', atualizarPreviewWhatsApp);
    }
    
    // Adicionar evento para fechar modais com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalEscolha();
            fecharModalWhatsApp();
            fecharModalEmail();
        }
    });
    
    // Clique fora para fechar modais
    document.querySelectorAll('#modalEscolhaEnvio, #modalWhatsApp, #modalEmail').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                if (this.id === 'modalEscolhaEnvio') fecharModalEscolha();
                if (this.id === 'modalWhatsApp') fecharModalWhatsApp();
                if (this.id === 'modalEmail') fecharModalEmail();
            }
        });
    });
});

/* =========================================================
   FUNÇÃO PARA ENVIO RÁPIDO VIA WHATSAPP (alternativa)
========================================================= */
function enviarWhatsAppRapido() {
    if (!cotacaoData.recibo) {
        mostrarNotificacao('error', 'Nenhuma cotação para enviar!');
        return;
    }
    
    const recibo = cotacaoData.recibo;
    const contactoCliente = recibo.cliente.contacto;
    
    if (!contactoCliente) {
        // Abrir modal para digitar número
        abrirModalWhatsApp();
        return;
    }
    
    // Formatar número
    const numeroLimpo = contactoCliente.replace(/\s/g, '').replace('+258', '');
    
    if (!/^(8[2-7])\d{7}$/.test(numeroLimpo)) {
        mostrarNotificacao('error', 'Número do cliente inválido para WhatsApp!');
        abrirModalWhatsApp();
        return;
    }
    
    // Gerar mensagem resumida
    let mensagem = `*COTAÇÃO ${recibo.cotacao.numero}*\n\n`;
    mensagem += `Olá ${recibo.cliente.nome},\n\n`;
    mensagem += `Sua cotação está pronta!\n`;
    mensagem += `Valor: *${recibo.valores.total_formatado}*\n`;
    mensagem += `Validade: ${recibo.cotacao.data_validade}\n\n`;
    mensagem += `Detalhes completos em anexo.\n\n`;
    mensagem += `${recibo.empresa.nome}\n`;
    mensagem += `${recibo.empresa.telefone}`;
    
    const mensagemCodificada = encodeURIComponent(mensagem);
    const whatsappLink = `https://wa.me/258${numeroLimpo}?text=${mensagemCodificada}`;
    
    // Abrir WhatsApp
    window.open(whatsappLink, '_blank');
    
    mostrarNotificacao('success', 'WhatsApp aberto! Revise e envie a mensagem.');
}

// Você pode adicionar um botão para envio rápido também
function adicionarBotaoEnvioRapido() {
    // Adicione este botão no HTML se quiser
    /*
    <button type="button" onclick="enviarWhatsAppRapido()"
            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition flex items-center">
        <i class="fa-brands fa-whatsapp mr-2"></i> WhatsApp Rápido
    </button>
    */
}






/* =========================================================
   FUNÇÕES DE IMPRESSÃO DO RECIBO
========================================================= */

function imprimirRecibo() {
    if (!cotacaoData || !cotacaoData.recibo) {
        mostrarNotificacao('error', 'Nenhuma cotação processada para impressão!');
        return;
    }

    // Mostrar modal de opções de impressão
    mostrarModalImpressao();
}

function mostrarModalImpressao() {
    const modalHTML = `
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">
                        <i class="fa-solid fa-print mr-2 text-blue-600"></i>
                        Opções de Impressão
                    </h3>
                    <button onclick="fecharModalImpressao()" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Selecione o que imprimir:</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="impressaoCompleta" name="tipoImpressao" value="completa" class="mr-2" checked>
                                <label for="impressaoCompleta" class="text-sm text-gray-700">
                                    <i class="fa-solid fa-file-invoice mr-1"></i> Recibo completo
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="impressaoSimplificada" name="tipoImpressao" value="simplificada" class="mr-2">
                                <label for="impressaoSimplificada" class="text-sm text-gray-700">
                                    <i class="fa-solid fa-receipt mr-1"></i> Versão simplificada
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="impressaoServicos" name="tipoImpressao" value="servicos" class="mr-2">
                                <label for="impressaoServicos" class="text-sm text-gray-700">
                                    <i class="fa-solid fa-list-check mr-1"></i> Apenas serviços
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Opções adicionais:</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="imprimirCores" class="mr-2" checked>
                                <label for="imprimirCores" class="text-sm text-gray-700">
                                    Manter cores
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="imprimirQRCode" class="mr-2" checked>
                                <label for="imprimirQRCode" class="text-sm text-gray-700">
                                    Incluir QR Code
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="imprimirObservacoes" class="mr-2" checked>
                                <label for="imprimirObservacoes" class="text-sm text-gray-700">
                                    Incluir observações
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="imprimirCabecalho" class="mr-2" checked>
                                <label for="imprimirCabecalho" class="text-sm text-gray-700">
                                    Incluir cabeçalho da empresa
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h4 class="font-medium text-blue-800 mb-1">
                            <i class="fa-solid fa-lightbulb mr-2"></i>Dica
                        </h4>
                        <p class="text-sm text-blue-700">
                            Para melhor qualidade, use a opção "Salvar como PDF" na impressora.
                        </p>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="fecharModalImpressao()"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="button" onclick="executarImpressao()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                        <i class="fa-solid fa-print mr-2"></i>
                        Imprimir Agora
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Adicionar modal ao DOM
    const modalDiv = document.createElement('div');
    modalDiv.id = 'modalImpressao';
    modalDiv.innerHTML = modalHTML;
    document.body.appendChild(modalDiv);
    
    // Adicionar evento para fechar com ESC
    document.addEventListener('keydown', function fecharComESC(e) {
        if (e.key === 'Escape') {
            fecharModalImpressao();
            document.removeEventListener('keydown', fecharComESC);
        }
    });
}

function fecharModalImpressao() {
    const modal = document.getElementById('modalImpressao');
    if (modal) {
        modal.remove();
    }
}

function executarImpressao() {
    const tipoImpressao = document.querySelector('input[name="tipoImpressao"]:checked').value;
    const imprimirCores = document.getElementById('imprimirCores').checked;
    const imprimirQRCode = document.getElementById('imprimirQRCode').checked;
    const imprimirObservacoes = document.getElementById('imprimirObservacoes').checked;
    const imprimirCabecalho = document.getElementById('imprimirCabecalho').checked;
    
    fecharModalImpressao();
    
    // Adicionar classes CSS para impressão
    const reciboElement = document.querySelector('#step-2 .bg-white.border');
    if (!reciboElement) {
        mostrarNotificacao('error', 'Elemento do recibo não encontrado!');
        return;
    }
    
    // Clonar o elemento para modificar sem afetar a visualização
    const clone = reciboElement.cloneNode(true);
    
    // Aplicar estilos baseados nas opções
    if (!imprimirCores) {
        clone.classList.add('print-no-colors');
    }
    
    if (!imprimirQRCode) {
        const qrContainer = clone.querySelector('#qr-code-container');
        if (qrContainer) {
            qrContainer.remove();
        }
    }
    
    if (!imprimirObservacoes) {
        const observacoes = clone.querySelector('#observacoes');
        if (observacoes && observacoes.parentElement) {
            observacoes.parentElement.remove();
        }
    }
    
    if (!imprimirCabecalho) {
        const cabecalho = clone.querySelector('.bg-gradient-to-r');
        if (cabecalho) {
            cabecalho.remove();
        }
    }
    
    // Aplicar estilos de impressão
    const printStyles = `
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                .print-content, .print-content * {
                    visibility: visible !important;
                }
                .print-content {
                    position: absolute !important;
                    left: 0 !important;
                    top: 0 !important;
                    width: 100% !important;
                    max-width: 100% !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    box-shadow: none !important;
                    background: white !important;
                }
                .no-print, button, .flex.justify-between.items-center.mb-6 {
                    display: none !important;
                }
                .print-no-colors .bg-gradient-to-r {
                    background: #f3f4f6 !important;
                    color: #000 !important;
                    border: 1px solid #d1d5db !important;
                }
                .print-no-colors .text-brand-primary {
                    color: #000 !important;
                }
                .print-no-colors .bg-green-100, 
                .print-no-colors .bg-red-100,
                .print-no-colors .bg-blue-100,
                .print-no-colors .bg-yellow-100 {
                    background: #f9fafb !important;
                }
                .break-before {
                    page-break-before: always;
                }
                .break-after {
                    page-break-after: always;
                }
                .break-inside {
                    page-break-inside: avoid;
                }
            }
            
            /* Estilos temporários para o clone */
            .print-temp {
                position: fixed;
                top: -10000px;
                left: -10000px;
                z-index: 10000;
                width: 210mm; /* A4 */
                min-height: 297mm;
                padding: 20mm;
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
        </style>
    `;
    
    // Adicionar estilos
    clone.classList.add('print-content', 'print-temp');
    clone.insertAdjacentHTML('beforeend', printStyles);
    
    // Adicionar ao DOM temporariamente
    document.body.appendChild(clone);
    
    // Configurar cabeçalho e rodapé da impressão
    const dataAtual = new Date().toLocaleDateString('pt-MZ');
    const numeroCotacao = document.getElementById('idCotacao')?.textContent || 'N/A';
    
    // Configurar impressão
    const printConfig = `
        <title>Cotacao_${numeroCotacao}_${dataAtual.replace(/\//g, '-')}</title>
        <style>
            @page {
                size: A4;
                margin: 20mm;
                @top-center {
                    content: "Cotação ${numeroCotacao} - ${cotacaoData.recibo.empresa.nome}";
                    font-size: 10pt;
                    color: #666;
                }
                @bottom-center {
                    content: "Página " counter(page) " de " counter(pages);
                    font-size: 10pt;
                    color: #666;
                }
                @bottom-left {
                    content: "Impresso em: ${dataAtual}";
                    font-size: 8pt;
                    color: #999;
                }
                @bottom-right {
                    content: "Confidencial";
                    font-size: 8pt;
                    color: #999;
                }
            }
        </style>
    `;
    
    // Adicionar configuração ao head
    const configElement = document.createElement('div');
    configElement.innerHTML = printConfig;
    document.head.appendChild(configElement);
    
    // Mostrar notificação de preparação
    mostrarNotificacao('info', 'Preparando impressão...');
    
    // Aguardar um momento para carregar estilos
    setTimeout(() => {
        // Executar impressão
        window.print();
        
        // Remover elementos temporários após impressão
        setTimeout(() => {
            clone.remove();
            configElement.remove();
            
            // Mostrar notificação de sucesso
            mostrarNotificacao('success', 'Impressão concluída!');
        }, 1000);
        
    }, 500);
}


/* =========================================================
   GERAR PDF DA COTAÇÃO
========================================================= */

async function gerarPDF() {
    if (!cotacaoData || !cotacaoData.recibo) {
        mostrarNotificacao('error', 'Nenhuma cotação processada para gerar PDF!');
        return;
    }
    
    mostrarNotificacao('info', 'Gerando PDF...');
    
    try {
        // Criar um formulário tradicional (não AJAX)
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('cotacao.pdf') }}";
        form.target = '_blank';
        form.style.display = 'none';
        
        // Adicionar token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        // Adicionar dados da cotação
        const dadosInput = document.createElement('input');
        dadosInput.type = 'hidden';
        dadosInput.name = 'cotacao_data';
        dadosInput.value = JSON.stringify(cotacaoData.recibo);
        form.appendChild(dadosInput);
        
        // Adicionar também os campos básicos para compatibilidade
        const camposAdicionais = {
            'numero_cotacao': cotacaoData.recibo.cotacao?.numero || '',
            'nome_cliente': cotacaoData.recibo.cliente?.nome || '',
            'nuit': cotacaoData.recibo.cliente?.nuit || '',
            'endereco': cotacaoData.recibo.cliente?.endereco || '',
            'contacto': cotacaoData.recibo.cliente?.contacto || '',
            'data_emissao': cotacaoData.recibo.cotacao?.data_emissao || '',
            'validade_dias': cotacaoData.recibo.cotacao?.validade_dias || '15'
        };
        
        for (const [key, value] of Object.entries(camposAdicionais)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }
        
        // Adicionar ao DOM e submeter
        document.body.appendChild(form);
        form.submit();
        
        // Remover após alguns segundos
        setTimeout(() => {
            if (form.parentNode) {
                document.body.removeChild(form);
            }
            mostrarNotificacao('success', 'PDF gerado com sucesso! Verifique sua nova aba.');
        }, 1000);
        
    } catch (error) {
        console.error('Erro ao gerar PDF:', error);
        mostrarNotificacao('error', 'Erro ao gerar PDF: ' + error.message);
    }
}


/* =========================================================
   GERAR QR CODE AUTOMATICAMENTE APÓS PROCESSAR COTAÇÃO
========================================================= */

function gerarQRCodeAutomaticamente(dadosRecibo) {
    console.log('Gerando QR Code automaticamente...');
    
    const qrCodeContainer = document.getElementById('qr-code-container');
    if (!qrCodeContainer) {
        console.error('Container do QR Code não encontrado!');
        return;
    }
    
    // Limpar container primeiro
    qrCodeContainer.innerHTML = '<div class="text-center py-4"><i class="fa-solid fa-spinner fa-spin text-2xl text-blue-600"></i><p class="text-sm text-gray-600 mt-2">Gerando QR Code...</p></div>';
    
    // Verificar se a biblioteca está carregada
    if (typeof QRCode === 'undefined') {
        console.error('Biblioteca QRCode não disponível!');
        
        // Tentar carregar dinamicamente
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js';
        script.onload = () => {
            console.log('QRCode carregado dinamicamente');
            gerarQRCode(dadosRecibo);
        };
        script.onerror = () => {
            console.error('Falha ao carregar QRCode');
            mostrarQRCodeFallback(qrCodeContainer, dadosRecibo);
        };
        document.head.appendChild(script);
        return;
    }
    
    // Se já estiver carregado, gerar normalmente
    setTimeout(() => gerarQRCode(dadosRecibo), 100);
}

function gerarQRCode(dadosRecibo) {
    const qrCodeContainer = document.getElementById('qr-code-container');
    const textoQR = criarTextoQRCode(dadosRecibo);
    
    try {
        // Limpar container
        qrCodeContainer.innerHTML = '';
        
        // Gerar QR Code
        new QRCode(qrCodeContainer, {
            text: textoQR,
            width: 160,
            height: 160,
            colorDark: "#2c5282",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        
        // Adicionar estilos
        const canvas = qrCodeContainer.querySelector('canvas');
        if (canvas) {
            canvas.className = 'mx-auto border border-gray-200 rounded-lg shadow-sm';
        }
        
    } catch (error) {
        console.error('Erro ao gerar QR Code:', error);
        mostrarQRCodeFallback(qrCodeContainer, dadosRecibo);
    }
}

function mostrarQRCodeFallback(container, dados) {
    container.innerHTML = `
        <div class="text-center p-4">
            <div class="inline-block p-4 bg-gray-100 rounded-lg">
                <div class="grid grid-cols-4 gap-1 mb-2">
                    ${Array(16).fill('<div class="w-6 h-6 bg-gray-800"></div>').join('')}
                </div>
                <p class="text-xs font-mono">${dados.cotacao.numero}</p>
                <p class="text-xs text-gray-600 mt-2">Código: ${dados.cotacao.numero}</p>
            </div>
        </div>
    `;
}






/* =========================================================
   CRIAR TEXTO PARA QR CODE
========================================================= */
function criarTextoQRCode(dados) {
    const dataAtual = new Date().toLocaleDateString('pt-MZ');
    
    return `COTAÇÃO DE SERVIÇOS\n` +
           `====================\n` +
           `Número: ${dados.cotacao.numero}\n` +
           `Cliente: ${dados.cliente.nome}\n` +
           `Valor: ${dados.valores.total_formatado}\n` +
           `Emissão: ${dados.cotacao.data_emissao}\n` +
           `Validade: ${dados.cotacao.data_validade}\n` +
           `Status: ${dados.cotacao.status}\n` +
           `====================\n` +
           `${dados.empresa.nome}\n` +
           `NUIT: ${dados.empresa.nuit}\n` +
           `Tel: ${dados.empresa.telefone}\n` +
           `Email: ${dados.empresa.email}\n` +
           `====================\n` +
           `Gerado em: ${dataAtual}`;
}

/* =========================================================
   MOSTRAR QR CODE SIMPLES (FALLBACK)
========================================================= */
function mostrarQRCodeSimples(container, texto) {
    const textoResumido = texto.substring(0, 80) + (texto.length > 80 ? '...' : '');
    
    container.innerHTML = `
        <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div class="mb-3">
                <div class="inline-block p-4 bg-white border-2 border-dashed border-gray-300 rounded-lg">
                    <i class="fa-solid fa-qrcode text-5xl text-gray-400"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-700 mb-2">Código da Cotação</p>
            <div class="bg-white p-3 rounded border border-gray-200 mb-2">
                <p class="text-xs font-mono text-gray-800 break-all">${textoResumido}</p>
            </div>
            <p class="text-xs text-gray-500">
                <i class="fa-solid fa-mobile-screen mr-1"></i>
                Use app de leitor QR para escanear
            </p>
            <button onclick="copiarTextoQR('${texto.replace(/'/g, "\\'")}')" 
                    class="mt-2 text-xs text-blue-600 hover:text-blue-800">
                <i class="fa-solid fa-copy mr-1"></i> Copiar texto
            </button>
        </div>
    `;
}

/* =========================================================
   COPIAR TEXTO DO QR CODE
========================================================= */
function copiarTextoQR(texto) {
    navigator.clipboard.writeText(texto).then(() => {
        mostrarNotificacao('success', '✅ Texto do QR Code copiado!');
    }).catch(err => {
        console.error('Erro ao copiar texto:', err);
        mostrarNotificacao('error', '❌ Erro ao copiar texto');
    });
}

/* =========================================================
   BAIXAR QR CODE COMO IMAGEM
========================================================= */
function baixarQRCode(canvas, nomeArquivo) {
    try {
        // Converter canvas para data URL
        const dataURL = canvas.toDataURL('image/png');
        
        // Criar link para download
        const link = document.createElement('a');
        link.href = dataURL;
        link.download = nomeArquivo || 'QRCode_Cotacao.png';
        link.style.display = 'none';
        
        // Adicionar ao DOM e clicar
        document.body.appendChild(link);
        link.click();
        
        // Remover link
        document.body.removeChild(link);
        
        // Mostrar notificação
        mostrarNotificacao('success', '✅ QR Code baixado com sucesso!');
        
    } catch (error) {
        console.error('Erro ao baixar QR Code:', error);
        mostrarNotificacao('error', '❌ Erro ao baixar QR Code');
    }
}



</script>
@endsection