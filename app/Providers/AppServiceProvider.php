<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
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
			$apiToken = Cache::get('api_token');

			if (null === $apiToken) {
				$token = Http::withoutVerifying()
							->withOptions(
								[
									'verify' => false,
								]
							)->post(
								'http://gateway.cloudandahalf.com/crow/api/auth/token',
								[
									'clientId' => env('API_KEY'),
									'clientSecurity' => env('API_SECRET'),
								]
							);

				// store cache for a day.
				// @todo: maybe fix this logic.
				Cache::put('api_token', $token->body(), now()->addMinutes(1440));
				$apiToken = $token->body();
			}

			return Http::withoutVerifying()
					->withOptions([
						'verify' => false,
					])
					->baseUrl('http://gateway.cloudandahalf.com/crow/api')
					->withToken($apiToken);
		});
	}
}
