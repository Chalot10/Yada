<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Servico
 * 
 * @property int $id
 * @property string $categoria
 * @property string $nomeService
 * @property float $precoServico
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Cotaco[] $cotacos
 *
 * @package App\Models
 */
class Servico extends Model
{
	protected $table = 'servicos';

	protected $casts = [
		'precoServico' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'categoria',
		'nomeService',
		'precoServico',
		'status'
	];

	public function cotacos()
	{
		return $this->hasMany(Cotaco::class, 'id_servico');
	}
}
