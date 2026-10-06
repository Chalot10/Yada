<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historico_cotacoes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cotacao');
            $table->date('data_emissao');
            $table->date('data_validade');
            $table->integer('validade_dias');
            $table->decimal('quantidade', 10, 2)->nullable();
            $table->decimal('preco_unitario', 10, 2)->nullable();
            $table->string('nome_servico');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_cliente')->references('id')->on('historico_clientes')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_cotacoes');
    }
};
