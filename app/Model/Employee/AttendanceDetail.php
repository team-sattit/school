<?php

namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AttendanceDetail extends Model {
	use LogsActivity;

	protected $fillable = ['employee_attendance_id', 'employee_attendance_type_id', 'value', 'remarks', 'options',
	];
	protected $primaryKey = 'id';
	protected $table = 'employee_attendance_details';
	protected static $logName = 'employee_attendance_detail';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];
}
