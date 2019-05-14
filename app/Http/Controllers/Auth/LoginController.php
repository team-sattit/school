<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller {
	/*
		    |--------------------------------------------------------------------------
		    | Login Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller handles authenticating users for the application and
		    | redirecting them to your home screen. The controller uses a trait
		    | to conveniently provide its functionality to your applications.
		    |
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/dashboard';

	/**
	 * Validate the user login request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	protected function validateLogin(Request $request) {
		$request->validate([
			'email_or_username' => 'required|string',
			'password' => 'required|string',
		]);
	}

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	protected function credentials(Request $request) {
		$email_or_username = $request->email_or_username;
		$model = User::where('username', $email_or_username)->first();

		if (!$model) {
			$model = User::where('email', $email_or_username)->first();
		}
		if ($model != null) {
			if ($model->status != 1) {
				return ['email' => 'inactive', 'password' => 'suspend'];
			} else {
				return ['email' => $model->email, 'password' => $request->password, 'status' => 1];
			}
		} else {
			return ['email' => $request->email_or_username, 'password' => $request->password, 'status' => 0];
		}
	}

	/**
	 * Get the failed login response instance.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	protected function sendFailedLoginResponse(Request $request) {
		$fields = $this->credentials($request);
		if ($fields['email'] == 'inactive' && $fields['password'] == 'suspend') {
			throw ValidationException::withMessages([
				$this->username() => [trans('auth.suspend')],
			]);
		} else {
			throw ValidationException::withMessages([
				$this->username() => [trans('auth.failed')],
			]);
		}
	}

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest')->except('logout');
	}
}
