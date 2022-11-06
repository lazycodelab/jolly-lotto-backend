<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
	use HasFactory;

	protected $guarded = [];
	protected $casts = [
		'cut_offs' => 'array',
		'draw_dates' => 'array',
		'balls' => 'array',
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}


	public function results()
	{
		return $this->hasMany(Result::class);
	}
}
