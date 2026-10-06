<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ValoresCotacao
 * 
 * @property int $id
 * @property float $subtotal
 * @property float $iva_percent
 * @property float $iva_valor
 * @property float $desconto_global_percent
 * @property float $desconto_global_valor
 * @property float $subtotal_com_desconto
 * @property float $total
 * @property Carbon $prazo_pagamento
 * @property int $pago
 * @property int $idCotacao
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Cotaco $cotaco
 *
 * @package App\Models
 */
class ValoresCotacao extends Model
{
	protected $table = 'valores_cotacao';

	protected $casts = [
		'subtotal' => 'float',
		'iva_percent' => 'float',
		'iva_valor' => 'float',
		'desconto_global_percent' => 'float',
		'desconto_global_valor' => 'float',
		'subtotal_com_desconto' => 'float',
		'total' => 'float',
		'prazo_pagamento' => 'datetime',
		'pago' => 'int',
		'idCotacao' => 'int'
	];

	protected $fillable = [
		'subtotal',
		'iva_percent',
		'iva_valor',
		'desconto_global_percent',
		'desconto_global_valor',
		'subtotal_com_desconto',
		'total',
		'prazo_pagamento',
		'pago',
		'idCotacao'
	];

	public function cotaco()
	{
		return $this->belongsTo(Cotaco::class, 'idCotacao');
	}
}
