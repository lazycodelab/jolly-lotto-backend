<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use Illuminate\Http\Request;

class SyndicateController extends Controller
{
    public function bulkStore(int $id, bool $type, array $data)
	{
		Lottery::updateOrCreate(
			['product_id' => $id],
			[
				'syndicate_type' => $type ?? 0,
				'syndicate_data' => $data,
			]
		);
	}
}
