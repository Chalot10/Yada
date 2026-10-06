<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * 
 * @property int $id
 * @property string $nome
 * @property int $nuit
 * @property string $endereco
 * @property int $contacto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Cotaco[] $cotacos
 *
 * @package App\Models
 */
class Cliente extends Model
{
	protected $table = 'clientes';

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

	public function cotacos()
	{
		return $this->hasMany(Cotaco::class, 'id_cliente');
	}
}
