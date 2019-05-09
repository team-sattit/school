<?php

namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Attendance extends Model {
	use LogsActivity;

	protected $fillable = ['employee_id', 'employee_attendance_type_id', 'date_of_attendance', 'remarks', 'options',
	];
	protected $primaryKey = 'id';
	protected $table = 'employee_attendances';
	protected static $logName = 'employee_attendance';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function employee() {
		return $this->belongsTo('App\Models\Employee\Employee');
	}

	public function attendanceType() {
		return $this->belongsTo('App\Models\Configuration\Employee\AttendanceType', 'employee_attendance_type_id');
	}
}
