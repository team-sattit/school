<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//Setup Department Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-branch']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-branch']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-branch']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-branch']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-branch']);

		//Setup Department Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-employee_department']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-employee_department']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-employee_department']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-employee_department']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-employee_department']);

		//Setup Designation Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-employee_designation']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-employee_designation']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-employee_designation']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-employee_designation']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-employee_designation']);

		//Setup Employee Document Type Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-employee_document_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-employee_document_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-employee_document_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-employee_document_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-employee_document_type']);

		//Setup Employee Category Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-employee_category']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-employee_category']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-employee_category']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-employee_category']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-employee_category']);

		//Setup Employee Group Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-employee_group']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-employee_group']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-employee_group']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-employee_group']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-employee_group']);

		//Setup Employee Attendances Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-employee_attendance_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-employee_attendance_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-employee_attendance_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-employee_attendance_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-employee_attendance_type']);

		//Setup Employee Leave Type Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-employee_leave_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-employee_leave_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-employee_leave_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-employee_leave_type']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-employee_leave_type']);

		//Setup Employee Leave Type Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-employee_pay_head']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-employee_pay_head']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-employee_pay_head']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-employee_pay_head']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-employee_pay_head']);

		//Setup Bank Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-bank']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-bank']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-bank']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-bank']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-bank']);

		//Setup Nationality Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-nationality']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-nationality']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-nationality']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-nationality']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-nationality']);

		//Setup Religion Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-religion']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-religion']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-religion']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-religion']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-religion']);

		//Setup Blood Group Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-blood_group']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-blood_group']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-blood_group']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-blood_group']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-blood_group']);

		//Setup Caste Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-caste']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-caste']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-caste']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-caste']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-caste']);

		//Setup Nationality Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-category']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-category']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-category']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-category']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-category']);

		//Setup Nationality Permission
		Permission::create(['guard_name' => 'web', 'name' => 'view-employee']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-employee']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-employee']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-employee']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-employee']);

		//Setup Employee Category Permission
		Permission::create(['guard_name' => 'web', 'name' => 'access-all-employee']);
		Permission::create(['guard_name' => 'web', 'name' => 'access-subordinate-employee']);
		//Student academic session permission

		Permission::create(['guard_name' => 'web', 'name' => 'view-academic_session']);
		Permission::create(['guard_name' => 'web', 'name' => 'create-academic_session']);
		Permission::create(['guard_name' => 'web', 'name' => 'update-academic_session']);
		Permission::create(['guard_name' => 'web', 'name' => 'delete-academic_session']);
		Permission::create(['guard_name' => 'web', 'name' => 'change-status-academic_session']);

	}
}
