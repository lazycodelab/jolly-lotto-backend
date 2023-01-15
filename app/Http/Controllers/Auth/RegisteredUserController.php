<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password' => ['required'],
        ]);

		$response = Http::lotto()->post('/auth/register', [
			'firstName' => $request->firstName,
			'lastName' => $request->lastName,
			'email' => $request->email,
			'password' => $request->password,
			'confirmPassword' => $request->confirmPassword,
			'minimumLegalAge' => 18,
			'birthDate' => $request->birthDate,
			'billingAddress' => $request->billingAddress,
		]);

        //event(new Registered($user));

        //Auth::login($user);

		return $response;
        //return response()->noContent();
    }
}
