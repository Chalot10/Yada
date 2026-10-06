<?php

// /**
//  * Created by Reliese Model.
//  */

// namespace App\Models;

// use Carbon\Carbon;
// use Illuminate\Database\Eloquent\Collection;
// use Illuminate\Database\Eloquent\Model;

// /**
//  * Class Cotaco
//  * 
//  * @property int $id
//  * @property string $numero_cotacao
//  * @property Carbon $data_emissao
//  * @property Carbon $data_validade
//  * @property int $validade_dias
//  * @property float|null $quantidade
//  * @property float|null $preco_unitario
//  * @property int $status
//  * @property int $id_cliente
//  * @property int $id_servico
//  * @property int $id_user
//  * @property Carbon|null $created_at
//  * @property Carbon|null $updated_at
//  * 
//  * @property Cliente $cliente
//  * @property Servico $servico
//  * @property User $user
//  * @property Collection|ValoresCotacao[] $valores_cotacaos
//  *
//  * @package App\Models
//  */
// class Cotacao extends Model
// {
// 	protected $table = 'cotacoes';

// 	protected $casts = [
// 		'data_emissao' => 'datetime',
// 		'data_validade' => 'datetime',
// 		'validade_dias' => 'int',
// 		'quantidade' => 'float',
// 		'preco_unitario' => 'float',
// 		'status' => 'int',
// 		'id_cliente' => 'int',
// 		'id_servico' => 'int',
// 		'id_user' => 'int'
// 	];

// 	protected $fillable = [
// 		'numero_cotacao',
// 		'data_emissao',
// 		'data_validade',
// 		'validade_dias',
// 		'quantidade',
// 		'preco_unitario',
// 		'status',
// 		'id_cliente',
// 		'id_servico',
// 		'id_user'
// 	];

// 	public function cliente()
// 	{
// 		return $this->belongsTo(Cliente::class, 'id_cliente');
// 	}

// 	public function servico()
// 	{
// 		return $this->belongsTo(Servico::class, 'id_servico');
// 	}

// 	public function user()
// 	{
// 		return $this->belongsTo(User::class, 'id_user');
// 	}

// 	public function valores_cotacaos()
// 	{
// 		return $this->hasMany(ValoresCotacao::class, 'idCotacao');
// 	}
// }

// app/Models/Cotacao.php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    use HasFactory;

		protected $table = 'cotacoes';

    protected $fillable = [
        'numero_cotacao',
        'data_emissao',
        'data_validade',
        'validade_dias',
        'quantidade',
        'preco_unitario',
        'status',
        'id_cliente',
        'id_servico',
        'id_user'
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'data_validade' => 'date',
    ];

    // Relacionamento com cliente (singular)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relacionamento com serviço (singular - porque há apenas id_servico)
    public function servico()
    {
        return $this->belongsTo(Servico::class, 'id_servico');
    }

    // Relacionamento com usuário
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Não existe relacionamento servicos (plural)
    // Se precisa de múltiplos serviços, você precisa de uma tabela pivô

    // Acessor para status
    public function getStatusTextoAttribute()
    {
        $statuses = [
            0 => 'Pendente',
            1 => 'Aprovada',
            2 => 'Rejeitada',
            3 => 'Convertida em Fatura'
        ];
        
        return $statuses[$this->status] ?? 'Desconhecido';
    }

    // Acessor para valor total
    public function getValorTotalAttribute()
    {
        $quantidade = $this->quantidade ?? 1;
        $preco = $this->preco_unitario ?? 0;
        
        return $quantidade * $preco;
    }
}