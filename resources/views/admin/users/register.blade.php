@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4 md:p-6">

    <!-- Cabeçalho -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-brand-secondary">
            Cadastro de Utilizador
        </h1>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-xl shadow-md p-6 md:p-8">

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf


                @if(session('success'))
                    <div class="alert alert-success">
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



            <!-- GRID 2 COLUNAS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nome -->
                <div>
                    <label class="block text-sm font-semibold text-brand-secondary mb-2">
                        Nome Completo
                    </label>
                    <input type="text" name="nome" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Cargo -->
                <div>
                    <label class="block text-sm font-semibold text-brand-secondary mb-2">
                        Cargo
                    </label>
                    <select name="cargo" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-brand-primary">
                        <option value="">-- Selecione --</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Operador">Operador</option>
                        <option value="Contabilista">Contabilista</option>
                    </select>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-brand-secondary mb-2">
                        Email
                    </label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Contacto -->
                <div>
                    <label class="block text-sm font-semibold text-brand-secondary mb-2">
                        Contacto
                    </label>
                    <input type="text" name="contacto" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Endereço -->
                <div>
                    <label class="block text-sm font-semibold text-brand-secondary mb-2">
                        Endereço
                    </label>
                    <input type="text" name="endereco"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Data de Nascimento -->
                <div>
                    <label class="block text-sm font-semibold text-brand-secondary mb-2">
                        Data de Nascimento
                    </label>
                    <input type="date" name="dataNasc" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-brand-secondary mb-2">
                        Palavra-passe
                    </label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-brand-primary">
                </div>

                <!-- Confirmar Password -->
                <div>
                    <label class="block text-sm font-semibold text-brand-secondary mb-2">
                        Confirmar Palavra-passe
                    </label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-brand-primary">
                </div>

            </div>

            <!-- Ações -->
            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ url('/home') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>

                <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-brand-primary text-white font-semibold">
                    Cadastrar Utilizador
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
