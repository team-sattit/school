<?php

namespace App\Model\Setup\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Designation extends Model {
	use LogsActivity;

	protected $fillable = ['name', 'description', 'is_teaching_employee', 'employee_category_id', 'top_designation_id', 'status', 'options'];
	protected $table = 'designations';
	protected $casts = ['options' => 'array'];
	protected $primaryKey = 'id';
	protected static $logName = 'setup_designations';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function getOption(string $option) {
		return array_get($this->options, $option);
	}

	public function employeeCategory() {
		return $this->belongsTo('App\Model\Setup\Employee\EmployeeCategory');
	}

	public function employeeDesignations() {
		return $this->hasMany('App\Model\Employee\EmployeeDesignation');
	}

	public function scopeFilterByTopDesignationId($q, $top_designation_id) {
		if (!$top_designation_id) {
			return $q;
		}

		return $q->where('top_designation_id', '=', $top_designation_id);
	}

	public function getDesignationWithCategoryAttribute() {
		return $this->name . ' (' . $this->employeeCategory->name . ')';
	}
	public function topDesignation() {
		return $this->belongsTo('App\Model\Setup\Employee\Designation', 'top_designation_id');
	}

	public function scopeInfo($q) {
		return $q->with('employeeCategory', 'topDesignation');
	}

	public function scopeExcludeDefault($q) {
		return $q->where('name', '<>', config('trt.system_admin_designation'));
	}

	public function scopeFilterByName($q, $name, $s = 0) {
		if (!$name) {
			return $q;
		}

		return $s ? $q->where('name', '=', $name) : $q->where('name', 'like', '%' . $name . '%');
	}

	public function scopeFilterByIsTeachingEmployee($q, $is_teaching_employee) {
		return $q->where('is_teaching_employee', '=', $is_teaching_employee);
	}

}
