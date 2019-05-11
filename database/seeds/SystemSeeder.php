<?php

use App\Model\Setup\Branch;
use App\Model\Setup\Employee\Department;
use App\Model\Setup\Employee\Designation;
use App\Model\Setup\Employee\EmployeeCategory;
use App\Model\Setup\Employee\EmployeeDocumentType;
use App\Model\Setup\Finance\Bank;
use App\Model\Setup\Misc\BloodGroup;
use App\Model\Setup\Misc\Caste;
use App\Model\Setup\Misc\Category;
use App\Model\Setup\Misc\Nationality;
use App\Model\Setup\Misc\Religion;
use App\Model\Setup\Student\AcademicSession;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SystemSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		EmployeeCategory::create([
			'name' => config('trt.system_admin_category_name'),
			'description' => config('trt.system_admin_category_name'),
		]);
		EmployeeCategory::create([
			'name' => 'Bcs Cadre',
		]);

		$employee_category = EmployeeCategory::where('name', config('trt.system_admin_category_name'))->first();

		Designation::create([
			'employee_category_id' => $employee_category->id,
			'name' => config('trt.system_admin_designation'),
			'description' => config('trt.system_admin_designation'),
		]);

		$uuid = Str::uuid();
		User::create([
			'uuid' => $uuid,
			'name' => config('trt.main_branch'),
			'email' => 'main_branch@school.com',
			'username' => 'main_branch',
			'password' => Hash::make('Tariq1232'),
		]);
		Branch::create([
			'uuid' => $uuid,
			'user_id' => User::where('name', config('trt.main_branch'))->first()->id,
			'branch_no' => 'Bra-001',
			'name' => config('trt.main_branch'),
			'email' => 'main_branch@school.com',
			'username' => 'main_branch',
			'address' => 'Rajshahi, Bangladesh',
			'mobile_no' => '01718627564',
		]);

		Designation::create(['employee_category_id' => 2, 'name' => 'Professor']);
		Department::create(['name' => 'Physics', 'code' => '2701']);
		Nationality::create(['name' => 'Bangladeshi']);
		BloodGroup::create(['name' => 'A(-Ve)']);
		Religion::create(['name' => 'Islam']);
		Caste::create(['name' => 'Sunni']);
		Category::create(['name' => 'Employee Category']);
		EmployeeDocumentType::create(['name' => 'Document 01']);
		Bank::create(['name' => 'Sonali Bank']);
		AcademicSession::create(['name' => '2019-20','start_date'=>'2019-01-01','end_date'=>'2019-05-05']);

	}
}
