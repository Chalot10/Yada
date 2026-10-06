<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoricoCliente
 * 
 * @property int $id
 * @property string $nome
 * @property int $nuit
 * @property string $endereco
 * @property int $contacto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|HistoricoCotaco[] $historico_cotacos
 *
 * @package App\Models
 */
class HistoricoCliente extends Model
{
	protected $table = 'historico_clientes';

	protected $casts = [
		'nuit' => 'int',
		'contacto' => 'int'
	];

	protected $fillable = [
		'nome',
		'nuit',
		'endereco',
		'contacto'
	];

	public function historico_cotacos()
	{
		return $this->hasMany(HistoricoCotaco::class, 'id_cliente');
	}
}
