@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6">

    <!-- Cabeçalho -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-brand-secondary">Utilizadores</h1>
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


        <a href="{{ route('admin.users.create') }}"
           class="px-4 py-2 rounded-lg bg-brand-primary text-white font-semibold hover:bg-brand-primary/90 transition">
            + Novo Utilizador
        </a>
    </div>

    <!-- Tabela -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Nome</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Contacto</th>
                    <th class="px-4 py-3 text-left">Cargo</th>
                    <th class="px-4 py-3 text-center">Ações</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $user->nome }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">{{ $user->contacto }}</td>
                    <td class="px-4 py-3">{{ $user->cargo }}</td>

                    <td class="px-4 py-3 text-center space-x-2">
                        <!-- Editar -->
                        <button onclick="document.getElementById('editModal{{ $user->id }}').classList.remove('hidden')"
                            class="px-3 py-1.5 rounded bg-blue-600 text-white text-xs hover:bg-blue-700 transition">
                            Editar
                        </button>

                        <!-- Remover -->
                        <button onclick="document.getElementById('deleteModal{{ $user->id }}').classList.remove('hidden')"
                            class="px-3 py-1.5 rounded bg-red-600 text-white text-xs hover:bg-red-700 transition">
                            Remover
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- MODAIS PARA CADA USUÁRIO -->
    @foreach($users as $user)
    <!-- MODAL REMOVER - {{ $user->id }} -->
    <div id="deleteModal{{ $user->id }}" 
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-bold text-gray-800 mb-3">
                Confirmar Remoção
            </h2>

            <p class="text-gray-600 mb-6">
                Tem certeza que deseja remover o utilizador
                <strong>{{ $user->nome }}</strong>?
            </p>

            <div class="flex justify-end gap-3">
                <button onclick="document.getElementById('deleteModal{{ $user->id }}').classList.add('hidden')"
                    type="button"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </button>

                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Remover
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR - {{ $user->id }} -->
    <div id="editModal{{ $user->id }}" 
         class="hidden fixed inset-0 z-50 flex items-start justify-center p-4 bg-black/50 overflow-y-auto">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl my-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Editar Utilizador</h2>

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nome</label>
                        <input type="text" name="nome" value="{{ $user->nome }}"
                               class="w-full rounded border-gray-300 focus:border-brand-primary focus:ring focus:ring-brand-primary/20 px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Cargo</label>
                        <select name="cargo"
                                class="w-full rounded border-gray-300 focus:border-brand-primary focus:ring focus:ring-brand-primary/20 px-3 py-2">
                            <option value="">Selecione um cargo</option>
                            <option value="Administrador" {{ $user->cargo == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="Operador" {{ $user->cargo == 'Operador' ? 'selected' : '' }}>Operador</option>
                            <option value="Contabilista" {{ $user->cargo == 'Contabilista' ? 'selected' : '' }}>Contabilista</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}"
                               class="w-full rounded border-gray-300 focus:border-brand-primary focus:ring focus:ring-brand-primary/20 px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Contacto</label>
                        <input type="text" name="contacto" value="{{ $user->contacto }}"
                               class="w-full rounded border-gray-300 focus:border-brand-primary focus:ring focus:ring-brand-primary/20 px-3 py-2">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-1">Endereço</label>
                        <input type="text" name="endereco" value="{{ $user->endereco ?? '' }}"
                               class="w-full rounded border-gray-300 focus:border-brand-primary focus:ring focus:ring-brand-primary/20 px-3 py-2">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" 
                            onclick="document.getElementById('editModal{{ $user->id }}').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="px-5 py-2 bg-brand-primary text-white rounded-lg hover:bg-brand-primary/90 transition">
                        Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

</div>

<script>
// Fechar modal ao clicar fora
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar event listener para todos os modais
    document.querySelectorAll('[id^="deleteModal"], [id^="editModal"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    });

    // Fechar modal com tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="deleteModal"]:not(.hidden), [id^="editModal"]:not(.hidden)').forEach(modal => {
                modal.classList.add('hidden');
            });
        }
    });
});

// Função helper para fechar qualquer modal
function closeAllModals() {
    document.querySelectorAll('[id^="deleteModal"], [id^="editModal"]').forEach(modal => {
        modal.classList.add('hidden');
    });
}
</script>

<style>
    /* Adicionar transições suaves */
    [id^="deleteModal"], [id^="editModal"] {
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    
    [id^="deleteModal"]:not(.hidden), [id^="editModal"]:not(.hidden) {
        opacity: 1;
        pointer-events: all;
    }
    
    [id^="deleteModal"] > div, [id^="editModal"] > div {
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    
    [id^="deleteModal"]:not(.hidden) > div, [id^="editModal"]:not(.hidden) > div {
        transform: scale(1);
    }
</style>
@endsection