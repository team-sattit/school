<?php

namespace App\Providers;

use App\Model\Setup\Configuration;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Schema::defaultStringLength(191);
		if (config('trt.settings_controll')) {
			if (Schema::hasTable('config')) {
				foreach (Configuration::all() as $setting) {
					$value = '';
					if ($setting->numeric_value) {
						$value = $setting->numeric_value;
					} else {
						$value = $setting->text_value;
					}
					Config::set('trt.' . $setting->name, $value);
				}
			}
		}
		if (config('trt.time_zone')) {
			date_default_timezone_set(config('trt.time_zone'));
		}
		Activity::saving(function (Activity $activity) {
			$activity->properties = $activity->properties->put('ip', getClientIp());
			$activity->properties = $activity->properties->put('user_agent', \Request::header('User-Agent'));
		});
	}
}
