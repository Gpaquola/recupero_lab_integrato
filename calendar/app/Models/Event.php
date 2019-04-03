<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 31 Mar 2019 20:39:59 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Event
 * 
 * @property int $id
 * @property string $name
 * @property string $note
 * @property int $priority
 * @property \Carbon\Carbon $begin
 * @property \Carbon\Carbon $end
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Event extends Eloquent
{
	protected $casts = [
		'priority' => 'int'
	];

	protected $dates = [
		'begin',
		'end'
	];

	protected $fillable = [
		'name',
		'note',
		'priority',
		'begin',
		'end'
	];
}
