<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

	protected $guarded = [];
	protected $casts = [
		'breakdowns' => 'array',
	];


	public function lottery()
	{
		return $this->belongsTo(Lottery::class);
	}
}
