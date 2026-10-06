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
        Schema::create('valores_cotacao', function (Blueprint $table) {
            $table->id();
            $table->float('subtotal');
            $table->float('iva_percent');
            $table->float('iva_valor');
            $table->float('desconto_global_percent');
            $table->float('desconto_global_valor');
            $table->float('subtotal_com_desconto');
            $table->float('total');
            $table->date('prazo_pagamento');
            $table->integer('pago');
            $table->unsignedBigInteger('idCotacao');
            $table->foreign('idCotacao')->references('id')->on('cotacoes')->onDelete('cascade');          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valores_cotacao');
    }
};
