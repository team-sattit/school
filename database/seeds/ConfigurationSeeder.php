<?php

use App\Model\Setup\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Configuration::create(['name' => 'main_branch', 'numeric_value' => Null, 'text_value' => 'TRT School Main Branch']);
		Configuration::create(['name' => 'system_admin_category_name', 'numeric_value' => Null, 'text_value' => 'System Admin']);
		Configuration::create(['name' => 'system_admin_designation', 'numeric_value' => Null, 'text_value' => 'System Admin']);
		Configuration::create(['name' => 'site_name', 'numeric_value' => Null, 'text_value' => 'School Managment']);
		Configuration::create(['name' => 'brance_option', 'numeric_value' => 1, 'text_value' => Null]);
		Configuration::create(['name' => 'parent_login', 'numeric_value' => 1, 'text_value' => Null]);
		Configuration::create(['name' => 'student_login', 'numeric_value' => 1, 'text_value' => Null]);
		Configuration::create(['name' => 'time_zone', 'numeric_value' => Null, 'text_value' => 'Asia/Dhaka']);
		Configuration::create(['name' => 'settings_controll', 'numeric_value' => 1, 'text_value' => Null]);
		Configuration::create(['name' => 'admin_prefix', 'numeric_value' => Null, 'text_value' => '/admin']);

		Configuration::create(['name' => 'default_role.admin', 'numeric_value' => Null, 'text_value' => 'super_admin']);
		Configuration::create(['name' => 'default_role.manager', 'numeric_value' => Null, 'text_value' => 'manager']);
		Configuration::create(['name' => 'default_role.principal', 'numeric_value' => Null, 'text_value' => 'principal']);
		Configuration::create(['name' => 'default_role.student', 'numeric_value' => Null, 'text_value' => 'student']);
		Configuration::create(['name' => 'default_role.parent', 'numeric_value' => Null, 'text_value' => 'parent']);
		Configuration::create(['name' => 'default_role.staff', 'numeric_value' => Null, 'text_value' => 'staff']);
		Configuration::create(['name' => 'default_role.librarian', 'numeric_value' => Null, 'text_value' => 'librarian']);
		Configuration::create(['name' => 'default_role.accountant', 'numeric_value' => Null, 'text_value' => 'accountant']);

		Configuration::create(['name' => 'employee_code_prefix', 'numeric_value' => Null, 'text_value' => Null]);
		Configuration::create(['name' => 'employee_code_digit', 'numeric_value' => 3, 'text_value' => Null]);
	}
}
