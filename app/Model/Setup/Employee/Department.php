<?php

namespace App\Model\Setup\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model {
	use LogsActivity;

	protected $fillable = ['name', 'code', 'description', 'status', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'departments';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_department';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function employees() {
		return $this->hasMany('App\Model\Employee\Employee');
	}
	public function employeeDesignations() {
		return $this->hasMany('App\Model\Employee\EmployeeDesignation');
	}

}
