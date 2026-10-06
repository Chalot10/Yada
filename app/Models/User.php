<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $password
 * @property string $contacto
 * @property string $dataNas
 * @property string $salt
 * @property string $joined
 * @property string $groups
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Cotaco[] $cotacos
 * @property Collection|HistoricoCotacao[] $historico_cotacaos
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'nome',
		'email',
		'password',
		'contacto',
		'dataNas',
		'salt',
		'joined',
		'groups',
		'email_verified_at',
		'remember_token'
	];

	public function cotacoes()
	{
		return $this->hasMany(Cotacao::class, 'id_user');
	}

	public function historico_cotacoes()
	{
		return $this->hasMany(HistoricoCotacao::class, 'id_user');
	}
}
