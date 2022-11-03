<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

	protected $guarded = [];
	protected $with = ['lottery'];

	public function prices()
	{
		return $this->hasMany(Price::class);
	}

	/**
	 * Undocumented function
	 */
	public function lottery()
	{
		return $this->hasOne(Lottery::class);
	}
}
