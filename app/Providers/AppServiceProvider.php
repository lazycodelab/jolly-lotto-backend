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
			if ($apiToken === null) {
				$tokenResponse = Http::withoutVerifying()->post('http://gateway.cloudandahalf.com/crow/api/auth/token',[
						'clientId' => env('API_KEY'),
						'clientSecurity' => env('API_SECRET'),
					]
				);
				$token = $tokenResponse->body();
				Cache::put('api_token', $token, now()->addMinutes(60));
			}

			return Http::withoutVerifying()
					->withOptions([
						'verify' => false,
						'connect_timeout' => 180, // Connection timeout of 2 seconds
						'timeout' => 180,         // Total timeout of 2 seconds (connect + read)
					])
					->baseUrl('http://gateway.cloudandahalf.com/crow/api')
					->withToken($apiToken);
		});
	}
}
