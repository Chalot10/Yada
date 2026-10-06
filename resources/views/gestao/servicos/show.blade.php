@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6">

    <!-- Cabeçalho -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-brand-secondary">Serviços da Empresa</h1>
        </div>


                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $erro)
                                <li>{{ $erro }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


        <a href="{{ route('gestao.servicos.add') }}"
           class="px-4 py-2 rounded-lg bg-brand-primary text-white font-semibold hover:bg-brand-secondary transition">
            + Novo Serviço
        </a>
    </div>

    <!-- Tabela -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-light text-brand-secondary">
                <tr>
                    <th class="px-4 py-3 text-left">Serviço</th>
                    <th class="px-4 py-3 text-left">Categoria</th>
                    <th class="px-4 py-3 text-left">Preço</th>
                    <th class="px-4 py-3 text-center">Acções</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($servicos as $servico)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $servico->nomeService }}</td>
                    <td class="px-4 py-3 capitalize">{{ $servico->categoria }}</td>
                    <td class="px-4 py-3">
                        {{ number_format($servico->precoServico, 2, ',', '.') }} MT
                    </td>

                    <td class="px-4 py-3 text-center space-x-2">
                        <button
                            onclick="document.getElementById('editModal{{ $servico->id }}').classList.remove('hidden')"
                            class="px-3 py-1.5 rounded bg-brand-primary text-white text-xs hover:bg-brand-secondary">
                            Editar
                        </button>

                        <button
                            onclick="document.getElementById('deleteModal{{ $servico->id }}').classList.remove('hidden')"
                            class="px-3 py-1.5 rounded bg-red-600 text-white text-xs hover:bg-red-700">
                            Remover
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                        Nenhum serviço cadastrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAIS -->
    @foreach($servicos as $servico)

    <!-- MODAL REMOVER -->
    <div id="deleteModal{{ $servico->id }}"
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-bold text-brand-secondary mb-3">
                Confirmar Remoção
            </h2>

            <p class="text-gray-600 mb-6">
                Deseja remover o serviço
                <strong>{{ $servico->nomeService }}</strong>?
            </p>

            <div class="flex justify-end gap-3">
                <button
                    onclick="document.getElementById('deleteModal{{ $servico->id }}').classList.add('hidden')"
                    class="px-4 py-2 border rounded-lg">
                    Cancelar
                </button>

                <form method="POST" action="{{ route('gestao.servicos.destroy', $servico->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Remover
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div id="editModal{{ $servico->id }}"
         class="hidden fixed inset-0 z-50 flex items-start justify-center p-4 bg-black/50 overflow-y-auto">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg my-8">
            <h2 class="text-lg font-bold text-brand-secondary mb-4">
                Editar Serviço
            </h2>

            <form method="POST" action="{{ route('gestao.servicos.update', $servico->id) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nome</label>
                        <input type="text" name="nome" value="{{ $servico->nomeService }}"
                               class="w-full rounded border-gray-300 px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Categoria</label>
                        <input type="text" name="categoria" value="{{ $servico->categoria }}"
                               class="w-full rounded border-gray-300 px-3 py-2">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-1">Preço</label>
                        <input type="number" step="0.01" name="preco"
                               value="{{ $servico->precoServico }}"
                               class="w-full rounded border-gray-300 px-3 py-2">
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t pt-4">
                    <button type="button"
                        onclick="document.getElementById('editModal{{ $servico->id }}').classList.add('hidden')"
                        class="px-4 py-2 border rounded-lg">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="px-5 py-2 bg-brand-primary text-white rounded-lg hover:bg-brand-secondary">
                        Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @endforeach

</div>
@endsection
