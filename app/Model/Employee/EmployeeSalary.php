<?php

namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeSalary extends Model {
	use LogsActivity;
	protected $dates = ['date_effective', 'date_end'];
	protected $fillable = [
		'employee_id',
		'basic_salary',
		'house_rent',
		'medical_allowance',
		'transport_allowance',
		'insurance',
		'commission',
		'extra',
		'overtime',
		'total',
		'effective_from',
		'effective_to',
		'options',
	];
	protected $casts = ['options' => 'array'];
	protected $primaryKey = 'id';
	protected $table = 'employee_salaries';
	protected static $logName = 'employee_salary';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function employee() {
		return $this->belongsTo('App\Model\Employee\Employee');
	}

	public function getOption(string $option) {
		return array_get($this->options, $option);
	}

	public function scopeInfo($q) {
		return $q->with(['employee:id,code,prefix,name',
			'employee.employeeDesignations:id,employee_id,designation_id,department_id,date_effective,date_end',
			'employee.employeeDesignations.designation:id,name,employee_category_id',
			'employee.employeeDesignations.designation.employeeCategory:id,name',
			'employee.employeeDesignations.department:id,name',
		]);
	}

}
