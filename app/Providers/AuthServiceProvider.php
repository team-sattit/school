<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model\Setup\Branch' => 'App\Policies\Setup\BranchPolicy',
		'App\Model\Setup\Employee\Department' => 'App\Policies\Setup\Employee\DepartmentPolicy',
		'App\Model\Setup\Employee\Designation' => 'App\Policies\Setup\Employee\DesignationPolicy',
		'App\Model\Setup\Employee\EmployeeDocumentType' => 'App\Policies\Setup\Employee\EmployeeDocumentTypePolicy',
		'App\Model\Setup\Employee\EmployeeCategory' => 'App\Policies\Setup\Employee\EmployeeCategoryPolicy',
		'App\Model\Setup\Employee\LeaveType' => 'App\Policies\Setup\Employee\LeaveTypePolicy',
		'App\Model\Setup\Employee\AttendanceType' => 'App\Policies\Setup\Employee\AttendanceTypePolicy',
		'App\Model\Setup\Employee\PayHead' => 'App\Policies\Setup\Employee\PayHeadPolicy',
		'App\Model\Setup\Employee\EmployeeGroup' => 'App\Policies\Setup\Employee\EmployeeGroupPolicy',
		'App\Model\Setup\Misc\Nationality' => 'App\Policies\Setup\Misc\NationalityPolicy',
		'App\Model\Setup\Misc\Religion' => 'App\Policies\Setup\Misc\ReligionPolicy',
		'App\Model\Setup\Misc\Caste' => 'App\Policies\Setup\Misc\CastePolicy',
		'App\Model\Setup\Misc\BloodGroup' => 'App\Policies\Setup\Misc\BloodGroupPolicy',
		'App\Model\Setup\Misc\Category' => 'App\Policies\Setup\Misc\CategoryPolicy',

		'App\Model\Setup\Finance\Bank' => 'App\Policies\Setup\Finance\BankPolicy',

		'App\Model\Employee\Employee' => 'App\Policies\Employee\EmployeePolicy',
		'App\Model\Setup\Student\AcademicSession' => 'App\Policies\Setup\Student\AcademicSessionPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();

		// Implicitly grant "Admin" role all permissions
		// This works in the app by using gate-related functions like auth()->user->can() and @can()
		// Gate::before(function ($user, $ability) {
		// 	if ($user->hasRole('super_admin')) {
		// 		return true;
		// 	}
		// });
	}
}
