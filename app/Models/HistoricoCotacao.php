<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoricoCotaco
 * 
 * @property int $id
 * @property string $numero_cotacao
 * @property Carbon $data_emissao
 * @property Carbon $data_validade
 * @property int $validade_dias
 * @property float|null $quantidade
 * @property float|null $preco_unitario
 * @property string $nome_servico
 * @property int $id_cliente
 * @property int $id_user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property HistoricoCliente $historico_cliente
 * @property User $user
 * @property Collection|HistoricoValoresCotaco[] $historico_valores_cotacos
 *
 * @package App\Models
 */
class HistoricoCotacao extends Model
{
	protected $table = 'historico_cotacoes';

	protected $casts = [
		'data_emissao' => 'datetime',
		'data_validade' => 'datetime',
		'validade_dias' => 'int',
		'quantidade' => 'float',
		'preco_unitario' => 'float',
		'id_cliente' => 'int',
		'id_user' => 'int'
	];

	protected $fillable = [
		'numero_cotacao',
		'data_emissao',
		'data_validade',
		'validade_dias',
		'quantidade',
		'preco_unitario',
		'nome_servico',
		'id_cliente',
		'id_user'
	];

	public function historico_cliente()
	{
		return $this->belongsTo(HistoricoCliente::class, 'id_cliente');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_user');
	}

	public function historico_valores_cotacos()
	{
		return $this->hasMany(HistoricoValoresCotaco::class, 'idHistCotacao');
	}
}
