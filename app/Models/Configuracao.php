<?php
// app/Models/Configuracao.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';
    
    protected $fillable = [
        'chave',
        'valor'
    ];
    
    public static function getUltimoNumeroCotacao()
    {
        $config = self::where('chave', 'ultimo_numero_cotacao')->first();
        return $config ? intval($config->valor) : 0;
    }
    
    public static function incrementaNumeroCotacao()
    {
        $atual = self::getUltimoNumeroCotacao();
        $novo = $atual + 1;
        
        self::updateOrCreate(
            ['chave' => 'ultimo_numero_cotacao'],
            ['valor' => $novo]
        );
        
        return $novo;
    }
}