<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Http::macro('lotto', function () {
			return Http::withOptions([
				'verify' => false,
			])
			->baseUrl('https://gateway.cloudandahalf.com/crow/api');
		});
	}
}
