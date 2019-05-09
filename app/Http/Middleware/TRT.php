<?php

namespace App\Http\Middleware;

use App\Repositories\Setup\ConfigurationRepository;
use Closure;

class TRT {
	protected $config;

	public function __construct(
		ConfigurationRepository $config
	) {
		$this->config = $config;
	}

	/**
	 * Used to set default configuration
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null) {
		//$this->config->setDefault();

		return $next($request);
	}
}
