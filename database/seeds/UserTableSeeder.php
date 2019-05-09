<?php

use App\Model\Employee\Employee;
use App\Model\Setup\Branch;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		User::create([
			'uuid' => Str::uuid(),
			'name' => 'Tariqul Islam',
			'username' => 'tariqulislamrc',
			'email' => 'tariqulislamrc@gmail.com',
			'password' => Hash::make('Tariq1232'),
		]);
		Employee::create([
			'uuid' => Str::uuid(),
			'branch_id' => Branch::where('name', config('trt.main_branch'))->first()->id,
			'prefix' => Null,
			'user_id' => User::where('name', 'Tariqul Islam')->first()->id,
			'code' => 0,
			'name' => 'Tariqul Islam',
			'joining_date' => Carbon::now()->format('Y-m-d'),
			'date_of_birth' => '1992-11-25',
			'anniversary_date' => Null,
			'gender' => 'male',
			'marital_status' => 'single',
			'mobile_no' => '01718627564',
			'phone_no' => '01914217682',
			'email' => 'tariqulislamrc@gmail.com',
			'alternate_email' => 'test.tariq.web@gmail.com',
			'nationality_id' => Null,
			'blood_group_id' => Null,
			'religion_id' => Null,
			'category_id' => Null,
			'caste_id' => Null,
			'photo' => Null,
			'nid_no' => '19928111063000259',
			'birth_certificate_no' => Null,
			'father_name' => 'Md. Nazim Uddin',
			'mother_name' => 'Most. Sahera Begum',
			'spouse_name' => Null,
			'emergency_contact_name' => 'Minarul Islam',
			'emergency_contact' => '01737060351',
			'present_house' => 'Binodpur',
			'present_road' => 'Binodpur',
			'present_village' => 'Binodpur',
			'present_post' => 'Binodpur',
			'present_upozila' => 'Motihar',
			'present_district' => 'Rajshahi',
			'present_postcode' => '6210',
			'same_as_present' => 1,
			'permanent_house' => Null,
			'permanent_road' => Null,
			'permanent_village' => Null,
			'permanent_post' => Null,
			'permanent_upozila' => Null,
			'permanent_district' => Null,
			'permanent_postcode' => Null,
			'options' => [],
		]);
	}
}
