<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Role::create(['name' => config('trt.default_role.admin'), 'guard_name' => 'web']);
		Role::create(['name' => config('trt.default_role.manager'), 'guard_name' => 'web']);
		Role::create(['name' => config('trt.default_role.principal'), 'guard_name' => 'web']);
		Role::create(['name' => config('trt.default_role.student'), 'guard_name' => 'web']);
		Role::create(['name' => config('trt.default_role.parent'), 'guard_name' => 'web']);
		Role::create(['name' => config('trt.default_role.staff'), 'guard_name' => 'web']);
		Role::create(['name' => config('trt.default_role.librarian'), 'guard_name' => 'web']);
		Role::create(['name' => config('trt.default_role.accountant'), 'guard_name' => 'web']);

		$role = Role::where('name', config('trt.default_role.admin'))->first();
		$role->givePermissionTo(Permission::all());

		$role = Role::where('name', config('trt.default_role.principal'))->first();
		$role->givePermissionTo(['view-employee', 'create-employee', 'update-employee', 'delete-employee', 'change-status-employee']);
		$user = User::where('email', 'tariqulislamrc@gmail.com')->first();
		$user->assignRole(config('trt.default_role.admin'));
		$user = User::where('name', config('trt.main_branch'))->first();
		$user->assignRole(config('trt.default_role.principal'));
	}
}
