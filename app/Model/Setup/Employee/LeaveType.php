<?php

namespace App\Model\Setup\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LeaveType extends Model {
	use LogsActivity;

	protected $fillable = ['name', 'alias', 'description', 'status', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'employee_leave_types';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_employee_leave_types';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function leaveRequests() {
		return $this->hasMany('App\Model\Employee\LeaveRequest', 'employee_leave_type_id');
	}
	public function leaveAllocationDetails() {
		return $this->hasMany('App\Model\Employee\LeaveAllocationDetail', 'employee_leave_type_id');
	}
}
