<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		$this->call(ConfigurationSeeder::class);
		$this->call(SystemSeeder::class);
		$this->call(UserTableSeeder::class);
		$this->call(PermissionTableSeeder::class);
		$this->call(RoleTableSeeder::class);
	}
}
