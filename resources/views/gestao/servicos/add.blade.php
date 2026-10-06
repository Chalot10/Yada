@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 mt-8">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        <i class="fa-solid fa-layer-group text-blue-600 mr-2"></i>
        Cadastro de Serviços
    </h1>

    {{-- Mensagens --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('gestao.servicos.store') }}">
        @csrf
        @method('POST') 

        {{-- ===============================
             ETAPA 0: SELECIONAR CATEGORIA
        ================================= --}}
        <div class="form-step" id="step-0">
            <h2 class="text-lg font-semibold mb-4 text-blue-700">
                Selecionar Categoria
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Categoria
                    </label>
                    <select id="categoria_inicial"
                            class="w-full border rounded-md px-3 py-2">
                        <option value="">Selecione</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->nome }}">
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button"
                        id="next-step"
                        class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Next →
                </button>
            </div>
        </div>

        {{-- ===============================
             ETAPA 1: CADASTRO DE SERVIÇOS
        ================================= --}}
        <div class="form-step hidden" id="step-1">

            <h2 class="text-lg font-semibold mb-4 text-blue-700">
                Serviços da Categoria:
                <span id="categoria-label" class="font-bold"></span>
            </h2>

            {{-- categoria enviada --}}
            <input type="hidden" name="categoria" id="categoria">

            <div id="servicos-container">
                <div class="servico-item grid grid-cols-1 md:grid-cols-2 gap-6 mb-4 border-b pb-4 relative">

                    <button type="button"
                        class="remove-item absolute -top-3 -right-3 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center">
                        &times;
                    </button>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nome do Serviço
                        </label>
                        <input type="text"
                               name="servicos[0][nome]"
                               class="w-full border rounded-md px-3 py-2"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Preço do Serviço
                        </label>
                        <input type="number"
                               name="servicos[0][preco]"
                               step="0.01"
                               class="w-full border rounded-md px-3 py-2"
                               required>
                    </div>

                </div>
            </div>

            <button type="button"
                    id="add-servico"
                    class="mb-6 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                <i class="fa-solid fa-plus mr-2"></i>
                Adicionar Serviço
            </button>

            <div class="flex justify-between">
                <button type="button"
                        id="back-step"
                        class="px-5 py-2 border rounded-md">
                    ← Voltar
                </button>

                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    Guardar Serviços
                </button>
            </div>
        </div>

    </form>
</div>

    {{-- MODAL DE ERRO --}}
    <div id="error-modal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold mb-3 text-red-600">
                Atenção
            </h3>

            <p id="error-message" class="text-gray-700 mb-5"></p>

            <div class="flex justify-end">
                <button id="close-error-modal"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Fechar
                </button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function () {

    let index = 1;

    function showStep(step) {
        $('.form-step').addClass('hidden');
        $('#step-' + step).removeClass('hidden');
    }

    function showError(message) {
        $('#error-message').text(message);
        $('#error-modal').removeClass('hidden').addClass('flex');
    }

    $('#close-error-modal').click(function () {
        $('#error-modal').addClass('hidden').removeClass('flex');
    });

    // NEXT
    $('#next-step').click(function () {
        const categoria = $('#categoria_inicial').val();

        if (!categoria) {
            showError('Selecione uma categoria para continuar.');
            return;
        }

        $('#categoria').val(categoria);
        $('#categoria-label').text(categoria);
        showStep(1);
    });

    // BACK
    $('#back-step').click(function () {
        showStep(0);
    });

    // Adicionar serviço
    $('#add-servico').click(function () {
        let clone = $('.servico-item:first').clone();

        clone.find('input').each(function () {
            $(this).val('');
            let name = $(this).attr('name').replace(/\d+/, index);
            $(this).attr('name', name);
        });

        $('#servicos-container').append(clone);
        index++;
    });

    // Remover serviço
    $(document).on('click', '.remove-item', function () {
        if ($('.servico-item').length > 1) {
            $(this).closest('.servico-item').remove();
        } else {
            showError('Deve existir pelo menos um serviço.');
        }
    });

});

</script>
@endsection
