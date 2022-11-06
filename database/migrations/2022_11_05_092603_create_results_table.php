<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('results', function (Blueprint $table) {
			$table->id();
			$table->foreignId('lottery_id');
			$table->dateTime('draw_date');
			$table->string('jackpot');
			$table->integer('winners');
			$table->string('board');
			$table->json('breakdowns');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('results');
	}
};
