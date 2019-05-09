<?php

namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
	protected $fillable = [
		'uuid',
		'branch_id',
		'prefix',
		'user_id',
		'code',
		'name',
		'joining_date',
		'date_of_birth',
		'anniversary_date',
		'gender',
		'marital_status',
		'mobile_no',
		'phone_no',
		'email',
		'alternate_email',
		'nationality_id',
		'blood_group_id',
		'religion_id',
		'category_id',
		'caste_id',
		'photo',
		'nid_no',
		'birth_certificate_no',
		'father_name',
		'mother_name',
		'spouse_name',
		'emergency_contact_name',
		'emergency_contact',
		'present_house',
		'present_road',
		'present_village',
		'present_post',
		'present_upozila',
		'present_district',
		'present_postcode',
		'same_as_present',
		'permanent_house',
		'permanent_road',
		'permanent_village',
		'permanent_post',
		'permanent_upozila',
		'permanent_district',
		'permanent_postcode',
		'height',
		'weight',
		'mark',
		'options',
	];
	protected $casts = ['options' => 'array'];
	protected $dates = ['date_of_birth', 'joining_date'];
	protected $primaryKey = 'id';
	protected $table = 'employees';
	protected static $logName = 'student';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function employeeGroups() {
		return $this->belongsToMany('App\Model\Setup\Employee\EmployeeGroup', 'employee_group_collection', 'employee_id', 'employee_group_id');
	}

	public function bloodGroup() {
		return $this->belongsTo('App\Model\Setup\Misc\BloodGroup');
	}

	public function religion() {
		return $this->belongsTo('App\Model\Setup\Misc\Religion');
	}

	public function category() {
		return $this->belongsTo('App\Model\Setup\Misc\Category');
	}

	public function nationality() {
		return $this->belongsTo('App\Model\Setup\Misc\Nationality');
	}

	public function branch() {
		return $this->belongsTo('App\Model\Setup\Branch');
	}

	public function caste() {
		return $this->belongsTo('App\Model\Setup\Misc\Caste');
	}

	public function employeeTerms() {
		return $this->hasMany('App\Model\Employee\EmployeeTerm');
	}

	public function employeeDesignations() {
		return $this->hasMany('App\Model\Employee\EmployeeDesignation');
	}

	public function employeeSalaries() {
		return $this->hasMany('App\Model\Employee\EmployeeSalary');
	}

	public function EmployeeQualifications() {
		return $this->hasMany('App\Model\Employee\EmployeeQualification');
	}

	public function EmployeeAccounts() {
		return $this->hasMany('App\Model\Employee\EmployeeAccount');
	}

	public function EmployeeDocuments() {
		return $this->hasMany('App\Model\Employee\EmployeeDocument');
	}

	// public function classTeachers() {
	// 	return $this->hasMany('App\Model\Academic\ClassTeacher');
	// }

	// public function transactions() {
	// 	return $this->hasMany('App\Model\Finance\Transaction\Transaction');
	// }

	public function getOption(string $option) {
		return array_get($this->options, $option);
	}

	public function getEmployeeCodeAttribute() {
		return $this->prefix . str_pad($this->code, config('trt.employee_code_digit'), '0', STR_PAD_LEFT);
	}

	// public function getEmployeePresentAddressAttribute() {
	// 	return 'House: ' . $this->present_house . ', Road: ' . $this->present_road . ', <br>Village: ' . $this->present_village . ', Post: ' . $this->present_post . ',<br>Upozila: ' . $this->present_upozila . ', District: ' . $this->present_district . '- ' . $this->present_postcode;
	// }

	public function getNameWithCodeAttribute() {
		return $this->name . ' (' . $this->employee_code . ')';
	}

	public function scopeInfo($q) {
		return $q->with(['branch', 'caste:id,name', 'nationality:id,name', 'category:id,name', 'religion:id,name', 'bloodGroup:id,name', 'employeeTerms' => function ($q1) {
			$q1->where('joining_date', '<=', date('Y-m-d'))->orderBy('joining_date', 'desc');
		}, 'employeeDesignations' => function ($q2) {
			$q2->where('date_effective', '<=', date('Y-m-d'))->orderBy('date_effective', 'desc');
		}, 'employeeDesignations.department', 'employeeDesignations.designation', 'employeeDesignations.designation.employeeCategory', 'user', 'user.roles', 'employeeSalaries' => function ($q3) {
			$q3->orderBy('id', 'desc');
		}, 'EmployeeQualifications', 'EmployeeAccounts', 'EmployeeAccounts.bank', 'EmployeeDocuments', 'EmployeeDocuments.employeeDocumentType']);
	}

	public function scopeSummary($q) {
		return $q->select('id', 'code', 'prefix', 'first_name', 'middle_name', 'last_name')->with([
			'employeeDesignations:id,employee_id,designation_id,department_id,date_effective,date_end',
			'employeeDesignations.designation:id,name,employee_category_id',
			'employeeDesignations.designation.employeeCategory:id,name',
			'employeeDesignations.department:id,name',
		]);
	}

	public function scopeFilterById($q, $id) {
		if (!$id) {
			return $q;
		}

		return $q->where('id', '=', $id);
	}

	public function scopeFilterByUuid($q, $uuid) {
		if (!$uuid) {
			return $q;
		}

		return $q->where('uuid', '=', $uuid);
	}

	public function scopeFilterByCode($q, $code) {
		if (!$code) {
			return $q;
		}

		return $q->where('code', '=', $code);
	}

	public function scopeFilterByPrefix($q, $prefix) {
		if (!$prefix) {
			return $q;
		}

		return $q->where('prefix', '=', $prefix);
	}

	public function scopeFilterByFirstName($q, $first_name, $strict = 0) {
		if (!$first_name) {
			return $q;
		}

		return ($strict) ? $q->where('first_name', '=', $first_name) : $q->where('first_name', 'like', '%' . $first_name . '%');
	}

	public function scopeFilterByMiddleName($q, $middle_name, $strict = 0) {
		if (!$middle_name) {
			return $q;
		}

		return ($strict) ? $q->where('middle_name', '=', $middle_name) : $q->where('middle_name', 'like', '%' . $middle_name . '%');
	}

	public function scopeFilterByLastName($q, $last_name, $strict = 0) {
		if (!$last_name) {
			return $q;
		}

		return ($strict) ? $q->where('last_name', '=', $last_name) : $q->where('last_name', 'like', '%' . $last_name . '%');
	}

	public function scopeFilterByFatherName($q, $father_name, $strict = 0) {
		if (!$father_name) {
			return $q;
		}
		return ($strict) ? $q->where('father_name', '=', $father_name) : $q->where('father_name', 'like', '%' . $father_name . '%');
	}

	public function scopeFilterByDOB($q, $date_of_birth) {
		if (!$date_of_birth) {
			return $q;
		}
		return $q->where('date_of_birth', '=', $date_of_birth);
	}
}
