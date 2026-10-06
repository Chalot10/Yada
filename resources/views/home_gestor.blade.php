@extends('layouts.appG')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">


    @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

 
    <!-- Cards resumo com números -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Cotações -->
        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-file-signature text-blue-600 text-2xl mr-3"></i>
                    <h2 class="text-xl font-semibold">Cotações</h2>
                </div>
                <span class="text-2xl font-bold text-gray-800">25</span>
            </div>
            <p class="text-gray-600 text-sm">Cotações criadas este mês</p>
        </div>

        <!-- Faturação -->
        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-file-invoice-dollar text-green-600 text-2xl mr-3"></i>
                    <h2 class="text-xl font-semibold">Faturas</h2>
                </div>
                <span class="text-2xl font-bold text-gray-800">18</span>
            </div>
            <p class="text-gray-600 text-sm">Faturas emitidas este mês</p>
        </div>

        <!-- Clientes -->
        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-users text-yellow-600 text-2xl mr-3"></i>
                    <h2 class="text-xl font-semibold">Clientes</h2>
                </div>
                <span class="text-2xl font-bold text-gray-800">12</span>
            </div>
            <p class="text-gray-600 text-sm">Novos clientes este mês</p>
        </div>
    </div>

    <!-- Cards adicionais -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Produtos/Serviços -->
        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-boxes-stacked text-purple-600 text-2xl mr-3"></i>
                    <h2 class="text-xl font-semibold">Produtos/Serviços</h2>
                </div>
                <span class="text-2xl font-bold text-gray-800">34</span>
            </div>
            <p class="text-gray-600 text-sm">Produtos/Serviços cadastrados</p>
        </div>

        <!-- Relatórios -->
        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-chart-column text-red-600 text-2xl mr-3"></i>
                    <h2 class="text-xl font-semibold">Relatórios</h2>
                </div>
                <span class="text-2xl font-bold text-gray-800">5</span>
            </div>
            <p class="text-gray-600 text-sm">Relatórios gerados este mês</p>
        </div>
    </div>

    <!-- Acções Rápidas -->
    
            <div class="mt-6 md:mt-8">
                <div class="bg-gradient-to-r from-[#03588C] to-[#024059] rounded-xl p-4 md:p-6 text-white">
                    <h2 class="text-lg md:text-xl font-bold mb-4">Acções Rápidas</h2>
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-3 md:gap-4">
                        <a href="#" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg p-4 transition-all duration-300 hover:scale-105 active:scale-95 flex flex-col items-center justify-center text-center">
                            <i class="fas fa-file-signature text-xl mb-2"></i>
                            <span class="text-sm font-medium">Nova Cotação</span>
                        </a>
                        <a href="#" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg p-4 transition-all duration-300 hover:scale-105 active:scale-95 flex flex-col items-center justify-center text-center">
                            <i class="fas fa-file-invoice-dollar text-xl mb-2"></i>
                            <span class="text-sm font-medium">Nova Factura</span>
                        </a>
                        <a href="#" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg p-4 transition-all duration-300 hover:scale-105 active:scale-95 flex flex-col items-center justify-center text-center">
                            <i class="fas fa-user-plus text-xl mb-2"></i>
                            <span class="text-sm font-medium">Novo Cliente</span>
                        </a>
                        <a href="#" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg p-4 transition-all duration-300 hover:scale-105 active:scale-95 flex flex-col items-center justify-center text-center">
                            <i class="fas fa-chart-line text-xl mb-2"></i>
                            <span class="text-sm font-medium">Relatórios</span>
                        </a>
                    </div>
                </div>
            </div>


@endsection
