<?php

namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LeaveRequest extends Model {
	use LogsActivity;

	protected $fillable = ['employee_id', 'employee_leave_type_id', 'start_date', 'end_date', 'description', 'status', 'requester_user_id', 'options',
	];
	protected $casts = ['options' => 'array'];
	protected $primaryKey = 'id';
	protected $table = 'employee_leave_requests';
	protected static $logName = 'employee_leave_request';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function employee() {
		return $this->belongsTo('App\Model\Employee\Employee');
	}

	public function leaveType() {
		return $this->belongsTo('App\Model\Setup\Employee\LeaveType', 'employee_leave_type_id');
	}
}
